<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'document_type' => ['required', 'in:KTP,SIM,STNK,Paspor'],
            'document_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }
}
