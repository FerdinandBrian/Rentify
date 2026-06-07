<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'unique:payment,id'],
            'method' => ['required'],
            'status' => ['required'],
            'total_price' => ['nullable', 'numeric'],
            'Order_id' => ['required', 'exists:order,id'],
        ];
    }
}
