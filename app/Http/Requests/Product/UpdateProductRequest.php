<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'             => ['required', 'string', 'max:255'],
            'price'             => ['required', 'numeric'],
            'discount'          => ['required', 'numeric'],
            'description'       => ['required', 'string'],
            'variants'          => ['required'],
            'thumbnail'         => ['nullable', 'image'],
            'extraImages.*'     => ['nullable', 'image'],
        ];
    }
}
