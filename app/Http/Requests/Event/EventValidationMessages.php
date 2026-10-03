<?php

namespace App\Http\Requests\Event;

trait EventValidationMessages
{
    public function attributes(): array
    {
        return [
            'event_category_id'   => 'kategori',
            'period_id'           => 'kabinet',
            'title'               => 'judul kegiatan',
            'short_description'   => 'deskripsi singkat',
            'description'         => 'deskripsi',
            'event_date'          => 'tanggal',
            'location'            => 'lokasi',
            'whatsapp_group_link' => 'link grup WhatsApp',
            'status'              => 'status',
            'thumbnail'           => 'thumbnail',
        ];
    }

    public function messages(): array
    {
        return [
            'required'           => 'Kolom :attribute wajib diisi.',
            'thumbnail.required' => 'Thumbnail wajib diunggah.',
            'thumbnail.uploaded' => 'Thumbnail gagal diunggah. Kemungkinan ukuran file melebihi batas upload server, coba kompres gambarnya.',
            'thumbnail.image'    => 'Thumbnail harus berupa gambar.',
            'thumbnail.mimes'    => 'Thumbnail harus berformat jpeg, png, jpg, webp, atau heic.',
            'thumbnail.max'      => 'Ukuran thumbnail maksimal 5 MB.',
            'event_date.date'    => 'Format tanggal tidak valid.',
            'whatsapp_group_link.url' => 'Link grup WhatsApp harus berupa URL yang valid.',
        ];
    }
}
