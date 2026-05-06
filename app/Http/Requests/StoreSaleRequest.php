<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isReseller();
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'quantity'   => [
                'required',
                'integer',
                'min:1',
                // Ensure quantity does not exceed available reseller stock
                function ($attribute, $value, $fail) {
                    $stock = auth()->user()->resellerStocks()
                        ->where('product_id', $this->input('product_id'))
                        ->first();

                    if (!$stock) {
                        $fail("You do not have stock for this product.");
                        return;
                    }

                    if ((int) $value > $stock->quantity) {
                        $fail("Quantity exceeds your available stock ({$stock->quantity} units left).");
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Please select a product.',
            'product_id.exists'   => 'The selected product is no longer available.',
            'quantity.required'   => 'Please enter a quantity.',
            'quantity.integer'    => 'Quantity must be a whole number.',
            'quantity.min'        => 'Quantity must be at least 1.',
        ];
    }
}
