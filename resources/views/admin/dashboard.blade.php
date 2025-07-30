<x-app-layout>
    <x-slot name="header">
        <h2 class="font-brand text-3xl leading-tight text-[#F5DEB3]">
            👑 ADMIN DASHBOARD
        </h2>
    </x-slot>

    <div class="py-12 relative z-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-0">
            <!-- Welcome Card -->
            <div class="bg-gradient-to-r from-[#8B4513] to-[#A0522D] overflow-visible shadow-xl sm:rounded-lg border-2 border-[#DAA520] mb-8 relative z-0">
                <div class="p-6 text-center">
                    <div class="text-5xl mb-4">👑</div>
                    <h3 class="font-elegant text-2xl text-[#F5DEB3] mb-2">Dashboard Administrator</h3>
                    <p class="text-[#DAA520] font-semibold">Kontrol penuh sistem Arpul</p>
                    <div class="mt-4 text-[#F5DEB3] opacity-90">
                        Selamat datang, <span class="font-bold text-[#DAA520]">{{ Auth::user()->name }}</span>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm">Total Users</p>
                            <p class="text-3xl font-bold">{{ $totalUsers }}</p>
                        </div>
                        <div class="text-4xl opacity-80">👥</div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm">Products</p>
                            <p class="text-3xl font-bold">{{ $totalProducts }}</p>
                        </div>
                        <div class="text-4xl opacity-80">☕</div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm">Notifications</p>
                            <p class="text-3xl font-bold">{{ $totalNotifications }}</p>
                        </div>
                        <div class="text-4xl opacity-80">📢</div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-yellow-100 text-sm">Active Users</p>
                            <p class="text-3xl font-bold">{{ $activeUsers }}</p>
                        </div>
                        <div class="text-4xl opacity-80">✅</div>
                    </div>
                </div>
            </div>

            <!-- Role Breakdown -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-br from-[#8B4513] to-[#A0522D] rounded-xl p-6 border-2 border-[#DAA520]">
                    <h4 class="font-brand text-xl text-[#F5DEB3] mb-4">👑 ADMINS</h4>
                    <div class="text-4xl font-bold text-[#DAA520] mb-2">{{ $totalAdmins }}</div>
                    <p class="text-[#F5DEB3] text-sm">Total administrators</p>
                </div>

                <div class="bg-gradient-to-br from-[#8B4513] to-[#A0522D] rounded-xl p-6 border-2 border-[#DAA520]">
                    <h4 class="font-brand text-xl text-[#F5DEB3] mb-4">💳 KASIR</h4>
                    <div class="text-4xl font-bold text-[#DAA520] mb-2">{{ $totalKasir }}</div>
                    <p class="text-[#F5DEB3] text-sm">Total kasir staff</p>
                </div>

                <div class="bg-gradient-to-br from-[#8B4513] to-[#A0522D] rounded-xl p-6 border-2 border-[#DAA520]">
                    <h4 class="font-brand text-xl text-[#F5DEB3] mb-4">👤 MEMBERS</h4>
                    <div class="text-4xl font-bold text-[#DAA520] mb-2">{{ $totalMembers }}</div>
                    <p class="text-[#F5DEB3] text-sm">Total members</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-[#F5DEB3] to-[#E6D3A3] rounded-xl shadow-xl border-2 border-[#DAA520] p-6">
                <h4 class="font-brand text-2xl text-[#2F1B14] mb-6 text-center">⚡ QUICK ACTIONS</h4>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('admin.users.index') }}" 
                       class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-4 px-6 rounded-lg text-center transition-all duration-300 transform hover:scale-105">
                        <div class="text-2xl mb-2">👥</div>
                        <div class="text-sm">Manage Users</div>
                    </a>

                    <a href="{{ route('admin.admin.products.index') }}" 
                       class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-4 px-6 rounded-lg text-center transition-all duration-300 transform hover:scale-105">
                        <div class="text-2xl mb-2">☕</div>
                        <div class="text-sm">Manage Products</div>
                    </a>

                    <a href="{{ route('admin.notifications.index') }}" 
                       class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-bold py-4 px-6 rounded-lg text-center transition-all duration-300 transform hover:scale-105">
                        <div class="text-2xl mb-2">📢</div>
                        <div class="text-sm">Notifications</div>
                    </a>

                    <a href="{{ route('admin.reports.index') }}" 
                       class="bg-gradient-to-r from-yellow-600 to-yellow-700 hover:from-yellow-700 hover:to-yellow-800 text-white font-bold py-4 px-6 rounded-lg text-center transition-all duration-300 transform hover:scale-105">
                        <div class="text-2xl mb-2">📊</div>
                        <div class="text-sm">Reports</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>