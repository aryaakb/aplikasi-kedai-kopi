<nav x-data="{ open: false }" class="bg-[#2F1B14] border-b-2 border-[#8B4513] shadow-lg relative z-10">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                        <span class="text-3xl text-[#DAA520]">☕</span>
                        <div class="flex flex-col">
                            <span class="text-[#F5DEB3] font-bold text-lg" style="font-family: 'Bebas Neue', cursive; letter-spacing: 1px;">NOFVCKING</span>
                            <span class="text-[#DAA520] font-bold text-sm" style="font-family: 'Bebas Neue', cursive; letter-spacing: 1px;">COFFEE</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex items-center relative z-10">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-[#F5DEB3] hover:text-[#DAA520] focus:border-[#DAA520] font-semibold transition-colors duration-300">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    
                    {{-- MENU UNTUK ADMIN --}}
                    @if(auth()->user()->role === 'admin')
                    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')" class="text-[#F5DEB3] hover:text-[#DAA520] focus:border-[#DAA520] font-semibold transition-colors duration-300">
                        {{ __('☕ Produk') }}
                    </x-nav-link>
                    <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')" class="text-[#F5DEB3] hover:text-[#DAA520] focus:border-[#DAA520] font-semibold transition-colors duration-300">
                        {{ __('📊 Laporan') }}
                    </x-nav-link>
                    @endif
                    
                    {{-- MENU UNTUK KASIR --}}
                    @if(auth()->user()->role === 'cashier')
                    <x-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.*')" class="text-[#F5DEB3] hover:text-[#DAA520] focus:border-[#DAA520] font-semibold transition-colors duration-300">
                        {{ __('💳 Kasir') }}
                    </x-nav-link>
                    @endif

                    {{-- MENU UNTUK MEMBER --}}
                    @if(auth()->user()->role === 'member')
                    <x-nav-link :href="route('menu.index')" :active="request()->routeIs('menu.*')" class="text-[#F5DEB3] hover:text-[#DAA520] focus:border-[#DAA520] font-semibold transition-colors duration-300">
                        {{ __('🍴 Menu') }}
                    </x-nav-link>
                    <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')" class="text-[#F5DEB3] hover:text-[#DAA520] focus:border-[#DAA520] font-semibold transition-colors duration-300">
                        {{ __('🛍️ Pesanan Saya') }}
                    </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- User Info and Logout -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                <!-- User Info -->
                <div class="flex items-center space-x-2 text-[#F5DEB3]">
                    <div class="text-lg">👤</div>
                    <span class="font-semibold">{{ Auth::user()->name }}</span>
                </div>
                
                <!-- Profile Link -->
                <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-3 py-2 border border-[#8B4513] text-sm font-semibold rounded-lg text-[#F5DEB3] bg-[#8B4513] hover:bg-[#A0522D] hover:text-[#DAA520] focus:outline-none transition ease-in-out duration-300 shadow-md">
                    ⚙️ Profile
                </a>
                
                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-red-600 text-sm font-semibold rounded-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none transition ease-in-out duration-300 shadow-md">
                        🚪 Logout
                    </button>
                </form>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-3 rounded-lg text-[#F5DEB3] hover:text-[#DAA520] hover:bg-[#8B4513] focus:outline-none focus:bg-[#8B4513] transition duration-300 ease-in-out border border-[#8B4513]">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#2F1B14] border-t border-[#8B4513] responsive-nav">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-[#F5DEB3] hover:text-[#DAA520] hover:bg-[#8B4513]">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            @if(auth()->user()->role === 'admin')
            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')" class="text-[#F5DEB3] hover:text-[#DAA520] hover:bg-[#8B4513]">
                {{ __('☕ Products') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')" class="text-[#F5DEB3] hover:text-[#DAA520] hover:bg-[#8B4513]">
                {{ __('📊 Reports') }}
            </x-responsive-nav-link>
            @endif
            
            @if(auth()->user()->role === 'cashier')
            <x-responsive-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.*')" class="text-[#F5DEB3] hover:text-[#DAA520] hover:bg-[#8B4513]">
                {{ __('💳 POS System') }}
            </x-responsive-nav-link>
            @endif

            @if(auth()->user()->role === 'member')
            <x-responsive-nav-link :href="route('menu.index')" :active="request()->routeIs('menu.*')" class="text-[#F5DEB3] hover:text-[#DAA520] hover:bg-[#8B4513]">
                {{ __('🍴 Menu') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')" class="text-[#F5DEB3] hover:text-[#DAA520] hover:bg-[#8B4513]">
                {{ __('🛍️ My Orders') }}
            </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-[#8B4513]">
            <div class="px-4">
                <div class="font-medium text-base text-[#F5DEB3]">👤 {{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-[#DAA520]">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-[#F5DEB3] hover:text-[#DAA520] hover:bg-[#8B4513]">
                    ⚙️ {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full text-left block px-4 py-2 text-base font-medium text-white bg-red-600 hover:bg-red-700 hover:text-white transition duration-150 ease-in-out rounded-md mx-4">
                        🚪 {{ __('Logout') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
