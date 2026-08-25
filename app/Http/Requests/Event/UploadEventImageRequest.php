<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class UploadEventImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp,heic', 'max:5120'],
        ];
    }
}
