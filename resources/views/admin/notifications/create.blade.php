<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h2 class="font-brand text-2xl md:text-3xl text-[#F5DEB3]">
                ➕ BUAT NOTIFIKASI BARU
            </h2>
            <a href="{{ route('admin.notifications.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300 text-center">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6 md:py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-[#8B4513] to-[#A0522D] overflow-hidden shadow-xl rounded-xl border-2 border-[#DAA520]">
                <div class="p-6 md:p-8">
                    <div class="text-center mb-6">
                        <div class="text-4xl md:text-5xl text-[#DAA520] mb-2">📢</div>
                        <h3 class="font-brand text-xl md:text-2xl text-[#F5DEB3] mb-2">BUAT NOTIFIKASI</h3>
                        <p class="text-[#DAA520] text-sm">Buat pengumuman atau notifikasi untuk semua user</p>
                    </div>

                    <form method="POST" action="{{ route('admin.notifications.store') }}" class="bg-[#F5DEB3] rounded-xl p-6 border-2 border-[#DAA520]">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-bold text-[#2F1B14] mb-2">📢 Judul Notifikasi</label>
                                <input type="text" 
                                       name="title" 
                                       id="title" 
                                       value="{{ old('title') }}"
                                       class="w-full border-2 border-[#8B4513] rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-[#DAA520] focus:border-[#DAA520] font-semibold text-[#2F1B14] @error('title') border-red-500 @enderror" 
                                       placeholder="Contoh: Maintenance Server Minggu Depan" 
                                       required>
                                @error('title')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Message -->
                            <div>
                                <label for="message" class="block text-sm font-bold text-[#2F1B14] mb-2">💬 Pesan Notifikasi</label>
                                <textarea name="message" 
                                          id="message" 
                                          rows="5"
                                          class="w-full border-2 border-[#8B4513] rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-[#DAA520] focus:border-[#DAA520] text-[#2F1B14] @error('message') border-red-500 @enderror" 
                                          placeholder="Tulis pesan lengkap yang akan ditampilkan kepada user..."
                                          required>{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Type and Active Status -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="type" class="block text-sm font-bold text-[#2F1B14] mb-2">🏷️ Tipe Notifikasi</label>
                                    <select name="type" 
                                            id="type" 
                                            class="w-full border-2 border-[#8B4513] rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-[#DAA520] focus:border-[#DAA520] font-semibold text-[#2F1B14] @error('type') border-red-500 @enderror" 
                                            required>
                                        <option value="info" {{ old('type') === 'info' ? 'selected' : '' }}>ℹ️ Info</option>
                                        <option value="warning" {{ old('type') === 'warning' ? 'selected' : '' }}>⚠️ Warning</option>
                                        <option value="success" {{ old('type') === 'success' ? 'selected' : '' }}>✅ Success</option>
                                        <option value="maintenance" {{ old('type') === 'maintenance' ? 'selected' : '' }}>🔧 Maintenance</option>
                                    </select>
                                    @error('type')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-end">
                                    <div class="w-full bg-[#8B4513] bg-opacity-20 rounded-lg p-3 border border-[#DAA520]">
                                        <div class="flex items-center">
                                            <input type="checkbox" 
                                                   id="is_active" 
                                                   name="is_active"
                                                   value="1"
                                                   {{ old('is_active', true) ? 'checked' : '' }}
                                                   class="rounded border-[#8B4513] text-[#DAA520] shadow-sm focus:ring-[#DAA520] focus:border-[#DAA520]">
                                            <label for="is_active" class="ml-2 text-[#2F1B14] font-semibold text-sm">
                                                ✅ Aktifkan notifikasi
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Scheduling -->
                            <div class="bg-[#8B4513] bg-opacity-20 rounded-lg p-4 border border-[#8B4513]">
                                <h4 class="text-[#2F1B14] font-bold mb-3">⏰ Pengaturan Jadwal (Opsional)</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="scheduled_at" class="block text-sm font-semibold text-[#2F1B14] mb-2">📅 Mulai Ditampilkan</label>
                                        <input type="datetime-local" 
                                               name="scheduled_at" 
                                               id="scheduled_at" 
                                               value="{{ old('scheduled_at') }}"
                                               class="w-full border border-[#8B4513] rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#DAA520] focus:border-[#DAA520] text-[#2F1B14] text-sm @error('scheduled_at') border-red-500 @enderror">
                                        <p class="text-[#8B4513] text-xs mt-1">Kosongkan untuk tampil sekarang</p>
                                        @error('scheduled_at')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="expires_at" class="block text-sm font-semibold text-[#2F1B14] mb-2">⏰ Berakhir Pada</label>
                                        <input type="datetime-local" 
                                               name="expires_at" 
                                               id="expires_at" 
                                               value="{{ old('expires_at') }}"
                                               class="w-full border border-[#8B4513] rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#DAA520] focus:border-[#DAA520] text-[#2F1B14] text-sm @error('expires_at') border-red-500 @enderror">
                                        <p class="text-[#8B4513] text-xs mt-1">Kosongkan untuk tidak berakhir</p>
                                        @error('expires_at')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Preview -->
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <h4 class="text-gray-700 font-bold mb-3">👁️ Preview Notifikasi</h4>
                                <div id="notification-preview" class="space-y-2">
                                    <div class="bg-blue-100 border-l-4 border-blue-500 p-3 rounded">
                                        <div class="flex items-center">
                                            <span id="preview-icon">ℹ️</span>
                                            <h5 id="preview-title" class="ml-2 font-semibold text-blue-800">Judul akan muncul di sini...</h5>
                                        </div>
                                        <p id="preview-message" class="text-blue-700 text-sm mt-1">Pesan akan muncul di sini...</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex flex-col sm:flex-row sm:justify-end gap-3 pt-4">
                                <a href="{{ route('admin.notifications.index') }}" 
                                   class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-300 text-center">
                                    ❌ Batal
                                </a>
                                <button type="submit" 
                                        class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-300">
                                    💾 SIMPAN NOTIFIKASI
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Live preview functionality
        document.addEventListener('DOMContentLoaded', function() {
            const titleInput = document.getElementById('title');
            const messageInput = document.getElementById('message');
            const typeSelect = document.getElementById('type');
            const previewTitle = document.getElementById('preview-title');
            const previewMessage = document.getElementById('preview-message');
            const previewIcon = document.getElementById('preview-icon');
            const previewContainer = document.getElementById('notification-preview').firstElementChild;

            const typeConfig = {
                'info': { icon: 'ℹ️', class: 'bg-blue-100 border-blue-500', titleClass: 'text-blue-800', messageClass: 'text-blue-700' },
                'warning': { icon: '⚠️', class: 'bg-yellow-100 border-yellow-500', titleClass: 'text-yellow-800', messageClass: 'text-yellow-700' },
                'success': { icon: '✅', class: 'bg-green-100 border-green-500', titleClass: 'text-green-800', messageClass: 'text-green-700' },
                'maintenance': { icon: '🔧', class: 'bg-orange-100 border-orange-500', titleClass: 'text-orange-800', messageClass: 'text-orange-700' }
            };

            function updatePreview() {
                const title = titleInput.value || 'Judul akan muncul di sini...';
                const message = messageInput.value || 'Pesan akan muncul di sini...';
                const type = typeSelect.value;
                const config = typeConfig[type];

                previewTitle.textContent = title;
                previewMessage.textContent = message;
                previewIcon.textContent = config.icon;
                
                previewContainer.className = `${config.class} border-l-4 p-3 rounded`;
                previewTitle.className = `ml-2 font-semibold ${config.titleClass}`;
                previewMessage.className = `${config.messageClass} text-sm mt-1`;
            }

            titleInput.addEventListener('input', updatePreview);
            messageInput.addEventListener('input', updatePreview);
            typeSelect.addEventListener('change', updatePreview);

            // Initial preview
            updatePreview();
        });
    </script>
</x-app-layout>