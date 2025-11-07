@extends('layouts.app')

@section('content')
<div class="py-10 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b px-6 py-5 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white">
                <h2 class="text-2xl font-bold tracking-tight">🛍️ Orders Overview</h2>
                <a href="http://127.0.0.1:8000/orders/create" class="mt-3 sm:mt-0 bg-white text-indigo-600 font-semibold px-5 py-2 rounded-xl shadow hover:bg-gray-100 transition">
                    + Place Order
                </a>
            </div>

            {{-- Alerts --}}
            <div class="px-6 py-4">
                <x-alert-success />
                <x-alert-error />
            </div>

            {{-- Orders Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full text-gray-700 border-collapse">
                    <thead class="bg-gray-100 sticky top-0 z-10">
                        <tr class="text-left">
                            <th class="px-4 py-3 border-b text-sm font-medium">#</th>
                            <th class="px-4 py-3 border-b text-sm font-medium">Product</th>
                            <th class="px-4 py-3 border-b text-sm font-medium">Qty</th>
                            <th class="px-4 py-3 border-b text-sm font-medium">Amount</th>
                            <th class="px-4 py-3 border-b text-sm font-medium">Ordered By</th>
                            <th class="px-4 py-3 border-b text-sm font-medium">Status</th>
                            <th class="px-4 py-3 border-b text-sm font-medium">Date</th>
                            @if(Auth::user()->isAdmin())
                                <th class="px-4 py-3 border-b text-sm font-medium text-center">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr class="border-b hover:bg-indigo-50 transition">
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 font-medium">{{ $order->product->name }}</td>
                                <td class="px-4 py-2">{{ $order->quantity }}</td>
                                <td class="px-4 py-2">₹{{ number_format($order->total_price, 2) }}</td>
                                <td class="px-4 py-2">{{ $order->user->name }}</td>
                                <td class="px-4 py-2">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'dispatched' => 'bg-blue-100 text-blue-800',
                                            'delivered' => 'bg-green-100 text-green-800',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">{{ $order->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-4 py-2 text-center">
                                    @if(Auth::user()->isAdmin() && !in_array($order->status, ['dispatched', 'delivered']))
                                        <form action="{{ route('orders.dispatch', $order) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="px-3 py-1 bg-green-600 text-white text-xs rounded-lg hover:bg-green-700 transition">
                                                Dispatch
                                            </button>
                                        </form>
                                    @elseif(Auth::user()->isProvider() && $order->status === 'dispatched')
                                        <form action="{{ route('orders.deliver', $order) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="px-3 py-1 bg-blue-600 text-white text-xs rounded-lg hover:bg-blue-700 transition">
                                                Received
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-10 text-center text-gray-500">
                                    <div class="flex flex-col items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 17v-6h6v6m2 4H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v14a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="text-lg font-medium">No orders found yet.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
