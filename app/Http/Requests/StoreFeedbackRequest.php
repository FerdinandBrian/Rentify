<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Only customers (role_id = 3) can submit feedback
        return $this->user() && $this->user()->role_id === 3;
    }

    public function rules(): array
    {
        return [
            'star' => ['required', 'integer', 'min:1', 'max:5'],
            'message' => ['required', 'string', 'max:1000'],
        ];
    }
}
