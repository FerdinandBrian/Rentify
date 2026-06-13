<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'call_number' => ['required'],
            'status' => ['required'],
            'start_rent' => ['required', 'date'],
            'end_rent' => ['required', 'date', 'after:start_rent'],
        ];
    }
}
