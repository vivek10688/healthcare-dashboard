<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;

class OrderService
{
    public function createOrder(array $data, $user)
    {
        $product = Product::findOrFail($data['product_id']);
        $total = $product->price * $data['quantity'];

        // Update stock
        $product->decrement('stock', $data['quantity']);

        // Save order
        return Order::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => $data['quantity'],
            'total_price' => $total,
        ]);
    }
}
