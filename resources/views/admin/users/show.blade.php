<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h2 class="font-brand text-2xl md:text-3xl text-[#F5DEB3]">
                👁️ DETAIL USER: {{ $user->name }}
            </h2>
            <div class="flex flex-col sm:flex-row gap-2">
                <a href="{{ route('admin.users.edit', $user) }}" 
                   class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300 text-center">
                    ✏️ Edit User
                </a>
                <a href="{{ route('admin.users.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300 text-center">
                    ← Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 md:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- User Profile Card -->
                <div class="lg:col-span-1">
                    <div class="bg-gradient-to-br from-[#8B4513] to-[#A0522D] rounded-xl p-6 border-2 border-[#DAA520] text-center">
                        <div class="h-24 w-24 mx-auto rounded-full bg-gradient-to-r from-[#F5DEB3] to-[#E6D3A3] flex items-center justify-center text-[#2F1B14] font-bold text-3xl mb-4">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        
                        <h3 class="font-brand text-xl text-[#F5DEB3] mb-2">{{ $user->name }}</h3>
                        <p class="text-[#DAA520] text-sm mb-4">{{ $user->email }}</p>
                        
                        <div class="space-y-2">
                            @if($user->role === 'admin')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                    👑 Administrator
                                </span>
                            @elseif($user->role === 'kasir')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    💳 Kasir
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    👤 Member
                                </span>
                            @endif
                            
                            @if($user->is_active)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    ✅ Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    ❌ Nonaktif
                                </span>
                            @endif
                        </div>

                        @if($user->id !== auth()->id())
                            <div class="mt-6 space-y-2">
                                <form method="POST" action="{{ route('admin.users.toggle', $user) }}" class="w-full">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="w-full bg-{{ $user->is_active ? 'red' : 'green' }}-600 hover:bg-{{ $user->is_active ? 'red' : 'green' }}-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                                        {{ $user->is_active ? '🔒 Nonaktifkan' : '🔓 Aktifkan' }}
                                    </button>
                                </form>
                                
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                                      onsubmit="return confirm('Yakin ingin menghapus user {{ $user->name }}? Tindakan ini tidak dapat dibatalkan!')"
                                      class="w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                                        🗑️ Hapus User
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="mt-6 bg-blue-100 rounded-lg p-3">
                                <p class="text-blue-800 text-sm font-semibold">👑 Ini adalah akun Anda</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- User Details -->
                <div class="lg:col-span-2">
                    <div class="bg-gradient-to-br from-[#F5DEB3] to-[#E6D3A3] rounded-xl shadow-xl border-2 border-[#DAA520]">
                        <div class="bg-gradient-to-r from-[#8B4513] to-[#A0522D] p-4 rounded-t-xl">
                            <h4 class="font-brand text-lg text-[#F5DEB3]">📋 INFORMASI DETAIL</h4>
                        </div>
                        
                        <div class="p-6 space-y-6">
                            <!-- Basic Information -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-white rounded-lg p-4 border border-[#D2B48C]">
                                    <h5 class="font-semibold text-[#8B4513] mb-2">👤 Nama Lengkap</h5>
                                    <p class="text-[#2F1B14] font-medium">{{ $user->name }}</p>
                                </div>
                                
                                <div class="bg-white rounded-lg p-4 border border-[#D2B48C]">
                                    <h5 class="font-semibold text-[#8B4513] mb-2">📧 Email</h5>
                                    <p class="text-[#2F1B14] font-medium">{{ $user->email }}</p>
                                </div>
                                
                                <div class="bg-white rounded-lg p-4 border border-[#D2B48C]">
                                    <h5 class="font-semibold text-[#8B4513] mb-2">👑 Role</h5>
                                    <p class="text-[#2F1B14] font-medium capitalize">{{ $user->role }}</p>
                                </div>
                                
                                <div class="bg-white rounded-lg p-4 border border-[#D2B48C]">
                                    <h5 class="font-semibold text-[#8B4513] mb-2">📊 Status</h5>
                                    <p class="text-[#2F1B14] font-medium">
                                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Account Timestamps -->
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <h5 class="font-semibold text-gray-700 mb-4">📅 Riwayat Akun</h5>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-600 font-medium">Terdaftar:</p>
                                        <p class="text-gray-800">{{ $user->created_at->format('d M Y, H:i') }}</p>
                                        <p class="text-gray-500 text-xs">{{ $user->created_at->diffForHumans() }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-gray-600 font-medium">Terakhir Update:</p>
                                        <p class="text-gray-800">{{ $user->updated_at->format('d M Y, H:i') }}</p>
                                        <p class="text-gray-500 text-xs">{{ $user->updated_at->diffForHumans() }}</p>
                                    </div>
                                    
                                    @if($user->email_verified_at)
                                        <div>
                                            <p class="text-gray-600 font-medium">Email Verified:</p>
                                            <p class="text-gray-800">{{ $user->email_verified_at->format('d M Y, H:i') }}</p>
                                            <p class="text-green-600 text-xs">✅ Verified</p>
                                        </div>
                                    @else
                                        <div>
                                            <p class="text-gray-600 font-medium">Email Status:</p>
                                            <p class="text-red-600 font-medium">❌ Belum diverifikasi</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Activity Summary (placeholder for future features) -->
                            <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                                <h5 class="font-semibold text-blue-700 mb-4">📊 Ringkasan Aktivitas</h5>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                                    <div>
                                        <p class="text-2xl font-bold text-blue-600">-</p>
                                        <p class="text-blue-700 text-sm">Total Login</p>
                                    </div>
                                    <div>
                                        <p class="text-2xl font-bold text-blue-600">-</p>
                                        <p class="text-blue-700 text-sm">Orders</p>
                                    </div>
                                    <div>
                                        <p class="text-2xl font-bold text-blue-600">-</p>
                                        <p class="text-blue-700 text-sm">Reviews</p>
                                    </div>
                                    <div>
                                        <p class="text-2xl font-bold text-blue-600">{{ $user->role === 'admin' ? 'Admin' : 'Member' }}</p>
                                        <p class="text-blue-700 text-sm">Level</p>
                                    </div>
                                </div>
                                <p class="text-blue-600 text-xs mt-2 text-center">📝 Fitur statistik akan ditambahkan kemudian</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>