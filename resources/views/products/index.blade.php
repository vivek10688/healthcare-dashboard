@extends('layouts.app')

@section('content')
<div class="py-10 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b px-6 py-5 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white">
                <h2 class="text-2xl font-bold tracking-tight">🛍️ Product Inventory</h2>
                <a href="{{ route('products.create') }}"
                   class="mt-3 sm:mt-0 bg-white text-indigo-600 font-semibold px-5 py-2 rounded-xl shadow hover:bg-gray-100 transition">
                    + Add New Product
                </a>
            </div>

            <!-- Alerts -->
            <div class="px-6 py-4">
                <x-alert-success />
                <x-alert-error />
            </div>

            <!-- Product Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse w-full">
                    <thead class="bg-gray-100 border-b text-gray-700 uppercase text-sm">
                        <tr>
                            <th class="px-6 py-3 text-left">#</th>
                            <th class="px-6 py-3 text-left">Product Name</th>
                            <th class="px-6 py-3 text-left">Description</th>
                            <th class="px-6 py-3 text-left">Price</th>
                            <th class="px-6 py-3 text-left">Stock</th>
                            @if(Auth::user()->isAdmin())
                                <th class="px-4 py-2 border-b text-center">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($products as $product)
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="px-6 py-4 text-gray-600">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 font-semibold text-gray-800">{{ $product->name }}</td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $product->description ?? '—' }}
                                </td>
                                <td class="px-6 py-4 text-indigo-600 font-bold">
                                    ${{ number_format($product->price, 2) }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($product->stock > 20)
                                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">
                                            In Stock ({{ $product->stock }})
                                        </span>
                                    @elseif ($product->stock > 0)
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-3 py-1 rounded-full">
                                            Low Stock ({{ $product->stock }})
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-800 text-xs font-semibold px-3 py-1 rounded-full">
                                            Out of Stock
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 border flex items-center space-x-2">
                                    <!-- Edit Button -->
                                    <a href="{{ route('products.edit', $product) }}"
                                       class="text-blue-600 hover:text-blue-800 transition flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-7-7l7 7-7 7"/>
                                        </svg>
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-6 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-10 h-10 text-gray-400 mb-2" fill="none" stroke="currentColor" stroke-width="2"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M3 3h18M9 3v18M15 3v18M3 21h18"></path>
                                        </svg>
                                        <p>No products found.</p>
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
