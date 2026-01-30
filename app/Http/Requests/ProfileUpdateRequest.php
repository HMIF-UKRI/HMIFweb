<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name'     => ['required', 'string', 'max:255'],
            'npm'           => ['required', 'string', 'max:20'],
            'email'         => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $this->user()->id],
            'no_hp'         => ['nullable', 'string', 'max:20'],
            'instagram_url' => ['nullable', 'url'],
            'linkedin_url'  => ['nullable', 'url'],
            'avatar'        => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }
}
