@extends('layouts.app')

@section('content')
<div class="py-10 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <h1 class="text-3xl font-bold text-indigo-600 mb-4 sm:mb-0">Dashboard</h1>
            <div class="flex flex-wrap gap-4">
                @if(auth()->user()->isAdmin())
                <a href="{{ route('products.create') }}"
                   class="flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                   <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                       <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                   </svg>
                   Add Product
                </a>
                @endif

                <a href="{{ route('orders.create') }}"
                   class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                   <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                       <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                   </svg>
                   Place Order
                </a>
            </div>
        </div>

        {{-- Alerts --}}
        <div>
            <x-alert-success />
            <x-alert-error />
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white shadow rounded-xl p-5 flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Products</p>
                    <p class="text-2xl font-bold">{{ $totalProducts ?? 0 }}</p>
                </div>
                <div class="text-indigo-500">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h18v4H3zM3 7h18v14H3z"/>
                    </svg>
                </div>
            </div>

            <div class="bg-white shadow rounded-xl p-5 flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Orders</p>
                    <p class="text-2xl font-bold">{{ $totalOrders ?? 0 }}</p>
                </div>
                <div class="text-green-500">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round"
                               d="M12 8c1.656 0 3 1.343 3 3s-1.344 3-3 3-3-1.343-3-3 1.344-3 3-3z"/>
                    </svg>
                </div>
            </div>

            <div class="bg-white shadow rounded-xl p-5 flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Pending Orders</p>
                    <p class="text-2xl font-bold">{{ $pendingOrders ?? 0 }}</p>
                </div>
                <div class="text-yellow-500">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round"
                               d="M12 8v4l3 3"/>
                    </svg>
                </div>
            </div>

            <div class="bg-white shadow rounded-xl p-5 flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Low Stock</p>
                    <p class="text-2xl font-bold">{{ $lowStockProducts ?? 0 }}</p>
                </div>
                <div class="text-red-500">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round"
                               d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Recent Orders --}}
        <div class="bg-white shadow rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b">
                <h3 class="font-semibold text-gray-700">Recent Orders</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-gray-700 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Order ID</th>
                            <th class="px-4 py-2 text-left">Product</th>
                            <th class="px-4 py-2 text-left">Qty</th>
                            <th class="px-4 py-2 text-left">Amount</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-2">{{ $order->id }}</td>
                            <td class="px-4 py-2">{{ $order->product->name }}</td>
                            <td class="px-4 py-2">{{ $order->quantity }}</td>
                            <td class="px-4 py-2">₹{{ number_format($order->total_price, 2) }}</td>
                            <td class="px-4 py-2">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'dispatched' => 'bg-blue-100 text-blue-800',
                                        'delivered' => 'bg-green-100 text-green-800',
                                    ];
                                @endphp
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">{{ $order->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                No recent orders found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white shadow rounded-xl p-6">
                <h3 class="font-semibold text-gray-700 mb-4">Sales Overview</h3>
                <canvas id="salesChart" class="h-64"></canvas>
            </div>
            <div class="bg-white shadow rounded-xl p-6">
                <h3 class="font-semibold text-gray-700 mb-4">Orders Status</h3>
                <canvas id="statusChart" class="h-64"></canvas>
            </div>
             
        </div>

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
        window.onload = function() {
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: @json($months),
                    datasets: [{
                        label: 'Sales (₹)',
                        data: @json($sales),
                        backgroundColor: 'rgba(99,102,241,0.2)',
                        borderColor: 'rgba(99,102,241,1)',
                        borderWidth: 2,
                        tension: 0.3
                    }]
                },
                options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
            });

            const statusCtx = document.getElementById('statusChart').getContext('2d');
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: @json(array_keys($ordersStatus)),
                    datasets: [{
                        data: @json(array_values($ordersStatus)),
                        backgroundColor: ['rgba(251,191,36,0.7)','rgba(59,130,246,0.7)','rgba(34,197,94,0.7)'],
                        borderColor: '#fff',
                        borderWidth: 1
                    }]
                },
                options: { responsive: true }
            });
        };
        </script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </div>
</div>


@endsection
