<x-guest-layout>
    <div class="text-center mb-6 md:mb-8">
        <div class="text-4xl md:text-5xl lg:text-6xl text-[#DAA520] mb-2">☕</div>
        <h2 class="font-brand text-2xl md:text-3xl lg:text-4xl text-[#F5DEB3] mb-2" style="font-family: 'Bebas Neue', cursive;">
            MASUK KE AKUN ANDA
        </h2>
        <p class="text-[#DAA520] text-sm md:text-base">Nikmati kopi premium tanpa drama</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4 md:space-y-6">
        @csrf

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
                         autofocus 
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
                         placeholder="Masukkan kata sandi"
                         required 
                         autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center mt-4 md:mt-6">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" 
                       type="checkbox" 
                       class="rounded border-[#8B4513] text-[#DAA520] shadow-sm focus:ring-[#DAA520] focus:border-[#DAA520] bg-[#F5DEB3]" 
                       name="remember">
                <span class="ml-2 text-sm md:text-base text-[#F5DEB3] font-medium">Ingat saya</span>
            </label>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-6 md:mt-8">
            @if (Route::has('password.request'))
                <a class="text-sm md:text-base text-[#DAA520] hover:text-[#F5DEB3] font-semibold transition-colors duration-300 underline" 
                   href="{{ route('password.request') }}">
                    Lupa kata sandi?
                </a>
            @endif

            <x-primary-button class="w-full sm:w-auto bg-gradient-to-r from-[#8B4513] to-[#A0522D] hover:from-[#A0522D] hover:to-[#8B4513] text-[#F5DEB3] font-bold py-3 md:py-4 px-6 md:px-8 rounded-lg text-base md:text-lg transition-all duration-300 transform hover:scale-105 border-2 border-[#DAA520] shadow-lg">
                🚀 MASUK SEKARANG
            </x-primary-button>
        </div>

        <!-- Register Link -->
        <div class="text-center mt-6 md:mt-8 pt-6 border-t border-[#8B4513]">
            <p class="text-[#F5DEB3] text-sm md:text-base mb-3">
                Belum punya akun?
            </p>
            <a href="{{ route('register') }}" 
               class="bg-transparent hover:bg-[#8B4513] text-[#DAA520] hover:text-[#F5DEB3] font-bold py-2 md:py-3 px-6 md:px-8 rounded-lg text-sm md:text-base transition-all duration-300 border-2 border-[#DAA520] hover:border-[#F5DEB3] inline-block">
                📝 DAFTAR SEKARANG
            </a>
        </div>
    </form>
</x-guest-layout>
