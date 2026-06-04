<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'price' => ['required', 'numeric'],
            'type' => ['required'],
            'year' => ['nullable', 'integer'],
            'status' => ['required'],
            'Brand_id' => ['required', 'exists:brand,id'],
            'is_electric' => ['boolean'],
            'primary_image_id' => ['nullable', 'integer', 'exists:car_images,id'],
            'delete_image_ids' => ['nullable', 'array'],
            'delete_image_ids.*' => ['integer', 'exists:car_images,id'],
            'make_uploaded_primary' => ['nullable', 'boolean'],
            'images' => ['nullable', 'array', 'max:5'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
