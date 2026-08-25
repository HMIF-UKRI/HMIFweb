<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class SendCertificateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'certificate_file'    => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'certificate_subject' => ['nullable', 'string', 'max:255'],
            'certificate_message' => ['required', 'string', 'max:3000'],
        ];
    }
}
