<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Arpul - Creative Coffee Compound</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Playfair+Display:wght@400;600;700&family=Source+Sans+Pro:wght@400;600&display=swap" rel="stylesheet">

    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Vite CSS -->
    @vite(['resources/css/app.css'])

    <style>
        body { 
            font-family: 'Source Sans Pro', sans-serif; 
            background-color: #2F1B14;
        }
        .font-brand { 
            font-family: 'Bebas Neue', cursive; 
            letter-spacing: 2px;
        }
        .font-elegant { 
            font-family: 'Playfair Display', serif; 
        }
        .bg-coffee-primary { background-color: #8B4513; }
        .bg-coffee-secondary { background-color: #A0522D; }
        .hover\:bg-coffee-dark:hover { background-color: #654321; }
        .text-coffee-cream { color: #F5DEB3; }
        .text-coffee-gold { color: #DAA520; }

        /* American-style coffee shop animations */
        @keyframes gentle-float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .animate-float {
            animation: gentle-float 6s ease-in-out infinite;
        }
        
        @keyframes steam-rise {
            0% { opacity: 0.7; transform: translateY(0px) scale(1); }
            100% { opacity: 0; transform: translateY(-50px) scale(1.5); }
        }
        .animate-steam {
            animation: steam-rise 3s ease-out infinite;
        }
        
        @keyframes glow-pulse {
            0%, 100% { 
                box-shadow: 0 0 20px rgba(218, 165, 32, 0.3), 0 10px 25px rgba(0, 0, 0, 0.2); 
            }
            50% { 
                box-shadow: 0 0 30px rgba(218, 165, 32, 0.6), 0 0 40px rgba(218, 165, 32, 0.4), 0 15px 35px rgba(0, 0, 0, 0.3); 
            }
        }
        .animate-glow {
            animation: glow-pulse 4s ease-in-out infinite;
        }
        
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient-shift 8s ease infinite;
        }
        
        .menu-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .menu-card:hover {
            transform: translateY(-8px) scale(1.02);
        }
        
        .menu-item {
            transition: all 0.2s ease-in-out;
        }
        .menu-item:hover {
            transform: scale(1.02);
        }
    </style>
</head>
<body class="antialiased">
    <div class="relative min-h-screen overflow-hidden">
        <!-- Header -->
        <header class="absolute top-0 left-0 right-0 z-20 bg-black bg-opacity-20 backdrop-blur-sm" data-aos="fade-down" data-aos-duration="1000">
            <nav class="container mx-auto px-4 sm:px-6 py-3 sm:py-4 flex justify-between items-center">
                <div class="font-brand text-2xl sm:text-3xl lg:text-4xl text-coffee-cream">
                    <a href="/" class="flex items-center space-x-2 sm:space-x-3">
                        <img src="{{ asset('images/logo/arpul.PNG') }}" alt="Arpul Logo" class="w-8 h-8 sm:w-10 sm:h-10 lg:w-12 lg:h-12 object-contain">
                        <span class="hidden sm:inline">ARPUL</span>
                    </a>
                </div>
                <div class="text-coffee-cream">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="font-semibold hover:text-coffee-gold transition duration-300 bg-coffee-primary px-3 sm:px-4 py-2 rounded-lg text-sm sm:text-base">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="font-semibold hover:text-coffee-gold transition duration-300 mr-2 sm:mr-4 text-sm sm:text-base">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="font-semibold bg-coffee-primary hover:bg-coffee-dark py-2 px-3 sm:px-6 rounded-lg transition duration-300 border-2 border-coffee-gold text-sm sm:text-base">Daftar</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </nav>
        </header>

        <!-- Hero Section -->
        <main>
            <div class="relative h-screen flex items-center justify-center text-center">
                <!-- Background Image with Overlay -->
                <div class="absolute inset-0 bg-cover bg-center">
                    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1442512595331-e89e73853f31?q=80&w=2070&auto=format&fit=crop');"></div>
                    <div class="absolute inset-0 bg-gradient-to-b from-black via-transparent to-black opacity-70"></div>
                </div>

                <!-- Floating Coffee Elements -->
                <div class="absolute top-16 sm:top-20 left-4 sm:left-10 text-4xl sm:text-5xl lg:text-6xl text-coffee-gold animate-float hidden sm:block" style="animation-delay: 0s;">☕</div>
                <div class="absolute top-32 sm:top-40 right-4 sm:right-20 text-2xl sm:text-3xl lg:text-4xl text-coffee-cream animate-float hidden md:block" style="animation-delay: 2s;">🫘</div>
                <div class="absolute bottom-24 sm:bottom-32 left-4 sm:left-20 text-3xl sm:text-4xl lg:text-5xl text-coffee-gold animate-float hidden sm:block" style="animation-delay: 4s;">☕</div>

                <!-- Content -->
                <div class="relative z-10 text-coffee-cream px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">
                    <div class="font-elegant text-lg sm:text-xl md:text-2xl lg:text-3xl mb-4 text-coffee-gold" data-aos="fade-down" data-aos-duration="1000">
                        EST. 2020 • CREATIVE COFFEE COMPOUND
                    </div>
                    <h1 class="font-brand text-4xl sm:text-5xl md:text-6xl lg:text-7xl xl:text-8xl mb-6 leading-tight text-coffee-cream" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="300">
                        KOPI TANPA BASA-BASI
                    </h1>
                    <p class="font-elegant text-base sm:text-lg md:text-xl lg:text-2xl mb-8 max-w-4xl mx-auto text-coffee-cream leading-relaxed" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="600">
                        Rasakan cita rasa kopi Indonesia terbaik tanpa drama. Dari biji pilihan hingga cangkir Anda, setiap tegukan adalah kopi yang jujur dan berkualitas tinggi.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center items-center" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="900">
                        <a href="{{ route('register') }}" class="w-full sm:w-auto bg-coffee-primary hover:bg-coffee-dark text-coffee-cream font-bold py-3 sm:py-4 px-6 sm:px-8 rounded-lg text-base sm:text-lg transition duration-300 transform hover:scale-105 border-2 border-coffee-gold text-center">
                            GABUNG SEKARANG
                        </a>
                        <a href="{{ route('login') }}" class="w-full sm:w-auto bg-transparent hover:bg-coffee-primary text-coffee-cream font-bold py-3 sm:py-4 px-6 sm:px-8 rounded-lg text-base sm:text-lg transition duration-300 border-2 border-coffee-cream hover:border-coffee-gold text-center">
                            LIHAT MENU
                        </a>
                    </div>
                </div>
            </div>

            <!-- Features Section -->
            <section class="py-12 sm:py-16 bg-coffee-secondary">
                <div class="container mx-auto px-4 sm:px-6">
                    <h2 class="font-brand text-3xl sm:text-4xl lg:text-5xl text-center text-coffee-cream mb-8 sm:mb-12" data-aos="fade-up">KENAPA PILIH KAMI</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                        <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                            <div class="text-4xl sm:text-5xl lg:text-6xl mb-4 text-coffee-gold">🌱</div>
                            <h3 class="font-elegant text-lg sm:text-xl lg:text-2xl text-coffee-cream mb-3 sm:mb-4">Biji Kopi Premium</h3>
                            <p class="text-coffee-cream opacity-90 text-sm sm:text-base leading-relaxed">Dipilih langsung dari perkebunan kopi terbaik Indonesia dan dunia.</p>
                        </div>
                        <div class="text-center" data-aos="fade-up" data-aos-delay="400">
                            <div class="text-4xl sm:text-5xl lg:text-6xl mb-4 text-coffee-gold">👨‍🍳</div>
                            <h3 class="font-elegant text-lg sm:text-xl lg:text-2xl text-coffee-cream mb-3 sm:mb-4">Barista Ahli</h3>
                            <p class="text-coffee-cream opacity-90 text-sm sm:text-base leading-relaxed">Tenaga profesional yang menyajikan setiap cangkir dengan presisi dan perhatian.</p>
                        </div>
                        <div class="text-center" data-aos="fade-up" data-aos-delay="600">
                            <div class="text-4xl sm:text-5xl lg:text-6xl mb-4 text-coffee-gold">🏪</div>
                            <h3 class="font-elegant text-lg sm:text-xl lg:text-2xl text-coffee-cream mb-3 sm:mb-4">Suasana Nyaman</h3>
                            <p class="text-coffee-cream opacity-90 text-sm sm:text-base leading-relaxed">Ruang hangat dan ramah yang sempurna untuk bekerja, meeting, atau bersantai.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Menu Preview Section -->
            <section class="py-12 sm:py-16 lg:py-20 bg-gradient-to-b from-[#2F1B14] to-[#4A2C2A]">
                <div class="container mx-auto px-4 sm:px-6">
                    <div class="text-center mb-12 sm:mb-16">
                        <h2 class="font-brand text-3xl sm:text-4xl md:text-5xl lg:text-6xl text-coffee-cream mb-4" data-aos="fade-up">MENU PILIHAN</h2>
                        <p class="font-elegant text-base sm:text-lg lg:text-xl text-coffee-gold max-w-3xl mx-auto leading-relaxed" data-aos="fade-up" data-aos-delay="200">
                            Nikmati koleksi kopi dan makanan terbaik kami yang dibuat dengan cinta dan keahlian tinggi
                        </p>
                    </div>

                    <!-- Menu Categories -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-12 mb-12 sm:mb-16">
                        <!-- Coffee Menu -->
                        <div data-aos="fade-right" data-aos-delay="300">
                            <div class="menu-card bg-gradient-to-br from-amber-50 to-amber-100 rounded-2xl shadow-2xl overflow-hidden border-4 border-amber-400 animate-glow">
                                <div class="bg-gradient-to-r from-amber-800 via-amber-700 to-amber-900 animate-gradient p-6 text-center relative overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-r from-coffee-primary to-coffee-secondary opacity-80"></div>
                                    <div class="absolute top-2 right-2 text-amber-300 text-4xl animate-steam">☁️</div>
                                    <div class="absolute top-4 left-4 text-amber-200 text-2xl animate-float">☕</div>
                                    <div class="relative z-10">
                                        <h3 class="font-brand text-3xl text-amber-50 mb-2 drop-shadow-2xl">☕ SIGNATURE COFFEE</h3>
                                        <p class="text-amber-200 font-semibold">Kopi Pilihan Terbaik Kami</p>
                                    </div>
                                </div>
                                <div class="p-6 space-y-4 bg-gradient-to-b from-amber-50 to-amber-100">
                                    <div class="menu-item flex justify-between items-center bg-gradient-to-r from-white to-amber-50 p-4 rounded-xl shadow-lg border-2 border-amber-200 hover:border-amber-400 hover:shadow-xl cursor-pointer">
                                        <div>
                                            <h4 class="font-bold text-amber-900 text-lg">Americano Special</h4>
                                            <p class="text-amber-700 text-sm font-medium">Espresso premium dengan air panas, rasa kuat dan murni</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-brand text-2xl text-amber-900 bg-gradient-to-r from-amber-200 to-amber-300 px-4 py-2 rounded-lg shadow-md">Rp 30.000</p>
                                            <div class="flex text-yellow-500 text-sm mt-1 justify-end">⭐⭐⭐⭐⭐</div>
                                        </div>
                                    </div>
                                    
                                    <div class="menu-item flex justify-between items-center bg-gradient-to-r from-white to-amber-50 p-4 rounded-xl shadow-lg border-2 border-amber-200 hover:border-amber-400 hover:shadow-xl cursor-pointer">
                                        <div>
                                            <h4 class="font-bold text-amber-900 text-lg">Cappuccino Premium</h4>
                                            <p class="text-amber-700 text-sm font-medium">Kombinasi sempurna espresso, steamed milk, dan foam</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-brand text-2xl text-amber-900 bg-gradient-to-r from-amber-200 to-amber-300 px-4 py-2 rounded-lg shadow-md">Rp 35.000</p>
                                            <div class="flex text-yellow-500 text-sm mt-1 justify-end">⭐⭐⭐⭐⭐</div>
                                        </div>
                                    </div>
                                    
                                    <div class="menu-item flex justify-between items-center bg-gradient-to-r from-white to-amber-50 p-4 rounded-xl shadow-lg border-2 border-amber-200 hover:border-amber-400 hover:shadow-xl cursor-pointer">
                                        <div>
                                            <h4 class="font-bold text-amber-900 text-lg">Cold Brew No BS</h4>
                                            <p class="text-amber-700 text-sm font-medium">Kopi dingin yang di-brew 12 jam, smooth tanpa asam</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-brand text-2xl text-amber-900 bg-gradient-to-r from-amber-200 to-amber-300 px-4 py-2 rounded-lg shadow-md">Rp 32.000</p>
                                            <div class="flex text-yellow-500 text-sm mt-1 justify-end">⭐⭐⭐⭐⭐</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Food Menu -->
                        <div data-aos="fade-left" data-aos-delay="400">
                            <div class="menu-card bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl shadow-2xl overflow-hidden border-4 border-orange-400 animate-glow">
                                <div class="bg-gradient-to-r from-orange-800 via-red-700 to-red-800 animate-gradient p-6 text-center relative overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-r from-coffee-primary to-coffee-secondary opacity-80"></div>
                                    <div class="absolute top-2 right-2 text-orange-300 text-4xl animate-steam">🍞</div>
                                    <div class="absolute top-4 left-4 text-orange-200 text-2xl animate-float">🥐</div>
                                    <div class="relative z-10">
                                        <h3 class="font-brand text-3xl text-orange-50 mb-2 drop-shadow-2xl">🍞 FOOD & SNACKS</h3>
                                        <p class="text-orange-200 font-semibold">Pendamping Kopi Terbaik</p>
                                    </div>
                                </div>
                                <div class="p-6 space-y-4 bg-gradient-to-b from-orange-50 to-orange-100">
                                    <div class="menu-item flex justify-between items-center bg-gradient-to-r from-white to-orange-50 p-4 rounded-xl shadow-lg border-2 border-orange-200 hover:border-orange-400 hover:shadow-xl cursor-pointer">
                                        <div>
                                            <h4 class="font-bold text-orange-900 text-lg">Avocado Toast</h4>
                                            <p class="text-orange-700 text-sm font-medium">Roti sourdough dengan alpukat segar dan topping premium</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-brand text-2xl text-orange-900 bg-gradient-to-r from-orange-200 to-orange-300 px-4 py-2 rounded-lg shadow-md">Rp 45.000</p>
                                            <div class="flex text-yellow-500 text-sm mt-1 justify-end">⭐⭐⭐⭐⭐</div>
                                        </div>
                                    </div>
                                    
                                    <div class="menu-item flex justify-between items-center bg-gradient-to-r from-white to-orange-50 p-4 rounded-xl shadow-lg border-2 border-orange-200 hover:border-orange-400 hover:shadow-xl cursor-pointer">
                                        <div>
                                            <h4 class="font-bold text-orange-900 text-lg">Croissant Butter</h4>
                                            <p class="text-orange-700 text-sm font-medium">Croissant renyah dengan butter premium, perfect pair</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-brand text-2xl text-orange-900 bg-gradient-to-r from-orange-200 to-orange-300 px-4 py-2 rounded-lg shadow-md">Rp 25.000</p>
                                            <div class="flex text-yellow-500 text-sm mt-1 justify-end">⭐⭐⭐⭐</div>
                                        </div>
                                    </div>
                                    
                                    <div class="menu-item flex justify-between items-center bg-gradient-to-r from-white to-orange-50 p-4 rounded-xl shadow-lg border-2 border-orange-200 hover:border-orange-400 hover:shadow-xl cursor-pointer">
                                        <div>
                                            <h4 class="font-bold text-orange-900 text-lg">Chocolate Brownies</h4>
                                            <p class="text-orange-700 text-sm font-medium">Brownies coklat premium yang fudgy dan rich</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-brand text-2xl text-orange-900 bg-gradient-to-r from-orange-200 to-orange-300 px-4 py-2 rounded-lg shadow-md">Rp 28.000</p>
                                            <div class="flex text-yellow-500 text-sm mt-1 justify-end">⭐⭐⭐⭐⭐</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Call to Action -->
                    <div class="text-center px-4" data-aos="zoom-in" data-aos-delay="600">
                        <div class="bg-gradient-to-r from-coffee-primary to-coffee-secondary rounded-2xl p-6 sm:p-8 border-4 border-coffee-gold shadow-2xl max-w-3xl mx-auto">
                            <h3 class="font-brand text-2xl sm:text-3xl lg:text-4xl text-coffee-cream mb-4">SIAP MENIKMATI?</h3>
                            <p class="text-coffee-gold mb-6 font-elegant text-base sm:text-lg leading-relaxed">Bergabunglah dengan komunitas pecinta kopi sejati dan rasakan pengalaman kopi terbaik</p>
                            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center">
                                <a href="{{ route('register') }}" class="w-full sm:w-auto bg-coffee-gold hover:bg-[#B8860B] text-[#2F1B14] font-bold py-3 px-6 sm:px-8 rounded-lg text-base sm:text-lg transition duration-300 transform hover:scale-105 shadow-lg">
                                    🚀 DAFTAR SEKARANG
                                </a>
                                <a href="{{ route('login') }}" class="w-full sm:w-auto bg-transparent hover:bg-coffee-gold hover:text-[#2F1B14] text-coffee-cream font-bold py-3 px-6 sm:px-8 rounded-lg text-base sm:text-lg transition duration-300 border-2 border-coffee-gold">
                                    👀 LIHAT MENU LENGKAP
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
      AOS.init({
          once: true, // Animasi hanya berjalan sekali
          duration: 1000, // Durasi animasi global
      });
    </script>
</body>
</html>
