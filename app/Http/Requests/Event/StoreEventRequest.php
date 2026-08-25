<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_category_id'   => ['required', 'exists:event_categories,id'],
            'period_id'           => ['required', 'exists:periods,id'],
            'title'               => ['required', 'string', 'max:255'],
            'short_description'   => ['required', 'string', 'max:255'],
            'description'         => ['required', 'string'],
            'event_date'          => ['required', 'date'],
            'location'            => ['required', 'string', 'max:255'],
            'whatsapp_group_link' => ['nullable', 'url', 'max:500'],
            'status'              => ['required', 'in:upcoming,ongoing,completed,cancelled'],
            'thumbnail'           => ['required', 'image', 'mimes:jpeg,png,jpg,webp,heic', 'max:5120'],
        ];
    }
}
