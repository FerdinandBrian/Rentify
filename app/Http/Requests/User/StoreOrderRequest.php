<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'car_id'      => ['required', Rule::exists('car', 'series_number')],
            'start_date'  => ['required', 'date', 'after_or_equal:today'],
            'end_date'    => ['required', 'date', 'after_or_equal:start_date'],
            // Addon bersifat opsional; setiap ID harus ada di tabel addon
            'addon_ids'   => ['nullable', 'array'],
            'addon_ids.*' => ['integer', Rule::exists('addon', 'id')],
        ];
    }
}
