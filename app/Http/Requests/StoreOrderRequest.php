<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => ['required', 'integer', 'min:1', function ($attribute, $value, $fail) {
                $product = Product::find($this->product_id);

                if ($product && $value > $product->stock) {
                    $fail("Only {$product->stock} units of {$product->name} are available in stock.");
                }
            }],
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Please select a product to order.',
            'product_id.exists' => 'The selected product does not exist.',
            'quantity.required' => 'Please enter how many units you want to order.',
            'quantity.integer' => 'Quantity must be a valid number.',
            'quantity.min' => 'You must order at least one unit.',
        ];
    }
}
