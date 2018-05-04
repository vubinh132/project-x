<?php

namespace App\Services;

use App;
use Log;
use App\Models\Product;


class HTMLService
{
    public static function getOrderTotalPrice($order)
    {
        $textClass = $order->getTotalPrice()  >= 0 ? 'text-info' : 'text-danger';
        $price =  $order->getTotalPrice() >=0 ?  CommonService::formatPrice($order->getTotalPrice()): CommonService::formatPrice(-$order->getTotalPrice());
        return "<td class='$textClass'>$price</td>";
    }
    public static function getProductQuantity($product){
        $available = $product->getAvailableQuantity();
        $inOrder = -$product->getInOrderQuantity();
        $sold = -$product->getSoldQuantity();
        return $product->status != Product::STATUS['RESEARCH']? "<td><span class='text-info'>$available</span> | <span class='text-danger'>$inOrder</span> | <span class='text-success'>$sold</span></td>" : "<td>-</td>";
    }

    public static function getAVGPrice($product){
        $AVGPrice = $product->getAVGValue();
        if($AVGPrice){
            return "<td>".CommonService::formatPrice($AVGPrice)."</td>";
        }
        return "<td>-</td>";
}
}