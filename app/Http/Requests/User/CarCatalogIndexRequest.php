<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CarCatalogIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'brand' => ['nullable', 'integer'],
            'type' => ['nullable', 'string'],
            'search' => ['nullable', 'string', 'max:100'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ];
    }
}
