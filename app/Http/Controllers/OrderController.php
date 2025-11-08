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
  

    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            // Admin sees all orders
            $orders = Order::latest()->get();
        } else {
            // Providers see only their own orders
            $orders = Order::where('user_id', $user->id)->latest()->get();
        }

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();

        return view('orders.create', compact('products'));
    }

    public function store(StoreOrderRequest $request, OrderService $service)
    {
        $this->authorize('create', Order::class);

        $order = $service->createOrder($request->validated(), auth()->user());

        Mail::to(auth()->user()->email)->send(new OrderPlaced($order));

        return redirect()->back()->with('success', 'Order placed successfully...');
    }

    public function dispatch(Order $order)
    {
        // Only isAdmin can do this, extra check
        $this->authorize('dispatch', $order);
        $order->update(['status' => 'dispatched']);

        return redirect()->back()->with('success', 'Order dispatched successfully...');
    }

    public function deliver(Order $order)
    {
        // Optional: Check if the authenticated user is the owner of this order
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $order->update(['status' => 'delivered']);

        return redirect()->back()->with('success', 'Order marked as delivered...');
    }
}
