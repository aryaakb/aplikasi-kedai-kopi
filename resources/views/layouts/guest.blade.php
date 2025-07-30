<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Arpul - {{ $title ?? 'Creative Coffee Compound' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Playfair+Display:wght@400;600;700&family=Source+Sans+Pro:wght@400;600&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                font-family: 'Source Sans Pro', sans-serif;
                background: linear-gradient(135deg, #2F1B14, #4A2C2A, #3E2723);
                background-size: 400% 400%;
                animation: gradientShift 15s ease infinite;
            }
            
            @keyframes gradientShift {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }
            
            .font-brand { 
                font-family: 'Bebas Neue', cursive; 
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
                background: #DAA520;
                border-radius: 4px;
            }
            
            ::-webkit-scrollbar-thumb:hover {
                background: #B8860B;
            }
            
            /* Mobile optimizations */
            @media (max-width: 640px) {
                body {
                    overflow-x: hidden;
                }
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased min-h-screen">
        <!-- Background Pattern -->
        <div class="fixed inset-0 opacity-5 pointer-events-none">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23DAA520" fill-opacity="0.1"><circle cx="30" cy="30" r="2"/></g></svg>');"></div>
        </div>

        <div class="relative min-h-screen flex flex-col sm:justify-center items-center px-4 py-6 sm:py-12">
            <!-- Back to Home Button -->
            <div class="absolute top-4 left-4 sm:top-6 sm:left-6 z-10">
                <a href="/" class="inline-flex items-center text-[#DAA520] hover:text-[#F5DEB3] transition-colors duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="font-semibold text-sm md:text-base">Kembali ke Beranda</span>
                </a>
            </div>

            <!-- Logo -->
            <div class="mb-6 md:mb-8">
                <a href="/" class="flex flex-col items-center space-y-2">
                    <div class="animate-pulse">
                        <img src="{{ asset('images/logo/arpul.PNG') }}" alt="Arpul Logo" class="w-16 h-16 md:w-20 md:h-20 lg:w-24 lg:h-24 object-contain">
                    </div>
                    <div class="text-center">
                        <h1 class="font-brand text-2xl md:text-3xl lg:text-4xl text-[#F5DEB3] tracking-wider">
                            ARPUL
                        </h1>
                        <p class="text-[#DAA520] text-sm md:text-base font-elegant">Creative Coffee Compound</p>
                    </div>
                </a>
            </div>

            <!-- Form Container -->
            <div class="w-full max-w-md lg:max-w-lg xl:max-w-xl bg-gradient-to-br from-[#8B4513] to-[#A0522D] shadow-2xl overflow-hidden rounded-2xl border-4 border-[#DAA520] relative">
                <!-- Decorative Elements -->
                <div class="absolute top-4 right-4 text-[#DAA520] text-2xl opacity-20">☕</div>
                <div class="absolute bottom-4 left-4 text-[#DAA520] text-xl opacity-20">🫘</div>
                
                <!-- Content -->
                <div class="relative z-10 px-6 py-8 md:px-8 md:py-10 lg:px-10 lg:py-12">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-[#DAA520] text-sm md:text-base opacity-80">
                    © 2020 Arpul. Dibuat dengan ❤️ dan ☕
                </p>
            </div>
        </div>
    </body>
</html>