@extends('layouts.app')

@section('content')


    <div class="py-10">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-100">
            <div class="px-8 py-6 bg-gray-50 border-b flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-700 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" class="w-6 h-6 text-indigo-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 3h18v4H3zM3 7h18v14H3z" />
                    </svg>
                    Place a New Order
                </h2>
                <a href="{{ route('orders.index') }}"
                   class="text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Orders
                </a>
            </div>

            <div class="p-8 text-gray-900">

                {{-- Success Message --}}
                <x-alert-success />

                {{-- Validation Errors --}}
                <x-alert-error />

                {{-- Order Form --}}
                <form method="POST" action="{{ route('orders.store') }}" class="space-y-6">
                    @csrf

                    {{-- Product --}}
                    <div>
                        <label for="product_id" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Select Product') }}
                        </label>
                        <select name="product_id" id="product_id"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Choose a Product --</option>
                            @foreach ($products as $product)
                                @if($product->stock > 0)
                                    <option value="{{ $product->id }}"
                                        {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} — {{ $product->stock }} in stock
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    {{-- Quantity --}}
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Quantity') }}
                        </label>
                        <input id="quantity" name="quantity" type="number" min="1"
                               value="{{ old('quantity', 1) }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                               required>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('orders.index') }}"
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md
                           text-gray-700 text-xs font-semibold uppercase tracking-widest hover:bg-gray-100
                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                            Cancel
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-5 py-2 bg-indigo-600 border border-transparent rounded-md
                                font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700
                                focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3 3h18v4H3zM3 7h18v14H3z" />
                            </svg>
                            {{ __('Place Order') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
