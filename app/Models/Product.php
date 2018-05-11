<?php

namespace App\Models;

use App\Services\CommonService;
use Illuminate\Database\Eloquent\Model;
use File, DB;

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
    protected $fillable = ['sku', 'status', 'old_price', 'price', 'description', 'content', 'image_url', 'quantity', 'name'];

    /**
     * Get the users of role.
     */
    public function statusText()
    {
        return $this->status ? Product::STATUS_TEXT[array_keys(Product::STATUS, $this->status)[0]] : '';
    }

    public function imageUrl()
    {
        if (!empty($this->image_url) && File::exists(public_path(config('constants.PRODUCT_IMAGE_FOLDER')) . '/' . $this->image_url)) {
            return asset(config('constants.PRODUCT_IMAGE_FOLDER') . '/' . $this->image_url);
        }
        return asset('images/product.png');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order', 'order_details')->withPivot('product_id', 'order_id', 'price', 'display_name');
    }

    public function getAvailableQuantity()
    {
        return Product::join('order_details', 'order_details.product_id', 'products.id')->join('orders', 'orders.id', 'order_details.order_id')->where('products.id', $this->id)->whereNotIn('orders.status', [Order::STATUS['CANCEL']])->sum('order_details.quantity');
    }

    public function getInOrderQuantity()
    {
        return Product::join('order_details', 'order_details.product_id', 'products.id')->join('orders', 'orders.id', 'order_details.order_id')->where('products.id', $this->id)->where('orders.status', Order::STATUS['ORDERED'])->sum('order_details.quantity');
    }

    public function getSoldQuantity()
    {
        return Product::join('order_details', 'order_details.product_id', 'products.id')->join('orders', 'orders.id', 'order_details.order_id')->where('products.id', $this->id)->where('orders.status', Order::STATUS['PAID'])->sum('order_details.quantity');
    }

    public function getAVGValue()
    {
        $available = $this->getAvailableQuantity();
        $AVGValue = null;
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
                ->where('orders.status', Order::STATUS['PAID'])
                ->orderBy('order_details.created_at', 'asc')
                ->get(['order_details.quantity', 'order_details.price']);

            $prices = DB::table('order_details')
                ->join('products', 'products.id', 'order_details.product_id')
                ->join('orders', 'orders.id', 'order_details.order_id')
                ->where('products.id', $this->id)
                ->where('orders.status', Order::STATUS['INTERNAL'])
                ->orderBy('order_details.created_at', 'asc')
                ->get(['order_details.quantity', 'order_details.price']);

            foreach ($orders as $element) {
                $quantity = abs($element->quantity);
                $unitPrice = abs($element->price) / $quantity;
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

    public
    function canDelete()
    {
        return !$this->orders()->count();
    }


}
