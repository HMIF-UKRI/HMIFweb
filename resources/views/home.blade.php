@extends('layouts.app')

@section('content')
<body class="bg-white">
    <!-- Hero Section -->
    <section id="home" class="pt-24 pb-16 bg-gradient-to-r from-gray-900 via-red-900 to-black text-white min-h-screen flex items-center">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-8 md:mb-0">
                    <h1 class="text-4xl md:text-6xl font-bold mb-4">Himpunan Mahasiswa Teknik Informatika</h1>

                    <p class="text-lg md:text-xl mb-8">Mewujudkan mahasiswa yang aktif, kreatif, dan inovatif dalam mengembangkan potensi diri dan memberikan kontribusi untuk masyarakat.</p>
                </div>
                <div class="md:w-1/2 flex justify-center">
                    <img src="{{ asset('images/banner2.png') }}" alt="Hero Image" class="rounded-lg shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <!-- Divider Marquee -->
<div class="relative overflow-hidden w-full bg-black py-4">
  <div class="flex animate-loop-scroll whitespace-nowrap">
     <div class="flex shrink-0 gap-8 px-4">
        <span class="mx-8">✦ HIMPUNAN MAHASISWA TEKNIK INFORMATIKA ✦</span>
        <span class="mx-8">✦ ONE • FAMILY • ONE • GOAL ✦</span>
        <span class="mx-8">✦ HMIF • HMIF • HMIF ✦</span>
        <span class="mx-8">✦ 🔥 • 🔥 • 🔥 ✦</span>
         <div class="flex shrink-0 gap-8 px-4">
        <span class="mx-8">✦ HIMPUNAN MAHASISWA TEKNIK INFORMATIKA ✦</span>
        <span class="mx-8">✦ ONE • FAMILY • ONE • GOAL ✦</span>
        <span class="mx-8">✦ HMIF • HMIF • HMIF ✦</span>
        <span class="mx-8">✦ 🔥 • 🔥 • 🔥 ✦</span>
    </div>
</div>
  </div>

<!-- About Section -->
<section id="about" class="py-16 bg-black">
    <div class="container mx-auto px-6 md:px-12">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-white mb-2">Tentang Kita</h2>
            <div class="w-24 h-1 bg-red-900 mx-auto"></div>
        </div>
        <div class="flex flex-col md:flex-row items-center md:items-start">
            <div class="md:w-1/2 mb-8 md:mb-0 md:pr-8">
                <a href="#" class="block">
  <img
    alt=""
    src="/images/banner.png"
    class="h-56 w-full rounded-tr-3xl rounded-bl-3xl object-cover sm:h-64 lg:h-72"
  />

  <div class="mt-4 sm:flex sm:items-center sm:justify-center sm:gap-4">
    <strong class="font-medium">HIMF UKRI</strong>

    <span class="hidden sm:block sm:h-px sm:w-8 sm:bg-yellow-500"></span>

    <p class="mt-0.5 opacity-50 sm:mt-0">Kabinet DIGISWARA</p>
  </div>
</a>
            </div>
            <div class="md:w-1/2 text-white space-y-6">
                <div>
                    <h3 class="text-2xl font-bold mb-2 text-white">Sejarah Kami</h3>
                    <p class="leading-relaxed text-gray-300">Himpunan Mahasiswa didirikan pada tahun 20XX dengan tujuan menjadi wadah bagi mahasiswa untuk mengembangkan potensi, minat, dan bakat dalam berbagai bidang.</p>
                </div>
                <div>
                    <h3 class="text-2xl font-bold mb-2 text-white">Visi</h3>
                    <p class="leading-relaxed text-gray-300">Menjadi organisasi kemahasiswaan yang unggul, profesional, dan berkontribusi nyata bagi kemajuan mahasiswa dan masyarakat.</p>
                </div>
                <div>
                    <h3 class="text-2xl font-bold mb-2 text-white">Misi</h3>
                    <ul class="list-disc pl-6 space-y-2 text-gray-300">
                        <li>Mengembangkan potensi akademik dan non-akademik mahasiswa</li>
                        <li>Membangun karakter kepemimpinan dan profesionalisme</li>
                        <li>Meningkatkan solidaritas dan kerjasama antar mahasiswa</li>
                        <li>Berperan aktif dalam kegiatan kemahasiswaan dan pengabdian masyarakat</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Board Section -->
    <section id="board" class="py-16 bg-black text-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-2">Struktur Pengurus</h2>
                <div class="w-24 h-1 bg-red-900 mx-auto"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Ketua -->
                <div class="bg-white text-black rounded-lg overflow-hidden shadow-lg transform transition hover:-translate-y-2">
                    <img src="/images/ketua.jpg" alt="Ketua" class="w-full h-64 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-bold mb-1">Acong</h3>
                        <p class="text-red-900 font-semibold mb-2">Ketua Himpunan</p>
                        <p class="text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sed dapibus leo.</p>
                    </div>
                </div>
                <!-- Wakil Ketua -->
                <div class="bg-white text-black rounded-lg overflow-hidden shadow-lg transform transition hover:-translate-y-2">
                    <img src="/images/wakil.jpg" alt="Wakil Ketua" class="w-full h-64 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-bold mb-1">Ikhsan</h3>
                        <p class="text-red-900 font-semibold mb-2">Wakil Ketua</p>
                        <p class="text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sed dapibus leo.</p>
                    </div>
                </div>
                <!-- Sekretaris -->
                <div class="bg-white text-black rounded-lg overflow-hidden shadow-lg transform transition hover:-translate-y-2">
                    <img src="/images/sekertaris.jpg" alt="Sekretaris" class="w-full h-64 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-bold mb-1">Tania</h3>
                        <p class="text-red-900 font-semibold mb-2">Sekretaris</p>
                        <p class="text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sed dapibus leo.</p>
                    </div>
                </div>
                <!-- Bendahara -->
                <div class="bg-white text-black rounded-lg overflow-hidden shadow-lg transform transition hover:-translate-y-2">
                    <img src="/images/bendahara.jpg" alt="Bendahara" class="w-full h-64 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-bold mb-1">Simai</h3>
                        <p class="text-red-900 font-semibold mb-2">Bendahara</p>
                        <p class="text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sed dapibus leo.</p>
                    </div>
                </div>
            </div>
            <div class="text-center mt-8">
                <a href="" class="nav-link"></a> <a class="inline-block bg-red-900 text-white font-bold py-3 px-6 rounded-lg hover:bg-opacity-90 transition">Lihat Semua Pengurus</a>
            </div>
        </div>
    </section>

    <!-- Activities Section -->
    <section id="activities" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-black mb-2">Program Kegiatan</h2>
                <div class="w-24 h-1 bg-red-900 mx-auto"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Activity 1 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-lg border border-black border-opacity-10">
                    <img src="/api/placeholder/400/320" alt="Activity 1" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 text-black">Seminar Nasional</h3>
                        <p class="text-black opacity-75 mb-4">Seminar tahunan dengan menghadirkan pembicara dari berbagai bidang untuk memberikan wawasan dan inspirasi kepada mahasiswa.</p>
                        <div class="flex justify-between items-center">
                            <span class="bg-red-900 text-white text-sm py-1 px-3 rounded-full">Tahunan</span>
                            <a href="#" class="text-red-900 font-semibold hover:underline">Detail →</a>
                        </div>
                    </div>
                </div>
                <!-- Activity 2 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-lg border border-black border-opacity-10">
                    <img src="/api/placeholder/400/320" alt="Activity 2" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 text-black">Workshop Keterampilan</h3>
                        <p class="text-black opacity-75 mb-4">Seri workshop untuk meningkatkan keterampilan praktis dan soft skill mahasiswa sesuai kebutuhan dunia kerja.</p>
                        <div class="flex justify-between items-center">
                            <span class="bg-red-900 text-white text-sm py-1 px-3 rounded-full">Bulanan</span>
                            <a href="#" class="text-red-900 font-semibold hover:underline">Detail →</a>
                        </div>
                    </div>
                </div>
                <!-- Activity 3 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-lg border border-black border-opacity-10">
                    <img src="/api/placeholder/400/320" alt="Activity 3" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 text-black">Bakti Sosial</h3>
                        <p class="text-black opacity-75 mb-4">Kegiatan pengabdian kepada masyarakat dalam bentuk donasi, edukasi, dan bantuan sosial untuk komunitas sekitar.</p>
                        <div class="flex justify-between items-center">
                            <span class="bg-red-900 text-white text-sm py-1 px-3 rounded-full">Semester</span>
                            <a href="#" class="text-red-900 font-semibold hover:underline">Detail →</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-8">
                <a href="#" class="inline-block bg-black text-white font-bold py-3 px-6 rounded-lg hover:bg-opacity-90 transition">Lihat Semua Kegiatan</a>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="py-16 bg-black text-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-2">Galeri Kegiatan</h2>
                <div class="w-24 h-1 bg-red-900 mx-auto"></div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <div class="overflow-hidden rounded-lg">
                    <img src="/api/placeholder/400/320" alt="Gallery 1" class="w-full h-48 object-cover transition transform hover:scale-110">
                </div>
                <div class="overflow-hidden rounded-lg">
                    <img src="/api/placeholder/400/320" alt="Gallery 2" class="w-full h-48 object-cover transition transform hover:scale-110">
                </div>
                <div class="overflow-hidden rounded-lg">
                    <img src="/api/placeholder/400/320" alt="Gallery 3" class="w-full h-48 object-cover transition transform hover:scale-110">
                </div>
                <div class="overflow-hidden rounded-lg">
                    <img src="/api/placeholder/400/320" alt="Gallery 4" class="w-full h-48 object-cover transition transform hover:scale-110">
                </div>
                <div class="overflow-hidden rounded-lg">
                    <img src="/api/placeholder/400/320" alt="Gallery 5" class="w-full h-48 object-cover transition transform hover:scale-110">
                </div>
                <div class="overflow-hidden rounded-lg">
                    <img src="/api/placeholder/400/320" alt="Gallery 6" class="w-full h-48 object-cover transition transform hover:scale-110">
                </div>
                <div class="overflow-hidden rounded-lg">
                    <img src="/api/placeholder/400/320" alt="Gallery 7" class="w-full h-48 object-cover transition transform hover:scale-110">
                </div>
                <div class="overflow-hidden rounded-lg">
                    <img src="/api/placeholder/400/320" alt="Gallery 8" class="w-full h-48 object-cover transition transform hover:scale-110">
                </div>
            </div>
            <div class="text-center mt-8">
                <a href="#" class="inline-block bg-red-900 text-white font-bold py-3 px-6 rounded-lg hover:bg-opacity-90 transition">Lihat Semua Foto</a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-black mb-2">Hubungi Kami</h2>
                <div class="w-24 h-1 bg-red-900 mx-auto"></div>
            </div>
            <div class="flex flex-col md:flex-row gap-8">
                <div class="md:w-1/2 bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-2xl font-bold text-black mb-4">Kirim Pesan</h3>
                    <form>
                        <div class="mb-4">
                            <label for="name" class="block text-black font-medium mb-2">Nama Lengkap</label>
                            <input type="text" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-900">
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-black font-medium mb-2">Email</label>
                            <input type="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-900">
                        </div>
                        <div class="mb-4">
                            <label for="subject" class="block text-black font-medium mb-2">Subjek</label>
                            <input type="text" id="subject" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-900">
                        </div>
                        <div class="mb-4">
                            <label for="message" class="block text-black font-medium mb-2">Pesan</label>
                            <textarea id="message" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-900"></textarea>
                        </div>
                        <button type="submit" class="bg-red-900 text-white font-bold py-3 px-6 rounded-lg hover:bg-opacity-90 transition w-full">Kirim Pesan</button>
                    </form>
                </div>
                <div class="md:w-1/2 bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-2xl font-bold text-black mb-4">Informasi Kontak</h3>
                    <div class="mb-4">
                        <h4 class="font-bold text-black mb-1">Alamat</h4>
                        <p class="text-black opacity-75">Jl. Contoh No. 123, Kota, Provinsi, Indonesia</p>
                    </div>
                    <div class="mb-4">
                        <h4 class="font-bold text-black mb-1">Email</h4>
                        <p class="text-black opacity-75">info@himpunanmahasiswa.ac.id</p>
                    </div>
                    <div class="mb-4">
                        <h4 class="font-bold text-black mb-1">Telepon</h4>
                        <p class="text-black opacity-75">+62 123 4567 890</p>
                    </div>
                    <div class="mt-6">
                        <h4 class="font-bold text-black mb-2">Lokasi</h4>
                        <div class="w-full h-64 bg-gray-200 rounded-lg">
                            <!-- Map placeholder -->
                            <div class="w-full h-full flex items-center justify-center bg-gray-300 text-gray-500">
                                Map Placeholder
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
                    @endsection