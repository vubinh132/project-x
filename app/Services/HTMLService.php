<?php

namespace App\Services;

use App, Log;
use App\Models\Product;
use App\Models\Order;


class HTMLService
{
    public static function getOrderTotalPrice($order)
    {
        $textClass = $order->getTotalPrice() >= 0 ? 'text-info' : 'text-danger';
        $totalPrice = $order->getTotalPrice() >= 0 ? CommonService::formatPrice($order->getTotalPrice()) : CommonService::formatPrice(-$order->getTotalPrice());
        return "<span class='$textClass'>$totalPrice</span>";
    }

    public static function getOrderDetails($products)
    {
        $html = '';
        foreach ($products as $product) {
            $sku = "<span>$product->sku</span>";
            $quantity = str_pad(abs($product->pivot->quantity), 2, '0', STR_PAD_LEFT);
            $quantityHTML = "<span>$quantity</span>";
            $price = $product->pivot->price;
            $priceHTML = $price >= 0 ? "<span class=\"text-info\">" . CommonService::formatPrice(abs($price)) . "</span>" : "<span class=\"text-danger\">" . CommonService::formatPrice(abs($price)) . "</span>";
            $unitPrice = CommonService::formatPrice(ceil(abs($price / $product->pivot->quantity)));
            $unitPriceHTML = "<span>$unitPrice</span>";
            $html = $html . "<tr><td style=\"width: 70px\">$sku</td><td style=\"width: 50px\">$unitPriceHTML</td><td style=\"width: 20px;\">x</td><td style=\"width: 18px\">$quantityHTML</td><td style=\"width: 90px\">$priceHTML</td></tr>";
        }
        return $html;
    }

    public static function getAVGProfit($array)
    {
        if (is_null($array)) {
            return "<span>-</span>";
        } elseif ($array == 0) {
            return "<span>0</span>";
        } else {
            $all = $array['all'];
            return $all >= 0 ? "<span class=\"text-info\">" . CommonService::formatPrice(abs($all)) . "</span>" : "<span class=\"text-danger\">" . CommonService::formatPrice(abs($all)) . "</span>";
        }

    }

    public static function getAVGProfitDetails($array)
    {
        if (!$array) {
            return 'no data...';
        } else {
            $html = "";
            foreach ($array as $key => $value) {
                if (is_null($value)) {
                    $html = $html . "<tr><td style=\"width: 50px\">$key</td><td style=\"width: 100px\">0</td></tr>";
                } else {
                    $valueHTML = $value >= 0 ? "<span class=\"text-info\">" . CommonService::formatPrice(abs($value)) . "</span>" : "<span class=\"text-danger\">" . CommonService::formatPrice(abs($value)) . "</span>";
                    $html = $html . "<tr><td style=\"width: 50px\">$key</td><td style=\"width: 100px\">" . $valueHTML . "</td></tr>";

                }
            }
            return $html;
        }
    }

    public static function getSellingSpeedDetails($array)
    {
        if (!$array) {
            return 'no data...';
        } else {
            $html = "";
            foreach ($array as $key => $value) {
                $html = $html . "<tr><td style=\"width: 100px\">$key</td><td style=\"width: 100px\">" . abs($value) . "</td></tr>";
            }
            return $html;
        }
    }

    public static function getProductQuantity($product)
    {
        $available = $product->getAvailableQuantity();
        $inOrder = -$product->getInOrderQuantity();
        $sold = -$product->getSoldQuantity();
        return $product->status != Product::STATUS['RESEARCH'] ? "<span class='text-info'>$available</span> | <span class='text-danger'>$inOrder</span> | <span class='text-success'>$sold</span>" : "-";
    }

    public static function getAVGValue($product)
    {
        $AVGPrice = $product->getAVGValue();
        if ($AVGPrice) {
            return CommonService::formatPrice($AVGPrice);
        }
        return "-";
    }

    public static function getProductCheckingQuantity($total, $notReceived, $irregular, $lzd, $sku)
    {
        $remain = $total - $notReceived - $irregular - $lzd;
        $html = "<span class='text-info'>$total</span> (*) <span class='text-danger'>$notReceived</span> (*) <span class='text-warning'>$irregular</span> (*) <span class='text-primary' id='lzd_$sku'>$lzd</span> (*) <span class='text-success' id='remain_$sku'>$remain</span>";
        return [
            'remain' => $remain,
            'html' => $html
        ];
    }
}