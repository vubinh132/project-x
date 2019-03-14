<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB, Log;
use App\Services\CommonService;
use App\Models\Log as LogModel;
use Carbon\Carbon;

class Order extends Model
{
    const STATUS = [
        'ORDERED' => 'N',
        'PAID' => 'P',
        'INTERNAL' => 'I',
        'CANCELED' => 'C',
        'RETURNED' => 'RN',
        'LOST' => 'L'
    ];
    const STATUS_TEXT = [
        'ORDERED' => 'Ordered',
        'PAID' => 'Paid',
        'INTERNAL' => 'Internal',
        'CANCELED' => 'Canceled',
        'RETURNED' => 'Returned',
        'LOST' => 'Lost'
    ];

    const SELLING_WEB = [
        'SELF' => 1,
        'LAZADA' => 2,
        'SHOPEE' => 3
    ];

    const SELLING_WEB_TEXT = [
        'SELF' => 'Self',
        'LAZADA' => 'Lazada',
        'SHOPEE' => 'Shopee'
    ];

    const PROVIDER = [
        'SEUDO' => 1,
    ];

    const PROVIDER_TEXT = [
        'SEUDO' => 'seudo',
    ];


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

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
    protected $fillable = ['code', 'status', 'name', 'phone', 'address', 'price', 'email', 'note', 'selling_web', 'created_at', 'updated_at', 'api_created_at', 'api_updated_at', 'returned', 'is_parted', 'is_special', 'provider'];

    /**
     * Get the users of role.
     */
    public function statusText()
    {
        return $this->status ? Order::STATUS_TEXT[array_keys(Order::STATUS, $this->status)[0]] : '';
    }

    public static function statusTextByCode($status)
    {
        return $status ? Order::STATUS_TEXT[array_keys(Order::STATUS, $status)[0]] : '';
    }

    public function sellingWebText()
    {
        return $this->selling_web ? Order::SELLING_WEB_TEXT[array_keys(Order::SELLING_WEB, $this->selling_web)[0]] : '';
    }


    public function providerText()
    {
        return $this->provider ? Order::PROVIDER_TEXT[array_keys(Order::PROVIDER, $this->provider)[0]] : '';
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'order_details')->using('App\Models\OrderDetail')->withPivot('product_id', 'order_id', 'quantity', 'price', 'id')->withTimestamps();
    }

    public function getCode()
    {
        return ($this->selling_web && ($this->selling_web == Order::SELLING_WEB['LAZADA'] || $this->selling_web == Order::SELLING_WEB['SHOPEE'])) ? $this->code : str_pad($this->id, 5, '0', STR_PAD_LEFT);
    }

    public function getTotalPrice()
    {
        return (float)Order::join('order_details', 'orders.id', 'order_details.order_id')->where('orders.id', $this->id)->sum('order_details.price');
    }

    public function getCreatedAt()
    {
        return $this->api_created_at ? $this->api_created_at : $this->created_at;
    }

    public function getOrderProfit()
    {
        $profit = 0;

        $products = $this->products;

        foreach ($products as $product) {
            $res = $product->pivot->getProfit();

            if ($res['success']) {
                $profit += $res['profit'];
            }
        }

        return $profit;
    }

    public static function create(array $attributes = [], array $options = [])
    {
        $model = static::query()->create($attributes);
        if (!empty($options['entity'])) {
            $entity = $options['entity'];
            $status = $model->status;
            $isManual = !empty($options['isManual']);
            OrderLog::create(['order_id' => $model->id, 'to' => $status, 'entity_id' => $entity->id, 'is_manual' => $isManual, 'creation_time' => Carbon::now()]);
            if ($isManual) {
                $orderCode = $model->getCode();
                CommonService::writeLog(LogModel::CATEGORY['ACTIVITIES'], $entity->username . " have created a new order $orderCode - ($status)");
            }
        }
        return $model;
    }

    public function update(array $attributes = [], array $options = [])
    {
        if (!$this->exists) {
            return false;
        }

        $oldStatus = $this->status;

        $res = $this->fill($attributes)->save($options);

        if (!empty($attributes['status']) && !empty($options['entity'])) {
            $entity = $options['entity'];
            $newStatus = $attributes['status'];
            $isManual = !empty($options['isManual']);
            if ($newStatus != $oldStatus) {
                OrderLog::create(['order_id' => $this->id, 'from' => $oldStatus, 'to' => $newStatus, 'entity_id' => $entity->id, 'is_manual' => $isManual, 'creation_time' => Carbon::now()]);
                if ($isManual) {
                    $orderCode = $this->getCode();
                    CommonService::writeLog(LogModel::CATEGORY['ACTIVITIES'], $entity->username . " have updated order $orderCode: ($oldStatus) -> ($newStatus)");
                }
            }
        }
        return $res;
    }


    public function logs()
    {
        return $this->hasMany('App\Models\OrderLog', 'order_id')->orderBy('id');
    }


}
