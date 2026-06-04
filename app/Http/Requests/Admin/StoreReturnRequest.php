<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreReturnRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => ['required', 'exists:order,id'],
            'return_condition_note' => ['nullable', 'string', 'max:1000'],
            'penalties' => ['nullable', 'array'],
            'penalties.*' => ['string'],
            'custom_penalty_desc' => ['nullable', 'string', 'required_with:custom_penalty_amount'],
            'custom_penalty_amount' => ['nullable', 'numeric', 'min:0', 'required_with:custom_penalty_desc'],
            'payment_method' => ['nullable', 'string'],
            'payment_status' => ['nullable', 'string'],
        ];
    }
}
