<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h2 class="font-brand text-2xl md:text-3xl text-[#F5DEB3]">
                📢 MANAJEMEN NOTIFIKASI
            </h2>
            <div class="flex flex-col sm:flex-row gap-2">
                <a href="{{ route('admin.notifications.create') }}" 
                   class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-2 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 text-center">
                    ➕ Buat Notifikasi
                </a>
                <button onclick="document.getElementById('broadcastModal').classList.remove('hidden')"
                        class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold py-2 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 text-center">
                    📡 Broadcast Cepat
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-6 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-4 md:p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm">Total</p>
                            <p class="text-2xl md:text-3xl font-bold">{{ $stats['total'] }}</p>
                        </div>
                        <div class="text-3xl md:text-4xl opacity-80">📢</div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-4 md:p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm">Aktif</p>
                            <p class="text-2xl md:text-3xl font-bold">{{ $stats['active'] }}</p>
                        </div>
                        <div class="text-3xl md:text-4xl opacity-80">✅</div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-4 md:p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-orange-100 text-sm">Maintenance</p>
                            <p class="text-2xl md:text-3xl font-bold">{{ $stats['maintenance'] }}</p>
                        </div>
                        <div class="text-3xl md:text-4xl opacity-80">🔧</div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-4 md:p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm">Terjadwal</p>
                            <p class="text-2xl md:text-3xl font-bold">{{ $stats['scheduled'] }}</p>
                        </div>
                        <div class="text-3xl md:text-4xl opacity-80">⏰</div>
                    </div>
                </div>
            </div>

            <!-- Notifications Table -->
            <div class="bg-gradient-to-br from-[#F5DEB3] to-[#E6D3A3] rounded-xl shadow-xl overflow-hidden border-2 border-[#DAA520]">
                <div class="bg-gradient-to-r from-[#8B4513] to-[#A0522D] p-4">
                    <h3 class="font-brand text-lg text-[#F5DEB3]">📋 DAFTAR NOTIFIKASI</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-[#D2B48C]">
                            <tr>
                                <th class="px-4 py-3 text-left text-[#2F1B14] font-bold text-sm">📢 Notifikasi</th>
                                <th class="px-4 py-3 text-left text-[#2F1B14] font-bold text-sm">🏷️ Tipe</th>
                                <th class="px-4 py-3 text-left text-[#2F1B14] font-bold text-sm">📊 Status</th>
                                <th class="px-4 py-3 text-left text-[#2F1B14] font-bold text-sm">⏰ Jadwal</th>
                                <th class="px-4 py-3 text-center text-[#2F1B14] font-bold text-sm">⚡ Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#D2B48C]">
                            @forelse($notifications as $notification)
                                <tr class="hover:bg-[#D2B48C] transition-colors duration-200">
                                    <td class="px-4 py-3">
                                        <div>
                                            <h4 class="text-[#2F1B14] font-semibold text-sm">{{ $notification->title }}</h4>
                                            <p class="text-[#8B4513] text-xs mt-1 line-clamp-2">{{ Str::limit($notification->message, 100) }}</p>
                                            <p class="text-[#8B4513] text-xs mt-1">{{ $notification->created_at->format('d M Y H:i') }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($notification->type === 'maintenance')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                🔧 Maintenance
                                            </span>
                                        @elseif($notification->type === 'warning')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                ⚠️ Warning
                                            </span>
                                        @elseif($notification->type === 'success')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                ✅ Success
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                ℹ️ Info
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($notification->is_active)
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
                                        @if($notification->scheduled_at)
                                            <div>
                                                <p class="font-medium">{{ $notification->scheduled_at->format('d M Y H:i') }}</p>
                                                @if($notification->expires_at)
                                                    <p class="text-xs text-[#8B4513]">Berakhir: {{ $notification->expires_at->format('d M H:i') }}</p>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-[#8B4513] text-xs">Tidak dijadwal</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('admin.notifications.show', $notification) }}" 
                                               class="text-blue-600 hover:text-blue-800 font-medium text-xs">
                                                👁️ Lihat
                                            </a>
                                            <a href="{{ route('admin.notifications.edit', $notification) }}" 
                                               class="text-yellow-600 hover:text-yellow-800 font-medium text-xs">
                                                ✏️ Edit
                                            </a>
                                            <form method="POST" action="{{ route('admin.notifications.toggle', $notification) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="text-{{ $notification->is_active ? 'red' : 'green' }}-600 hover:text-{{ $notification->is_active ? 'red' : 'green' }}-800 font-medium text-xs">
                                                    {{ $notification->is_active ? '🔒 Off' : '🔓 On' }}
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.notifications.destroy', $notification) }}" class="inline" 
                                                  onsubmit="return confirm('Yakin ingin menghapus notifikasi ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-xs">
                                                    🗑️ Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-[#8B4513]">
                                        <div class="text-4xl mb-2">📭</div>
                                        <p>Belum ada notifikasi yang dibuat</p>
                                        <a href="{{ route('admin.notifications.create') }}" 
                                           class="inline-block mt-2 text-[#DAA520] hover:text-[#B8860B] font-semibold">
                                            Buat notifikasi pertama →
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($notifications->hasPages())
                    <div class="bg-[#D2B48C] px-4 py-3 border-t border-[#8B4513]">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Broadcast Modal -->
    <div id="broadcastModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-gradient-to-br from-[#F5DEB3] to-[#E6D3A3] rounded-xl shadow-2xl p-6 w-full max-w-md mx-4 border-2 border-[#DAA520]">
            <div class="text-center mb-4">
                <div class="text-4xl text-[#DAA520] mb-2">📡</div>
                <h3 class="font-brand text-xl text-[#2F1B14] mb-2">BROADCAST CEPAT</h3>
                <p class="text-[#8B4513] text-sm">Kirim notifikasi langsung ke semua user</p>
            </div>
            
            <form method="POST" action="{{ route('admin.broadcast') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="broadcast_title" class="block text-sm font-bold text-[#2F1B14] mb-2">📢 Judul</label>
                        <input type="text" 
                               name="title" 
                               id="broadcast_title" 
                               required
                               class="w-full border-2 border-[#8B4513] rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#DAA520] focus:border-[#DAA520] text-[#2F1B14]" 
                               placeholder="Contoh: Maintenance Server">
                    </div>
                    
                    <div>
                        <label for="broadcast_message" class="block text-sm font-bold text-[#2F1B14] mb-2">💬 Pesan</label>
                        <textarea name="message" 
                                  id="broadcast_message" 
                                  rows="3" 
                                  required
                                  class="w-full border-2 border-[#8B4513] rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#DAA520] focus:border-[#DAA520] text-[#2F1B14]" 
                                  placeholder="Tulis pesan yang akan dikirim ke semua user..."></textarea>
                    </div>
                    
                    <div>
                        <label for="broadcast_type" class="block text-sm font-bold text-[#2F1B14] mb-2">🏷️ Tipe</label>
                        <select name="type" 
                                id="broadcast_type" 
                                required
                                class="w-full border-2 border-[#8B4513] rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#DAA520] focus:border-[#DAA520] text-[#2F1B14]">
                            <option value="info">ℹ️ Info</option>
                            <option value="warning">⚠️ Warning</option>
                            <option value="maintenance">🔧 Maintenance</option>
                            <option value="success">✅ Success</option>
                        </select>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" 
                            onclick="document.getElementById('broadcastModal').classList.add('hidden')"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                        ❌ Batal
                    </button>
                    <button type="submit" 
                            class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold py-2 px-4 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-300">
                        📡 KIRIM BROADCAST
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>