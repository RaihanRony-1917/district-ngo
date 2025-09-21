<!DOCTYPE html>
<html lang="en">
  <head>

    @php
        $siteSettings = \App\Models\Setting::first();
    @endphp
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $siteSettings->site_name }}</title>
    <meta name="description" content="Modern Admin Dashboard" />
    <meta name="author" content="Admin" />

    @if(isset($siteSettings) && $siteSettings->icon)
        <link rel="icon" href="{{ asset('storage/' . $siteSettings->icon) }}">
    @endif
    <meta property="og:title" content="Admin Dashboard" />
    <meta property="og:description" content="Modern Admin Dashboard" />
    <meta property="og:type" content="website" />

    <meta name="twitter:card" content="summary_large_image" />
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @stack('style-stack')
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Chart.js for the sales chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <style>
        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Sidebar transition */
        .sidebar-transition {
            transition: all 0.3s ease-in-out;
        }

        /* Hide scrollbar but keep functionality */
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
       @keyframes pulse-icon {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.15); opacity: 0.9; }
        }
        .animate-pulse-icon {
        animation: pulse-icon 1.5s infinite ease-in-out;
        }

        /* Ripple sonar waves */
        @keyframes ripple {
        0%   { transform: scale(1); opacity: 0.4; }
        100% { transform: scale(3); opacity: 0; }
        }
        .animate-ripple {
        animation: ripple 3s infinite;
        }

        /* Delays for continuous waves */
        .delay-1 { animation-delay: 1s; }
        .delay-2 { animation-delay: 2s; }


    </style>
  </head>

  <body class="bg-gray-50 font-sans">
    <!-- Main Container -->
    <div class="flex min-h-screen">

    <!-- Sidebar -->
    @include('partials.side-bar')

    <!-- Main Content -->
    <div class="flex-1 flex flex-col lg:ml-0">

        <!-- Top Navbar -->
        @include('partials.top-navbar')
        @yield('content')

    </div>

    @stack('member-stack')
    @stack('more-content-stack')

    <script src="https://unpkg.com/trix@1.3.1/dist/trix.js"></script>
    <script src="{{ asset('dashboard') }}/js/script.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <!-- Tagify CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet">

    <!-- Tagify JS -->
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script>feather.replace()</script>
    @stack('script-stack')
  </body>
</html>
