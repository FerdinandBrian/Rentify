<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'call_number' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'status' => ['required', Rule::in(['menunggu', 'aktif', 'selesai', 'dibatalkan'])],
            'start_rent' => ['required', 'date'],
            'end_rent' => ['required', 'date', 'after_or_equal:start_rent'],
        ];
    }
}
