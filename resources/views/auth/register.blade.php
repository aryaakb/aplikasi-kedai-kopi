<x-guest-layout>
    <div class="text-center mb-6 md:mb-8">
        <div class="text-4xl md:text-5xl lg:text-6xl text-[#DAA520] mb-2">🚀</div>
        <h2 class="font-brand text-2xl md:text-3xl lg:text-4xl text-[#F5DEB3] mb-2" style="font-family: 'Bebas Neue', cursive;">
            BERGABUNG DENGAN KELUARGA KOPI
        </h2>
        <p class="text-[#DAA520] text-sm md:text-base">Daftar sekarang dan nikmati kopi premium tanpa drama</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4 md:space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" value="👤 Nama Lengkap" class="text-[#F5DEB3] font-semibold mb-2" />
            <x-text-input id="name" 
                         class="block mt-1 w-full px-4 py-3 md:py-4 rounded-lg border-2 border-[#8B4513] bg-[#F5DEB3] text-[#2F1B14] font-semibold focus:outline-none focus:ring-2 focus:ring-[#DAA520] focus:border-[#DAA520] transition-all duration-300" 
                         type="text" 
                         name="name" 
                         :value="old('name')" 
                         placeholder="Masukkan nama lengkap Anda"
                         required 
                         autofocus 
                         autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="📧 Alamat Email" class="text-[#F5DEB3] font-semibold mb-2" />
            <x-text-input id="email" 
                         class="block mt-1 w-full px-4 py-3 md:py-4 rounded-lg border-2 border-[#8B4513] bg-[#F5DEB3] text-[#2F1B14] font-semibold focus:outline-none focus:ring-2 focus:ring-[#DAA520] focus:border-[#DAA520] transition-all duration-300" 
                         type="email" 
                         name="email" 
                         :value="old('email')" 
                         placeholder="contoh@email.com"
                         required 
                         autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" value="🔒 Kata Sandi" class="text-[#F5DEB3] font-semibold mb-2" />
            <x-text-input id="password" 
                         class="block mt-1 w-full px-4 py-3 md:py-4 rounded-lg border-2 border-[#8B4513] bg-[#F5DEB3] text-[#2F1B14] font-semibold focus:outline-none focus:ring-2 focus:ring-[#DAA520] focus:border-[#DAA520] transition-all duration-300"
                         type="password"
                         name="password"
                         placeholder="Minimal 8 karakter"
                         required 
                         autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
            <p class="mt-1 text-xs md:text-sm text-[#DAA520]">💡 Gunakan kombinasi huruf, angka, dan simbol untuk keamanan</p>
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" value="🔒 Konfirmasi Kata Sandi" class="text-[#F5DEB3] font-semibold mb-2" />
            <x-text-input id="password_confirmation" 
                         class="block mt-1 w-full px-4 py-3 md:py-4 rounded-lg border-2 border-[#8B4513] bg-[#F5DEB3] text-[#2F1B14] font-semibold focus:outline-none focus:ring-2 focus:ring-[#DAA520] focus:border-[#DAA520] transition-all duration-300"
                         type="password"
                         name="password_confirmation" 
                         placeholder="Ulangi kata sandi"
                         required 
                         autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400" />
        </div>

        <!-- Terms and Conditions -->
        <div class="bg-[#8B4513] bg-opacity-30 rounded-lg p-4 md:p-6 border border-[#DAA520]">
            <div class="flex items-start space-x-3">
                <input type="checkbox" 
                       id="terms" 
                       required
                       class="mt-1 rounded border-[#8B4513] text-[#DAA520] shadow-sm focus:ring-[#DAA520] focus:border-[#DAA520] bg-[#F5DEB3]">
                <label for="terms" class="text-sm md:text-base text-[#F5DEB3] leading-relaxed">
                    Saya setuju dengan <a href="#" class="text-[#DAA520] hover:text-[#F5DEB3] font-semibold underline">Syarat dan Ketentuan</a> 
                    serta <a href="#" class="text-[#DAA520] hover:text-[#F5DEB3] font-semibold underline">Kebijakan Privasi</a> 
                    Arpul dan siap menjadi bagian dari keluarga pecinta kopi sejati! ☕
                </label>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-6 md:mt-8">
            <a class="text-sm md:text-base text-[#DAA520] hover:text-[#F5DEB3] font-semibold transition-colors duration-300 underline text-center sm:text-left" 
               href="{{ route('login') }}">
                Sudah punya akun? Masuk di sini
            </a>

            <x-primary-button class="w-full sm:w-auto bg-gradient-to-r from-[#8B4513] to-[#A0522D] hover:from-[#A0522D] hover:to-[#8B4513] text-[#F5DEB3] font-bold py-3 md:py-4 px-6 md:px-8 rounded-lg text-base md:text-lg transition-all duration-300 transform hover:scale-105 border-2 border-[#DAA520] shadow-lg">
                🚀 DAFTAR SEKARANG
            </x-primary-button>
        </div>

        <!-- Benefits Section -->
        <div class="mt-8 md:mt-10 pt-6 border-t border-[#8B4513]">
            <h3 class="text-[#F5DEB3] font-bold text-center mb-4 text-lg md:text-xl font-brand" style="font-family: 'Bebas Neue', cursive;">
                KEUNTUNGAN MEMBER
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="text-center bg-[#8B4513] bg-opacity-20 rounded-lg p-3 md:p-4">
                    <div class="text-2xl md:text-3xl text-[#DAA520] mb-2">🎯</div>
                    <p class="text-[#F5DEB3] text-sm md:text-base font-semibold">Diskon Khusus Member</p>
                </div>
                <div class="text-center bg-[#8B4513] bg-opacity-20 rounded-lg p-3 md:p-4">
                    <div class="text-2xl md:text-3xl text-[#DAA520] mb-2">⭐</div>
                    <p class="text-[#F5DEB3] text-sm md:text-base font-semibold">Poin Reward Setiap Pembelian</p>
                </div>
                <div class="text-center bg-[#8B4513] bg-opacity-20 rounded-lg p-3 md:p-4 sm:col-span-2 lg:col-span-1">
                    <div class="text-2xl md:text-3xl text-[#DAA520] mb-2">🔔</div>
                    <p class="text-[#F5DEB3] text-sm md:text-base font-semibold">Update Menu & Promo Terbaru</p>
                </div>
            </div>
        </div>
    </form>
</x-guest-layout>
