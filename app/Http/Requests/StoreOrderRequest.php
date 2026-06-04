<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'unique:order,id'],
            'name' => ['required'],
            'call_number' => ['required'],
            'email' => ['nullable', 'email'],
            'status' => ['required'],
            'start_rent' => ['required', 'date'],
            'end_rent' => ['required', 'date', 'after:start_rent'],
            'Car_series_number' => ['required', 'exists:car,series_number'],
            'User_id' => ['required', 'exists:users,id'],
        ];
    }
}
