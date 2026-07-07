<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Primary SEO --}}
    <title>@yield('title', $setting->seo_title ?? $setting->title ?? 'OA Gateway')</title>

    <meta name="description"
          content="@yield('meta_description', $setting->seo_description ?? 'OA Gateway - Open Access Research Publishing Platform')">

    <meta name="keywords"
          content="@yield('meta_keywords', $setting->seo_keywords ?? 'research,journal,articles,academic,open access')">

    <meta name="author"
          content="{{ $setting->title ?? 'OA Gateway' }}">

    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">

    {{-- Canonical --}}
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Favicon --}}
    @if(!empty($setting->favicon))
        <link rel="icon" href="{{ asset($setting->favicon) }}">
    @endif

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $setting->title ?? 'OA Gateway' }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <meta property="og:title"
          content="@yield('title', $setting->seo_title ?? $setting->title ?? 'OA Gateway')">

    <meta property="og:description"
          content="@yield('meta_description', $setting->seo_description ?? '')">

    @if(!empty($setting->logo))
        <meta property="og:image"
              content="{{ asset($setting->logo) }}">
    @endif

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">

    <meta name="twitter:title"
          content="@yield('title', $setting->seo_title ?? $setting->title ?? 'OA Gateway')">

    <meta name="twitter:description"
          content="@yield('meta_description', $setting->seo_description ?? '')">

    @if(!empty($setting->logo))
        <meta name="twitter:image"
              content="{{ asset($setting->logo) }}">
    @endif

    {{-- Schema Support --}}
    @yield('schema')

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Inter:wght@300;400;500;600&display=swap"
          rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f5f5;
        }

        .heading-font {
            font-family: 'Merriweather', serif;
        }

        .hero-bg {
            background: #162b6f;
        }

        .footer-bg {
            background: #07132f;
        }
    </style>

</head>

<body>

    @include('partials.header')

    <main class="flex-1">
        @yield('content')
    </main>

    @include('partials.footer')

</body>

</html>