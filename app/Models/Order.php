<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use DB;

class Order extends Model
{
    const STATUS = [
        'ORDERED' => 1,
        'PAID' => 2,
        'INTERNAL' => 3,
        'CANCELED' => 4,
        'RETURNED' => 5
    ];
    const STATUS_TEXT = [
        'ORDERED' => 'Ordered',
        'PAID' => 'Paid',
        'INTERNAL' => 'Internal',
        'CANCELED' => 'Canceled',
        'RETURNED' => 'Returned'
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
        return $this->belongsToMany('App\Models\Product', 'order_details')->withPivot('product_id', 'order_id', 'quantity', 'price')->withTimestamps();
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


}
