<?php

namespace App\Models;

use Faker\Provider\Image;
use Illuminate\Database\Eloquent\Model;
use File, DB, Exception, Log;
use Carbon\Carbon;
use GuzzleHttp\Client;

class Product extends Model
{
    const STATUS = [
        'RESEARCH' => 1,
        'IN_BUSINESS' => 2,
        'OUT_OF_BUSINESS' => 3
    ];
    const STATUS_TEXT = [
        'RESEARCH' => 'Research',
        'IN_BUSINESS' => 'In business',
        'OUT_OF_BUSINESS' => 'Out of business',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['sku', 'status', 'old_price', 'price', 'description', 'content', 'image_url', 'quantity', 'name', 'quantity_checking_time'];

    /**
     * Get the users of role.
     */
    public function statusText()
    {
        return $this->status ? Product::STATUS_TEXT[array_keys(Product::STATUS, $this->status)[0]] : '';
    }


    public function orders()
    {
        return $this->belongsToMany('App\Models\Order', 'order_details')->withPivot('product_id', 'order_id', 'price', 'display_name');
    }

    //get all orders exclude returned and canceled
    public function getAvailableQuantity()
    {
        return Product::join('order_details', 'order_details.product_id', 'products.id')->join('orders', 'orders.id', 'order_details.order_id')->where('products.id', $this->id)->whereNotIn('orders.status', [Order::STATUS['CANCELED'], Order::STATUS['NOT_RECEIVED'], Order::STATUS['RECEIVED']])->sum('order_details.quantity');
    }

    //get all ordered orders
    public function getInOrderQuantity()
    {
        return Product::join('order_details', 'order_details.product_id', 'products.id')->join('orders', 'orders.id', 'order_details.order_id')->where('products.id', $this->id)->where('orders.status', Order::STATUS['ORDERED'])->sum('order_details.quantity');
    }

    //get all paid orders
    public function getSoldQuantity()
    {
        return Product::join('order_details', 'order_details.product_id', 'products.id')->join('orders', 'orders.id', 'order_details.order_id')->where('products.id', $this->id)->where('orders.status', Order::STATUS['PAID'])->sum('order_details.quantity');
    }

    public function getNotReturnedQuantity()
    {
        $quantity = Order::select(DB::raw('sum(order_details.quantity) as quantity'))
            ->join('order_details', 'order_details.order_id', 'orders.id')
            ->where('orders.status', Order::STATUS['NOT_RECEIVED'])
            ->where('order_details.product_id', $this->id)
            ->where(function ($query) {
                $query->where('orders.returned', null)
                    ->orWhere('orders.returned', false);
            })
            ->first()->quantity;
        return abs($quantity);
    }

    //by AVAILABLE orders, return 0 when AVAILABLE = 0, otherwise return positive
    //TODO: return positive when available < 0
    public function getAVGValue()
    {
        $available = $this->getAvailableQuantity();
        if ($available) {
            $totalPrice = 0;
            $remain = $available;
            $prices = DB::table('order_details')
                ->join('products', 'products.id', 'order_details.product_id')
                ->join('orders', 'orders.id', 'order_details.order_id')
                ->where('products.id', $this->id)
                ->where('orders.status', Order::STATUS['INTERNAL'])
                ->orderBy('order_details.created_at', 'desc')
                ->get(['order_details.quantity', 'order_details.price']);
            foreach ($prices as $price) {
                $quantity = $price->quantity;
                if ($remain >= $quantity) {
                    $totalPrice += -$price->price;
                    $remain = $remain - $quantity;
                } else {
                    $avg = -$price->price / $quantity;
                    $totalPrice += ($avg * $remain);
                    $remain = 0;
                }
                if (!$remain) {
                    break;
                }
            }
            $AVGValue = ceil($totalPrice / $available);
        } else {
            $AVGValue = 0;
        }
        return $AVGValue;
    }

    //by PAID and LOST orders, throw exception when sum (paid + lost) orders > sum internal orders. If is lost order, unit price will be 0
    //TODO: ordered orders
    public function getAVGProfit()
    {
        if (!$this->getAvailableQuantity() && !$this->getInOrderQuantity() && !$this->getSoldQuantity()) {
            return null;
        } else {
            $avgProfit = [];

            $result = [];

            $orderArray = [];

            $priceArray = [];

            $orders = DB::table('order_details')
                ->join('products', 'products.id', 'order_details.product_id')
                ->join('orders', 'orders.id', 'order_details.order_id')
                ->where('products.id', $this->id)
                ->whereIn('orders.status', [Order::STATUS['PAID'], Order::STATUS['LOST']])
                ->orderBy('order_details.created_at', 'asc')
                ->get(['order_details.quantity', 'order_details.price', 'orders.status']);

            $prices = DB::table('order_details')
                ->join('products', 'products.id', 'order_details.product_id')
                ->join('orders', 'orders.id', 'order_details.order_id')
                ->where('products.id', $this->id)
                ->where('orders.status', Order::STATUS['INTERNAL'])
                ->orderBy('order_details.created_at', 'asc')
                ->get(['order_details.quantity', 'order_details.price']);

            foreach ($orders as $element) {
                $quantity = abs($element->quantity);
                $unitPrice = $element->status == Order::STATUS['PAID'] ? abs($element->price) / $quantity : 0;
                for ($i = 0; $i < $quantity; $i++) {
                    array_push($orderArray, $unitPrice);
                }
            }

            foreach ($prices as $element) {
                $quantity = abs($element->quantity);
                $unitPrice = abs($element->price) / $quantity;
                for ($i = 0; $i < $quantity; $i++) {
                    array_push($priceArray, $unitPrice);
                }
            }

            for ($i = count($orderArray) - 1; $i >= 0; $i--) {
                array_push($avgProfit, ($orderArray[$i] - $priceArray[$i]));
            }

            if (!$avgProfit) {
                return 0;
            }

            //1
            $totalPrice = 0;
            for ($i = 0; $i < 1; $i++) {
                $totalPrice += $avgProfit[$i];
            }
            $result[1] = $totalPrice / 1;


            //5
            if (count($avgProfit) >= 5) {
                $totalPrice = 0;
                for ($i = 0; $i < 5; $i++) {
                    $totalPrice += $avgProfit[$i];
                }
                $result[5] = $totalPrice / 5;
            } else {
                $result[5] = null;
            }

            //10
            if (count($avgProfit) >= 10) {
                $totalPrice = 0;
                for ($i = 0; $i < 10; $i++) {
                    $totalPrice += $avgProfit[$i];
                }
                $result[10] = $totalPrice / 10;
            } else {
                $result[10] = null;
            }

            //50
            if (count($avgProfit) >= 50) {
                $totalPrice = 0;
                for ($i = 0; $i < 50; $i++) {
                    $totalPrice += $avgProfit[$i];
                }
                $result[50] = $totalPrice / 50;
            } else {
                $result[50] = null;
            }

            //100
            if (count($avgProfit) >= 100) {
                $totalPrice = 0;
                for ($i = 0; $i < 100; $i++) {
                    $totalPrice += $avgProfit[$i];
                }
                $result[100] = $totalPrice / 100;
            } else {
                $result[100] = null;
            }

            //all
            $totalPrice = 0;
            for ($i = 0; $i < count($avgProfit); $i++) {
                $totalPrice += $avgProfit[$i];
            }
            $result['all'] = $totalPrice / count($avgProfit);


            return $result;

        }
    }

    //by PAID orders
    public function getSellingSpeed()
    {
        if (!$this->getAvailableQuantity() && !$this->getInOrderQuantity() && !$this->getSoldQuantity()) {
            return '-';
        } else {
            $firstOrder = DB::table('order_details')
                ->where('product_id', $this->id)
                ->orderBy('created_at')
                ->first();
            $firstTime = $firstOrder->created_at;
            $day = Carbon::now()->diffInDays(new Carbon($firstTime)) + 1;
            $soldQuantity = $this->getSoldQuantity();
            $result = round(-$soldQuantity / $day, 3);
            return $result;
        }
    }

    //by PAID orders
    public function getSellingSpeedDetails()
    {
        if (!$this->getAvailableQuantity() && !$this->getInOrderQuantity() && !$this->getSoldQuantity()) {

            return null;

        } else {

            $today = Carbon::now()->startOfDay();

            $yesterday = Carbon::now()->subDay(1)->startOfDay();

            $last7Days = Carbon::now()->subDay(6)->startOfDay();

            $thisMonth = Carbon::now()->startOfMonth();

            $result = [];
            $todayQ = DB::table('order_details')
                ->join('orders', 'orders.id', 'order_details.order_id')
                ->where('orders.status', Order::STATUS['PAID'])
                ->where('order_details.product_id', $this->id)
                ->where('order_details.updated_at', '>=', $today)
                ->sum('order_details.quantity');
            $result['Today'] = $todayQ;

            $yesterdayQ = DB::table('order_details')
                ->join('orders', 'orders.id', 'order_details.order_id')
                ->where('orders.status', Order::STATUS['PAID'])
                ->where('order_details.product_id', $this->id)
                ->where('order_details.updated_at', '>=', $yesterday)
                ->where('order_details.updated_at', '<', $today)
                ->sum('order_details.quantity');
            $result['Yesterday'] = $yesterdayQ;

            $last7DaysQ = DB::table('order_details')
                ->join('orders', 'orders.id', 'order_details.order_id')
                ->where('orders.status', Order::STATUS['PAID'])
                ->where('order_details.product_id', $this->id)
                ->where('order_details.updated_at', '>=', $last7Days)
                ->sum('order_details.quantity');
            $result['Last 7 days'] = $last7DaysQ;

            $thisMonthQ = DB::table('order_details')
                ->join('orders', 'orders.id', 'order_details.order_id')
                ->where('orders.status', Order::STATUS['PAID'])
                ->where('order_details.product_id', $this->id)
                ->where('order_details.updated_at', '>=', $thisMonth)
                ->sum('order_details.quantity');
            $result['This month'] = $thisMonthQ;

            return $result;
        }
    }

    //can not delete when this product have ANY order
    public function canDelete()
    {
        return !$this->orders()->count();
    }

    public function uploadImageToDropbox($image, $imageName)
    {
        $client = new Client();
        try {
            $client->post('https://content.dropboxapi.com/2/files/upload', [
                'headers' => [
                    'Content-Type' => 'application/octet-stream',
                    'Authorization' => 'Bearer ' . env('DROPBOX_ACCESS_TOKEN'),
                    'Dropbox-API-Arg' => "{\"path\": \"/products/$imageName\"}"
                ],
                'body' => $image
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }

        //delete image and update new image name if don't throw exception
        $oldImageName = $this->image_url;
        if ($oldImageName) {
            $client->post('https://api.dropboxapi.com/2/files/delete_v2', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . env('DROPBOX_ACCESS_TOKEN')
                ],
                'json' => ['path' => '/products/' . $oldImageName]
            ]);
        }
        $this->update(['image_url' => $imageName]);
        return true;
    }

    public function getImageLinkOnDropbox()
    {
        if ($this->image_url) {
            try {
                $client = new Client();
                $res = $client->post('https://api.dropboxapi.com/2/files/get_temporary_link', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . env('DROPBOX_ACCESS_TOKEN')
                    ],
                    'json' => ['path' => '/products/' . $this->image_url]
                ]);

                $body = json_decode($res->getBody()->getContents(), true);

                return $body['link'];
            } catch (Exception $e) {
                Log::error($e->getMessage());
                return config('constants.DROPBOX_DEFAULT_IMAGE');
            }
        } else {
            return config('constants.DROPBOX_DEFAULT_IMAGE');
        }
    }

}
