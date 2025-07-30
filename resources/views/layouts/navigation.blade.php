<nav x-data="{ open: false }" class="bg-[#2F1B14] border-b-2 border-[#8B4513] shadow-lg relative z-10">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 md:h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 md:space-x-3">
                        <img src="{{ asset('images/logo/arpul.PNG') }}" alt="Arpul Logo" class="w-8 h-8 md:w-10 md:h-10 object-contain">
                        <div class="flex flex-col">
                            <span class="text-[#F5DEB3] font-bold text-sm md:text-lg" style="font-family: 'Bebas Neue', cursive; letter-spacing: 1px;">ARPUL</span>
                            <span class="text-[#DAA520] font-bold text-xs md:text-sm" style="font-family: 'Bebas Neue', cursive; letter-spacing: 1px;">CREATIVE COMPOUND</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden lg:space-x-6 xl:space-x-8 sm:-my-px sm:ml-6 lg:ml-10 lg:flex items-center relative z-10">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-[#F5DEB3] hover:text-[#DAA520] focus:border-[#DAA520] font-semibold transition-colors duration-300 text-sm lg:text-base">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    
                    {{-- MENU UNTUK ADMIN --}}
                    @if(auth()->user()->role === 'admin')
                    <x-nav-link :href="route('admin.admin.products.index')" :active="request()->routeIs('admin.admin.products.*')" class="text-[#F5DEB3] hover:text-[#DAA520] focus:border-[#DAA520] font-semibold transition-colors duration-300 text-sm lg:text-base">
                        <span class="hidden xl:inline">☕ Produk</span>
                        <span class="xl:hidden">☕</span>
                    </x-nav-link>
                    <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="text-[#F5DEB3] hover:text-[#DAA520] focus:border-[#DAA520] font-semibold transition-colors duration-300 text-sm lg:text-base">
                        <span class="hidden xl:inline">👥 Users</span>
                        <span class="xl:hidden">👥</span>
                    </x-nav-link>
                    <x-nav-link :href="route('admin.notifications.index')" :active="request()->routeIs('admin.notifications.*')" class="text-[#F5DEB3] hover:text-[#DAA520] focus:border-[#DAA520] font-semibold transition-colors duration-300 text-sm lg:text-base">
                        <span class="hidden xl:inline">📢 Notifikasi</span>
                        <span class="xl:hidden">📢</span>
                    </x-nav-link>
                    <x-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')" class="text-[#F5DEB3] hover:text-[#DAA520] focus:border-[#DAA520] font-semibold transition-colors duration-300 text-sm lg:text-base">
                        <span class="hidden xl:inline">📊 Laporan</span>
                        <span class="xl:hidden">📊</span>
                    </x-nav-link>
                    @endif
                    
                    {{-- MENU UNTUK KASIR --}}
                    @if(auth()->user()->role === 'kasir')
                    <x-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.*')" class="text-[#F5DEB3] hover:text-[#DAA520] focus:border-[#DAA520] font-semibold transition-colors duration-300 text-sm lg:text-base">
                        <span class="hidden xl:inline">💳 Kasir</span>
                        <span class="xl:hidden">💳</span>
                    </x-nav-link>
                    @endif

                    {{-- MENU UNTUK MEMBER --}}
                    @if(auth()->user()->role === 'member')
                    <x-nav-link :href="route('menu.index')" :active="request()->routeIs('menu.*')" class="text-[#F5DEB3] hover:text-[#DAA520] focus:border-[#DAA520] font-semibold transition-colors duration-300 text-sm lg:text-base">
                        <span class="hidden xl:inline">🍴 Menu</span>
                        <span class="xl:hidden">🍴</span>
                    </x-nav-link>
                    <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')" class="text-[#F5DEB3] hover:text-[#DAA520] focus:border-[#DAA520] font-semibold transition-colors duration-300 text-sm lg:text-base">
                        <span class="hidden xl:inline">🛍️ Pesanan</span>
                        <span class="xl:hidden">🛍️</span>
                    </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- User Info and Logout -->
            <div class="hidden lg:flex lg:items-center lg:ml-6 space-x-2 xl:space-x-4">
                <!-- User Info -->
                <div class="hidden xl:flex items-center space-x-2 text-[#F5DEB3]">
                    <div class="text-lg">👤</div>
                    <span class="font-semibold text-sm">{{ Str::limit(Auth::user()->name, 15) }}</span>
                </div>
                
                <!-- Profile Link -->
                <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-2 xl:px-3 py-2 border border-[#8B4513] text-xs xl:text-sm font-semibold rounded-lg text-[#F5DEB3] bg-[#8B4513] hover:bg-[#A0522D] hover:text-[#DAA520] focus:outline-none transition ease-in-out duration-300 shadow-md">
                    <span class="xl:hidden">⚙️</span>
                    <span class="hidden xl:inline">⚙️ Profile</span>
                </a>
                
                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-2 xl:px-4 py-2 border border-red-600 text-xs xl:text-sm font-semibold rounded-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none transition ease-in-out duration-300 shadow-md">
                        <span class="xl:hidden">🚪</span>
                        <span class="hidden xl:inline">🚪 Logout</span>
                    </button>
                </form>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center lg:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-[#F5DEB3] hover:text-[#DAA520] hover:bg-[#8B4513] focus:outline-none focus:bg-[#8B4513] transition duration-300 ease-in-out border border-[#8B4513]">
                    <svg class="h-5 w-5 md:h-6 md:w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden bg-[#2F1B14] border-t border-[#8B4513] responsive-nav"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-[#F5DEB3] hover:text-[#DAA520] hover:bg-[#8B4513]">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            @if(auth()->user()->role === 'admin')
            <x-responsive-nav-link :href="route('admin.admin.products.index')" :active="request()->routeIs('admin.admin.products.*')" class="text-[#F5DEB3] hover:text-[#DAA520] hover:bg-[#8B4513]">
                {{ __('☕ Products') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="text-[#F5DEB3] hover:text-[#DAA520] hover:bg-[#8B4513]">
                {{ __('👥 Users') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.notifications.index')" :active="request()->routeIs('admin.notifications.*')" class="text-[#F5DEB3] hover:text-[#DAA520] hover:bg-[#8B4513]">
                {{ __('📢 Notifications') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')" class="text-[#F5DEB3] hover:text-[#DAA520] hover:bg-[#8B4513]">
                {{ __('📊 Reports') }}
            </x-responsive-nav-link>
            @endif
            
            @if(auth()->user()->role === 'kasir')
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
