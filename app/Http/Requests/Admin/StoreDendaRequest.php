<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreDendaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'car_series_number' => ['required', 'string', 'exists:car,series_number'],
            'payment_id' => ['required', 'integer', 'exists:payment,id'],
            'type' => ['required', 'string', 'max:255'],
            'total_penalty' => ['required', 'numeric', 'min:0'],
        ];
    }
}
