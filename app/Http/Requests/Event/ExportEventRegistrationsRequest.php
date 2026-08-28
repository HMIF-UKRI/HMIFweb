<?php

namespace App\Http\Requests\Event;

use App\Services\Event\EventRegistrationService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExportEventRegistrationsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if (!$this->has('_export_configured')) {
            $this->merge([
                'format' => 'excel',
                'columns' => array_keys(EventRegistrationService::EXPORT_COLUMNS),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'format' => ['required', Rule::in(['excel', 'word'])],
            'columns' => ['required', 'array', 'min:1'],
            'columns.*' => [
                'string',
                'distinct',
                Rule::in(array_keys(EventRegistrationService::EXPORT_COLUMNS)),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'format.in' => 'Format export yang dipilih tidak valid.',
            'columns.required' => 'Pilih minimal satu data untuk diekspor.',
            'columns.min' => 'Pilih minimal satu data untuk diekspor.',
            'columns.*.in' => 'Terdapat pilihan data export yang tidak valid.',
        ];
    }
}
