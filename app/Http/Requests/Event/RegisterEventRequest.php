<?php

namespace App\Http\Requests\Event;

use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->user()) {
            return [
                'full_name'            => ['nullable', 'string', 'max:255'],
                'phone'                => ['nullable', 'string', 'max:30'],
                'institution'          => ['nullable', 'string', 'max:255'],
                'participant_category' => ['nullable', 'string', 'max:50'],
                'major'                => ['nullable', 'string', 'max:255'],
                'batch'                => ['nullable', 'string', 'max:30'],
                'notes'                => ['nullable', 'string', 'max:1000'],
            ];
        }

        $slug = $this->route('slug');
        $event = Event::where('slug', $slug)->first();
        $eventId = $event?->id;

        return [
            'full_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('event_registrations')->where(fn ($query) => $query->where('event_id', $eventId)),
            ],
            'phone' => ['required', 'string', 'max:30'],
            'institution' => ['required', 'string', 'max:255'],
            'participant_category' => ['required', Rule::in(['Mahasiswa', 'Pelajar', 'Pekerja', 'Umum', 'Lainnya'])],
            'major' => ['nullable', 'string', 'max:255'],
            'batch' => ['nullable', 'string', 'max:30'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Email ini sudah terdaftar untuk kegiatan ini.',
            'participant_category.in' => 'Kategori peserta yang dipilih tidak valid.',
        ];
    }
}
