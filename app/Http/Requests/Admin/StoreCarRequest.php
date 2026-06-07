<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'series_number' => ['required', 'unique:car,series_number'],
            'name' => ['required'],
            'price' => ['required', 'numeric'],
            'type' => ['required'],
            'year' => ['nullable', 'integer'],
            'status' => ['required'],
            'Brand_id' => ['required', 'exists:brand,id'],
            'is_electric' => ['boolean'],
            'images' => ['nullable', 'array', 'max:5'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
