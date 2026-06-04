<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'star' => ['required', 'integer', 'min:1', 'max:5'],
            'message' => ['required', 'string'],
            'Car_series_number' => ['required', 'exists:car,series_number'],
            'User_id' => ['required', 'exists:users,id'],
        ];
    }
}
