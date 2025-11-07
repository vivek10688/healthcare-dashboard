<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
{
    $user = auth()->user();

    if ($user->isAdmin()) {
        // Admin stats (you already have this)
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $lowStockProducts = Product::where('stock', '<', 10)->count();

        $recentOrders = Order::with('product')->latest()->take(5)->get();

        $salesData = Order::selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $months = $salesData->keys()->map(fn($m) => \Carbon\Carbon::create()->month($m)->format('M'))->toArray();
        $sales = $salesData->values()->toArray();

        $ordersStatus = Order::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return view('dashboard', compact(
            'totalProducts','totalOrders','pendingOrders','lowStockProducts',
            'recentOrders','months','sales','ordersStatus'
        ));
    }

    if ($user->isProvider()) {
        // Provider stats
        $myOrders = Order::with('product')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $pendingDeliveries = $myOrders->where('status','dispatched')->count();
        $completedDeliveries = $myOrders->where('status','delivered')->count();

        $ordersStatus = $myOrders->groupBy('status')->map->count()->toArray();

        return view('provider', compact(
            'myOrders', 'pendingDeliveries', 'completedDeliveries', 'ordersStatus'
        ));
    }

    return redirect()->route('dashboard');
}

}
