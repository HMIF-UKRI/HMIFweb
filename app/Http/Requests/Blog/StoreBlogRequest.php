<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'blog_category_id' => ['required', 'exists:blog_categories,id'],
            'title'            => ['required', 'string', 'max:255'],
            'summary'          => ['required', 'string', 'max:255'],
            'content'          => ['required', 'string'],
            'status'           => ['required', 'in:draft,published,archived'],
            'thumbnail'        => ['required', 'image', 'mimes:jpeg,png,jpg,webp,heic', 'max:5120'],
        ];
    }
}
