<?php

namespace App\Http\Requests\DocEvent;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasAnyRole(['super-admin', 'pengurus']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'event_id'      => ['nullable', 'exists:events,id'],
            'period_id'     => ['required', 'exists:periods,id'],
            'type_document' => ['required', 'in:proposal,lpj,rab,surat,tor,notulensi,lainnya'],
            'name'          => ['required', 'string', 'max:255'],
            'description'   => ['nullable', 'string', 'max:1000'],
            'access_level'  => ['nullable', 'in:internal,public'],
            'file'          => [
                'required',
                'file',
                'mimes:pdf,doc,docx,xls,xlsx,csv',
                'max:20480', // Maksimal 20 MB (20480 KB)
            ],
        ];
    }

    /**
     * Custom validation error messages.
     */
    public function messages(): array
    {
        return [
            'file.required'          => 'Wajib memilih berkas dokumen untuk diunggah.',
            'file.file'              => 'Berkas yang diunggah harus berupa file yang valid.',
            'file.mimes'             => 'Format berkas tidak diizinkan. Sistem hanya menerima format PDF (.pdf), Word (.doc, .docx), dan Excel/CSV (.xls, .xlsx, .csv).',
            'file.max'               => 'Ukuran berkas tidak boleh melebihi batas maksimal 20 MB.',
            'type_document.required' => 'Tipe dokumen wajib dipilih.',
            'type_document.in'       => 'Tipe dokumen yang dipilih tidak valid.',
            'period_id.required'     => 'Periode kepengurusan wajib ditentukan.',
            'period_id.exists'       => 'Periode kepengurusan yang dipilih tidak ditemukan.',
            'name.required'          => 'Nama arsip dokumen wajib diisi.',
            'name.max'               => 'Nama arsip dokumen maksimal 255 karakter.',
            'event_id.exists'        => 'Kegiatan/proker yang dipilih tidak valid.',
        ];
    }
}
