@props([
    'title' => 'HMIF UKRI',
    'description' => 'Website resmi Himpunan Mahasiswa Teknik Informatika UKRI',
    'keywords' => 'hmif,ukri,himatif,hima,informatika',
    'image' => asset('images/banner.png'),
    'url' => url()->current(),
])

{{-- General Meta Tags --}}
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ $title }}</title>
<meta name="title" content="{{ $title }}" />
<meta name="description" content="{{ $description }}" />
<meta name="keywords" content="{{ $keywords }}" />
<meta name="robots" content="index, follow" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="English" />

{{-- Open Graph / Facebook --}}
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ $url }}" />
<meta property="og:title" content="{{ $title }}" />
<meta property="og:description" content="{{ $description }}" />
<meta property="og:image" content="{{ $image }}" />

{{-- Twitter --}}
<meta property="twitter:card" content="summary_large_image" />
<meta property="twitter:url" content="{{ $url }}" />
<meta property="twitter:title" content="{{ $title }}" />
<meta property="twitter:description" content="{{ $description }}" />
<meta property="twitter:image" content="{{ $image }}" />

{{-- Canonical URL (optional but recommended for SEO) --}}
<link rel="canonical" href="{{ $url }}" />
