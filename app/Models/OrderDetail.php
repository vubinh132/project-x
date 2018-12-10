<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property mixed id
 */
class OrderDetail extends Pivot
{

    //return null if the order status is not ordered or paid.
    //IN: internal orders
    //OUT: ordered, paid, lost orders
    public function getProfit()
    {
//        if ($this->pivotParent->status == Order::STATUS['ORDERED'] || $this->pivotParent->status == Order::STATUS['PAID']) {
        $profit = 0;
        $productId = $this->product_id;
        $quantity = $this->quantity;
        $price = $this->price;
        $avgPrice = -($price / $quantity);

        $inOrders = Order::join('order_details', 'orders.id', 'order_details.order_id')
            ->where('orders.status', Order::STATUS['INTERNAL'])
            ->where('order_details.product_id', $productId)
            ->orderBy('order_details.created_at', 'asc')
            ->get(['order_details.price as price', 'order_details.quantity as quantity']);

        $orderIndexEnd = Order::join('order_details', 'orders.id', 'order_details.order_id')
            ->whereIn('orders.status', [Order::STATUS['ORDERED'], Order::STATUS['PAID'], Order::STATUS['LOST']])
            ->where('order_details.product_id', $this->product_id)
            ->where('order_details.created_at', '<=', $this->created_at)
            ->orderBy('order_details.created_at', 'asc')
            ->sum('order_details.quantity');

        $orderIndex = [abs($orderIndexEnd) + $quantity + 1, abs($orderIndexEnd)];

        $inOrderArray = [];

        foreach ($inOrders as $inOrder) {
            for ($i = 1; $i <= $inOrder->quantity; $i++) {
                $inOrderArray[] = abs($inOrder->price / $inOrder->quantity);
            }
        }

        if ($orderIndex[1] > count($inOrderArray)) {
            return [
                'success' => false,
                'message' => "product $productId have invalid quantity"
            ];
        }
        for ($i = $orderIndex[0]; $i <= $orderIndex[1]; $i++) {
            $profit += ($avgPrice - $inOrderArray[$i - 1]);
        }

        return [
            'success' => true,
            'profit' => ceil($profit)
        ];
//        }
        return [
            'success' => false,
            'message' => 'this order is not ordered or paid order'
        ];
    }
}