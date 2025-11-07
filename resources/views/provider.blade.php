@extends('layouts.app')

@section('content')
<div class="py-10 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <h1 class="text-3xl font-bold text-indigo-600">Provider Dashboard</h1>

        {{-- Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white shadow rounded-xl p-5 text-center">
                <p class="text-gray-500">Pending Deliveries</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $pendingDeliveries }}</p>
            </div>
            <div class="bg-white shadow rounded-xl p-5 text-center">
                <p class="text-gray-500">Completed Deliveries</p>
                <p class="text-2xl font-bold text-green-600">{{ $completedDeliveries }}</p>
            </div>
            <div class="bg-white shadow rounded-xl p-5 text-center">
                <p class="text-gray-500">Total Orders</p>
                <p class="text-2xl font-bold text-gray-700">{{ $myOrders->count() }}</p>
            </div>
        </div>

        {{-- Orders Table --}}
        <div class="bg-white shadow rounded-xl overflow-x-auto p-6">
            <h3 class="font-semibold text-gray-700 mb-4">My Orders</h3>
            <table class="min-w-full text-gray-700 text-sm border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Order ID</th>
                        <th class="px-4 py-2 text-left">Product</th>
                        <th class="px-4 py-2 text-center">Qty</th>
                        <th class="px-4 py-2 text-right">Amount</th>
                        <th class="px-4 py-2 text-center">Status</th>
                        <th class="px-4 py-2 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($myOrders as $order)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-2 text-left">{{ $order->id }}</td>
                        <td class="px-4 py-2 text-left">{{ $order->product->name }}</td>
                        <td class="px-4 py-2 text-center">{{ $order->quantity }}</td>
                        <td class="px-4 py-2 text-right">₹{{ number_format($order->total_price, 2) }}</td>
                        <td class="px-4 py-2 text-center">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                {{ $order->status == 'dispatched' ? 'bg-yellow-100 text-yellow-800' : ($order->status == 'delivered' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            @if($order->status === 'dispatched')
                                <form action="{{ route('orders.deliver', $order) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition">
                                        Mark as Delivered
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 text-xs">No Action</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">No orders assigned yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        {{-- Orders Status Chart --}}
        <div class="bg-white shadow rounded-xl p-4 mt-6 w-full sm:w-1/2 lg:w-1/3">
            <h3 class="font-semibold text-gray-700 mb-2 text-sm">Orders Status</h3>
            <canvas id="statusChart" class="h-32"></canvas> <!-- smaller height -->
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('statusChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: @json(array_keys($ordersStatus)),
                    datasets: [{
                        data: @json(array_values($ordersStatus)),
                        backgroundColor: ['#facc15', '#3b82f6', '#22c55e'],
                        borderWidth: 1
                    }]
                },
                options: { responsive: true }
            });
        </script>

    </div>
</div>
@endsection
