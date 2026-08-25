<?php

namespace App\Http\Requests\Event;

use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEventRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $slug = $this->route('slug');
        $event = Event::where('slug', $slug)->first();
        $registration = $this->route('registration');
        $registrationId = is_object($registration) ? $registration->id : $registration;

        return [
            'full_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('event_registrations')
                    ->where(fn ($query) => $query->where('event_id', $event?->id))
                    ->ignore($registrationId),
            ],
            'phone' => ['required', 'string', 'max:30'],
            'participant_category' => ['required', Rule::in(['Mahasiswa', 'Pelajar', 'Pekerja', 'Umum', 'Lainnya'])],
            'institution' => ['required', 'string', 'max:255'],
            'major' => ['nullable', 'string', 'max:255'],
            'batch' => ['nullable', 'string', 'max:30'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
