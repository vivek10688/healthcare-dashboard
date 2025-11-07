@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-8 rounded-2xl shadow-lg">
            <!-- Header -->
            <div class="mb-8 border-b pb-4 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-indigo-600 flex items-center gap-2">
                    ✏️ Edit Product
                </h2>
                <a href="{{ route('products.index') }}"
                   class="text-sm bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                    ← Back to List
                </a>
            </div>

            <!-- Alerts -->
            <x-alert-success />
            <x-alert-error />

            <form action="{{ route('products.update', $product) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Product Name -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Product Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}"
                           class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm p-3 @error('name') border-red-500 @enderror"
                           placeholder="Enter product name">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Price ($) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}"
                           class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm p-3 @error('price') border-red-500 @enderror"
                           placeholder="Enter price">
                    @error('price')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stock -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Stock <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                           class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm p-3 @error('stock') border-red-500 @enderror"
                           placeholder="Enter stock quantity">
                    @error('stock')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Description
                    </label>
                    <textarea name="description" rows="4"
                              class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm p-3 @error('description') border-red-500 @enderror"
                              placeholder="Write product details...">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-3 pt-4 border-t">
                    <a href="{{ route('products.index') }}"
                       class="px-5 py-2 bg-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-300 transition">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 shadow-sm transition">
                        💾 Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
