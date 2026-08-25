# Himpunan Mahasiswa Teknik Informatika - HMIF Project Overview

Secara fundamental selalu baca konteks project ini. Masing-masing fitur terdapat pada `spec-<feature>.md` setelah file ini. Membuat fitur X -> baca `AGENT_INSTRUCTIONS.mc` -> `spec-<feature>.md` -> implementasi.

Untuk file `spec-<feature>.md`, tidak harus selalu ada untuk setiap fitur. Jika tidak ada, maka fitur tersebut merupakan fitur yang sudah ada dan hanya perlu perbaikan atau pengembangan lebih lanjut.

## 1.Gambaran Umum

HMIF Project adalah Sistem Informasi Manajemen Himpunan Mahasiswa Teknik Informatika Universitas Kebangsaan Republik Indonesia (UKRI) berbasis web untuk memudahkan pengelolaan data keanggotaan, kegiatan, aspirasi, merchandise, struktur organisasi, media publikasi, dan lainnya.

## 2. Tech Stack

- **Framework:** Laravel (Latest Stable)
- **UI:** Tailwind CSS, FlyonUI, Preline UI
- **Frontend Components & Reactivity:** Alpine.js
- **UI Utilities & Inputs:** Editor.js (Rich Text), Flatpickr (Date/Time Picker)
- **Packages & Libraries:**
    - PDF Generation: `barryvdh/laravel-dompdf`
    - QR Code: `simplesoftwareio/simple-qrcode`
    - Authorization: `spatie/laravel-permission`
    - Media Management: `spatie/laravel-medialibrary`
- **Database:** sqlite
- **Libraries tambahan:** diperbolehkan jika ada rekomendasi library untuk mendukung spesifikasi fitur, namun tetap mematuhi pedoman dan convention yang telah ditetapkan dan memiliki izin khusus dari saya.

## 3. Development Commands & Environment

- **Vite / Asset Bundling:** `npm run dev`
- **Local Server:** `php artisan serve`
- **Fresh Migration & Seed:** `php artisan migrate:fresh --seed`
- **Clear Optimization / Cache:** `php artisan optimize:clear`
- **Generate Storage Link:** `php artisan storage:link`
- **Stop Laravel development server:** `Ctrl + C`

## 4. Architecture & Project Structure Standards

Ikuti pola arsitektur standar Laravel MVC dengan pemisahan tanggung jawab yang jelas:

- **Controllers (`app/Http/Controllers/`):**
    - Buat controller tetap ramping (_skinny controller_).
    - Hindari meletakkan query kompleks dan logika bisnis langsung di controller.
    - controller hanya digunakan untuk menerima request,
    - memvalidasi request, lalu memanggil service / action untuk memproses request tersebut.
    - controller tidak boleh mengembalikan view secara langsung, melainkan harus mengembalikan response dari service / action.
- **Form Requests (`app/Http/Requests/`):**
    - Wajib gunakan Form Request terpisah untuk validasi form atau API endpoint yang menerima payload/mutasi data.
    - Gunakan Form Request terpisah untuk validasi form atau API endpoint yang menerima payload/mutasi data.
    - Form request tidak boleh memuat logika bisnis, tetapi hanya validasi.
- **Services / Actions (`app/Services/` atau `app/Actions/`):**
    - Gunakan Service class untuk logika bisnis berat (misal: generate sertifikat PDF + QR code, parsing output Editor.js).
    - Gunakan Service class untuk logika bisnis yang kompleks, seperti:
        - generate sertifikat PDF + QR code
        - parsing output Editor.js
        - logika bisnis lainnya yang kompleks
    - service tidak boleh mengembalikan view secara langsung, melainkan harus mengembalikan response dari service / action.
- **Models (`app/Models/`):**
    - Deklarasikan `$fillable` atau `$guarded`, `$casts`, dan relasi Eloquent secara eksplisit.
    - Gunakan Eloquent Model dengan properti `$fillable` atau `$guarded` yang jelas, dan definisikan $casts untuk tipe data yang benar.
    - $casts gunakan tipe data yang sesuai dengan database, misal string, boolean, integer, float, dll.
    - Gunakan relationship Eloquent yang tepat, misal hasOne, hasMany, belongsTo, belongsToMany.
    - model harus memiliki relationship yang tepat sesuai dengan relasi antar tabel.
    - model harus memiliki scope yang tepat sesuai dengan relasi antar tabel.
- **Views (`resources/views/`):**
    - Gunakan Blade components (`resources/views/components/`) untuk elemen UI yang _reusable_.
    - Bagi layout menjadi `layouts/app.blade.php`, `layouts/guest.blade.php`, atau `layouts/admin.blade.php`.
    - Gunakan komponen UI yang konsisten, sesuai dengan tema FlyonUI & Preline UI.

## 5. Coding Conventions & Package Implementation Rules

### A. Authorization & Roles (`spatie/laravel-permission`)

- Lindungi route menggunakan middleware permission (contoh: `role:admin`, `permission:publish-article`).
- Pada Blade view, gunakan directive bawaan `@can`, `@role`, atau `@hasrole` untuk _conditional rendering_ elemen UI.
- jangan gunakan middleware auth:web untuk route yang sudah dihandle oleh middleware permission.
- guard user menggunakan role, bukan permission. role digunakan untuk membedakan user menjadi 3: super_admin, admin, dan anggota.
- permission digunakan untuk membedakan hak akses user menjadi hak akses untuk super_admin, admin, dan anggota.
- permission memiliki sifat:
    1. super_admin memiliki semua hak akses.
    2. admin memiliki hak akses untuk kelola user, kegiatan, aspirasi, merchandise, struktur organisasi, media publikasi, dan lainnya.
    3. anggota memiliki hak akses untuk melihat kegiatan, aspirasi, merchandise, struktur organisasi, media publikasi, dan lainnya.

### B. Media Handling (`spatie/laravel-medialibrary`)

- Model yang mengelola gambar/file wajib mengimplementasikan interface `HasMedia` dan trait `InteractsWithMedia`.
- Tangani upload file melalui integrasi collection media Spatie, jangan gunakan penyimpanan manual _raw_ `Storage::put()` kecuali untuk file temporary/ekspor sementara.
- untuk menyimpan file ke database, gunakan fungsi `addMedia()` dan untuk mengambil file gunakan fungsi `getFirstMediaUrl()`.
- jangan gunakan `addMediaFromBase64()` untuk menyimpan file ke database, melainkan gunakan `addMedia()` dengan file yang sudah di-upload terlebih dahulu.

### C. UI, Styling & Interactivity (Tailwind CSS, FlyonUI, Preline, Alpine.js)

- Gunakan utilitas Tailwind CSS standar yang kompatibel dengan tema FlyonUI & Preline.
- Gunakan **Alpine.js** untuk interaktivitas komponen lokal sederhana (dropdown, modal toggle, form tab, accordion).
- Jangan gunakan vanilla JavaScript _inline script tags_ di sembarang file jika fungsionalitas tersebut dapat diselesaikan secara modular melalui Alpine.js.

### D. Input & Utility Components (Editor.js & Flatpickr)

- Inisialisasi Editor.js dan Flatpickr melalui custom Blade components atau file JS modular terpisah di `resources/js/`.
- Simpan data Editor.js dalam format JSON di database, dan sediakan parser/sanitizer saat me-render outputnya ke view publik untuk mencegah kerentanan XSS.

### E. Document & Asset Generation (DomPDF & Simple QRCode)

- Render PDF menggunakan Blade template khusus di `resources/views/pdf/`.
- Gunakan inline CSS atau CSS kompatibel print pada template PDF (hindari dependensi penuh pada utility class modern yang tidak didukung dompdf engine).
- Generate QR code dalam format SVG atau PNG base64 saat disematkan langsung ke dalam layout PDF/Blade.

## 6. Security & Best Practices

- **Mass Assignment:** Pastikan setiap Model memiliki proteksi mass assignment yang ketat.
- **Database Transactions:** Gunakan `DB::transaction(function() { ... })` pada operasi yang melibatkan multi-tabel (contoh: pembuatan registrasi event + upload media + generate invoice/QR).
- **CSRF Protection:** Pastikan semua form POST/PUT/DELETE memiliki direktif `@csrf` dan `@method()`.

## 7. AI Output & Behavioral Rules

Saat AI menulis atau merefaktor kode:

1. **Full File vs Diffs:** Selalu cantumkan path file lengkap (misal: `app/Http/Controllers/EventController.php`) sebelum blok kode.
2. **No Breaking Changes:** Jangan menghapus dependency, mengubah konfigurasi database, atau merombak skema yang sudah berjalan tanpa instruksi eksplisit.
3. **Clean Code:** Jangan meninggalkan placeholder komentar `// implement logic here` kecuali jika diminta hanya membuat boilerplate/interface.
