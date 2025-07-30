<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h2 class="font-brand text-2xl md:text-3xl text-[#F5DEB3]">
                👥 MANAJEMEN USER
            </h2>
            <a href="{{ route('admin.users.create') }}" 
               class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-2 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 text-center">
                ➕ Tambah User Baru
            </a>
        </div>
    </x-slot>

    <div class="py-6 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-6 gap-4 md:gap-6 mb-6 md:mb-8">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-4 md:p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm">Total Users</p>
                            <p class="text-2xl md:text-3xl font-bold">{{ $totalUsers }}</p>
                        </div>
                        <div class="text-3xl md:text-4xl opacity-80">👥</div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-4 md:p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm">Admin</p>
                            <p class="text-2xl md:text-3xl font-bold">{{ $totalAdmins }}</p>
                        </div>
                        <div class="text-3xl md:text-4xl opacity-80">👑</div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl p-4 md:p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-emerald-100 text-sm">Kasir</p>
                            <p class="text-2xl md:text-3xl font-bold">{{ $totalKasir }}</p>
                        </div>
                        <div class="text-3xl md:text-4xl opacity-80">💳</div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl p-4 md:p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-cyan-100 text-sm">Member</p>
                            <p class="text-2xl md:text-3xl font-bold">{{ $totalMembers }}</p>
                        </div>
                        <div class="text-3xl md:text-4xl opacity-80">👤</div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-4 md:p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm">Aktif</p>
                            <p class="text-2xl md:text-3xl font-bold">{{ $activeUsers }}</p>
                        </div>
                        <div class="text-3xl md:text-4xl opacity-80">✅</div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-4 md:p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-red-100 text-sm">Nonaktif</p>
                            <p class="text-2xl md:text-3xl font-bold">{{ $inactiveUsers }}</p>
                        </div>
                        <div class="text-3xl md:text-4xl opacity-80">❌</div>
                    </div>
                </div>
            </div>

            <!-- Filters and Search -->
            <div class="bg-gradient-to-br from-[#8B4513] to-[#A0522D] rounded-xl p-4 md:p-6 mb-6 border-2 border-[#DAA520]">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-[#F5DEB3] text-sm font-semibold mb-2">🔍 Cari User</label>
                        <input type="text" 
                               name="search" 
                               value="{{ $search }}"
                               placeholder="Nama atau email..."
                               class="w-full px-3 py-2 border border-[#8B4513] rounded-lg bg-[#F5DEB3] text-[#2F1B14] focus:outline-none focus:ring-2 focus:ring-[#DAA520]">
                    </div>
                    
                    <div>
                        <label class="block text-[#F5DEB3] text-sm font-semibold mb-2">👑 Role</label>
                        <select name="role" class="w-full px-3 py-2 border border-[#8B4513] rounded-lg bg-[#F5DEB3] text-[#2F1B14] focus:outline-none focus:ring-2 focus:ring-[#DAA520]">
                            <option value="">Semua Role</option>
                            <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="kasir" {{ $role === 'kasir' ? 'selected' : '' }}>Kasir</option>
                            <option value="member" {{ $role === 'member' ? 'selected' : '' }}>Member</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-[#F5DEB3] text-sm font-semibold mb-2">📊 Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-[#8B4513] rounded-lg bg-[#F5DEB3] text-[#2F1B14] focus:outline-none focus:ring-2 focus:ring-[#DAA520]">
                            <option value="">Semua Status</option>
                            <option value="1" {{ $status === '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ $status === '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                    
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-[#DAA520] hover:bg-[#B8860B] text-[#2F1B14] font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                            🔍 Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Users Table -->
            <div class="bg-gradient-to-br from-[#F5DEB3] to-[#E6D3A3] rounded-xl shadow-xl overflow-hidden border-2 border-[#DAA520]">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-[#8B4513] to-[#A0522D]">
                            <tr>
                                <th class="px-4 py-3 text-left text-[#F5DEB3] font-bold text-sm">👤 User</th>
                                <th class="px-4 py-3 text-left text-[#F5DEB3] font-bold text-sm">📧 Email</th>
                                <th class="px-4 py-3 text-left text-[#F5DEB3] font-bold text-sm">👑 Role</th>
                                <th class="px-4 py-3 text-left text-[#F5DEB3] font-bold text-sm">📊 Status</th>
                                <th class="px-4 py-3 text-left text-[#F5DEB3] font-bold text-sm">📅 Terdaftar</th>
                                <th class="px-4 py-3 text-center text-[#F5DEB3] font-bold text-sm">⚡ Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#D2B48C]">
                            @forelse($users as $user)
                                <tr class="hover:bg-[#D2B48C] transition-colors duration-200">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-r from-[#8B4513] to-[#A0522D] flex items-center justify-center text-[#F5DEB3] font-bold">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-[#2F1B14] font-semibold">{{ $user->name }}</p>
                                                @if($user->id === auth()->id())
                                                    <p class="text-[#8B4513] text-xs">👑 Anda</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-[#2F1B14]">{{ $user->email }}</td>
                                    <td class="px-4 py-3">
                                        @if($user->role === 'admin')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                👑 Admin
                                            </span>
                                        @elseif($user->role === 'kasir')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                💳 Kasir
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                👤 Member
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($user->is_active)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                ✅ Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                ❌ Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-[#2F1B14] text-sm">
                                        {{ $user->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('admin.users.show', $user) }}" 
                                               class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                                👁️ Lihat
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user) }}" 
                                               class="text-yellow-600 hover:text-yellow-800 font-medium text-sm">
                                                ✏️ Edit
                                            </a>
                                            @if($user->id !== auth()->id())
                                                <form method="POST" action="{{ route('admin.users.toggle', $user) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                            class="text-{{ $user->is_active ? 'red' : 'green' }}-600 hover:text-{{ $user->is_active ? 'red' : 'green' }}-800 font-medium text-sm">
                                                        {{ $user->is_active ? '🔒 Nonaktif' : '🔓 Aktif' }}
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" 
                                                      onsubmit="return confirm('Yakin ingin menghapus user {{ $user->name }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm">
                                                        🗑️ Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-[#8B4513]">
                                        <div class="text-4xl mb-2">😔</div>
                                        <p>Tidak ada user yang ditemukan</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                    <div class="bg-[#D2B48C] px-4 py-3 border-t border-[#8B4513]">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>