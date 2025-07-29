<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>American Coffee Co. - {{ config('app.name', 'Premium Coffee Experience') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Playfair+Display:wght@400;600;700&family=Source+Sans+Pro:wght@400;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
            background: linear-gradient(135deg, #2F1B14 0%, #3E2723 100%);
        }
        .font-brand {
            font-family: 'Bebas Neue', cursive;
            letter-spacing: 2px;
        }
        .font-elegant {
            font-family: 'Playfair Display', serif;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #2F1B14;
        }
        ::-webkit-scrollbar-thumb {
            background: #8B4513;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #A0522D;
        }
        
        /* Pastikan layout yang proper */
        nav {
            position: relative;
            z-index: 1000;
        }
        
        header {
            position: relative;
            z-index: 999;
        }
        
        main {
            position: relative;
            z-index: 1;
            min-height: calc(100vh - 80px);
        }
        
        /* Responsive menu positioning */
        .responsive-nav {
            position: relative;
            z-index: 1001;
        }
        
        /* Dropdown memiliki prioritas tertinggi */
        [x-data*="open"] > div[x-show="open"] {
            z-index: 9999 !important;
            position: fixed !important;
        }
        
        /* Pastikan semua konten dashboard tidak mengganggu dropdown */
        .main-content {
            position: relative;
            z-index: 1;
        }
        
        /* Override untuk dropdown component */
        .dropdown-content {
            z-index: 9999 !important;
            position: absolute !important;
        }
        
        /* Modal pembayaran harus selalu di atas semua elemen */
        [x-show="showModal"] {
            z-index: 99999 !important;
        }
        
        /* Override untuk modal dengan Alpine.js */
        div[x-data*="showModal"] > div[x-show="showModal"] {
            z-index: 99999 !important;
            position: fixed !important;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gradient-to-br from-[#2F1B14] to-[#3E2723]">
        @include('layouts.navigation')

        @if (isset($header))
            <header class="bg-gradient-to-r from-[#8B4513] to-[#A0522D] shadow-xl border-b-2 border-[#DAA520] relative z-5">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div class="font-brand text-3xl text-[#F5DEB3] flex items-center space-x-3">
                        <span class="text-[#DAA520]">☕</span>
                        {{ $header }}
                    </div>
                </div>
            </header>
        @endif

        <main class="text-[#F5DEB3] relative z-0 main-content">
            {{ $slot }}
        </main>

        <!-- Coffee-themed footer -->
        <footer class="bg-[#2F1B14] border-t-2 border-[#8B4513] mt-12">
            <div class="max-w-7xl mx-auto px-4 py-6 text-center">
                <div class="flex items-center justify-center space-x-2 text-[#DAA520] mb-2">
                    <span class="text-2xl">☕</span>
                    <span class="font-brand text-xl">NOFVCKINGCOFFEE</span>
                    <span class="text-2xl">☕</span>
                </div>
                <p class="text-[#F5DEB3] text-sm">Kopi tanpa drama, rasa yang jujur - sejak 2024</p>
            </div>
        </footer>
    </div>
</body>
</html>