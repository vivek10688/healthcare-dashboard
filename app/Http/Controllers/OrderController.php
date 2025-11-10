<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Mail\OrderPlaced;
use App\Models\Order;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        // Optional: automatically apply policy mappings for resource routes
        $this->authorizeResource(Order::class, 'order');
    }

    public function index()
    {
        $this->authorize('viewAny', Order::class);

        $user = Auth::user();

        if ($user->isAdmin()) {
            $orders = Order::latest()->get();
        } else {
            $orders = Order::where('user_id', $user->id)->latest()->get();
        }

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $this->authorize('create', Order::class);

        $products = Product::where('stock', '>', 0)->get();
        return view('orders.create', compact('products'));
    }

    public function store(StoreOrderRequest $request, OrderService $service)
    {
        $this->authorize('create', Order::class);

        DB::transaction(function () use ($request, $service, &$order) {
            // Lock stock rows to avoid concurrent updates
            $order = $service->createOrder($request->validated(), auth()->user());
        });

        Mail::to(auth()->user()->email)->send(new OrderPlaced($order));

        return redirect()->back()->with('success', 'Order placed successfully...');
    }

    public function dispatch(Order $order)
    {
        $this->authorize('dispatch', $order);

        DB::transaction(function () use ($order) {
            $order->update(['status' => 'dispatched']);
        });

        return redirect()->back()->with('success', 'Order dispatched successfully...');
    }

    public function deliver(Order $order)
    {
        $this->authorize('update', $order);

        DB::transaction(function () use ($order) {
            $order->update(['status' => 'delivered']);
        });

        return redirect()->back()->with('success', 'Order marked as delivered...');
    }

    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);

        DB::transaction(function () use ($order) {
            $order->delete();
        });

        return redirect()->back()->with('success', 'Order deleted successfully...');
    }
}
