<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Exception;

class OrderService
{
    public function createOrder(array $data, $user)
    {
        return DB::transaction(function () use ($data, $user) {
            // Lock the product record to prevent concurrent stock updates
            $product = Product::where('id', $data['product_id'])
                ->lockForUpdate()
                ->firstOrFail();

            // Check if enough stock is available
            if ($product->stock < $data['quantity']) {
                throw new \Illuminate\Validation\ValidationException(
                    validator([], []),
                    response()->json(['error' => 'Insufficient stock available for this product.'], 422)
                );
            }

            // Deduct stock safely
            $product->decrement('stock', $data['quantity']);

            // Calculate total
            $total = $product->price * $data['quantity'];

            // Create the order
            $order = Order::create([
                'user_id'     => $user->id,
                'product_id'  => $product->id,
                'quantity'    => $data['quantity'],
                'total_price' => $total,
                'status' => 'pending', 
            ]);

            return $order;
        });
    }
}
