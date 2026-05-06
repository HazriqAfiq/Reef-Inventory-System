<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'sku'             => ['required', 'string', 'max:50', 'unique:products,sku'],
            'name'            => ['required', 'string', 'max:255'],
            'product_type_id' => ['nullable', 'integer', 'exists:product_types,id'],
            'category_id'     => ['nullable', 'integer', 'exists:categories,id'],
            'volume_ml'       => ['nullable', 'integer', 'min:1'],
            'description'     => ['nullable', 'string'],
            'top_note'        => ['nullable', 'string'],
            'heart_note'      => ['nullable', 'string'],
            'base_note'       => ['nullable', 'string'],
            'fragrance_family' => ['nullable', 'string', 'in:fresh,woody,floral,oriental,gourmand'],
            'wholesale_price' => ['nullable', 'numeric', 'min:0'],
            'retail_price'    => ['nullable', 'numeric', 'min:0'],
            'stock'           => ['nullable', 'integer', 'min:0'],
            'release_date'    => ['nullable', 'date'],
            'is_active'       => ['nullable', 'boolean'],
            'images'              => ['nullable', 'array'],
            'images.*'            => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }
}
