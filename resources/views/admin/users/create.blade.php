<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h2 class="font-brand text-2xl md:text-3xl text-[#F5DEB3]">
                ➕ TAMBAH USER BARU
            </h2>
            <a href="{{ route('admin.users.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300 text-center">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6 md:py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-[#8B4513] to-[#A0522D] overflow-hidden shadow-xl rounded-xl border-2 border-[#DAA520]">
                <div class="p-6 md:p-8">
                    <div class="text-center mb-6">
                        <div class="text-4xl md:text-5xl text-[#DAA520] mb-2">👤</div>
                        <h3 class="font-brand text-xl md:text-2xl text-[#F5DEB3] mb-2">BUAT AKUN BARU</h3>
                        <p class="text-[#DAA520] text-sm">Tambahkan user baru ke sistem Arpul</p>
                    </div>

                    <form method="POST" action="{{ route('admin.users.store') }}" class="bg-[#F5DEB3] rounded-xl p-6 border-2 border-[#DAA520]">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-bold text-[#2F1B14] mb-2">👤 Nama Lengkap</label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name') }}"
                                       class="w-full border-2 border-[#8B4513] rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-[#DAA520] focus:border-[#DAA520] font-semibold text-[#2F1B14] @error('name') border-red-500 @enderror" 
                                       placeholder="Masukkan nama lengkap" 
                                       required>
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-bold text-[#2F1B14] mb-2">📧 Alamat Email</label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       value="{{ old('email') }}"
                                       class="w-full border-2 border-[#8B4513] rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-[#DAA520] focus:border-[#DAA520] font-semibold text-[#2F1B14] @error('email') border-red-500 @enderror" 
                                       placeholder="contoh@email.com" 
                                       required>
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div>
                                <label for="role" class="block text-sm font-bold text-[#2F1B14] mb-2">👑 Role User</label>
                                <select name="role" 
                                        id="role" 
                                        class="w-full border-2 border-[#8B4513] rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-[#DAA520] focus:border-[#DAA520] font-semibold text-[#2F1B14] @error('role') border-red-500 @enderror" 
                                        required>
                                    <option value="">Pilih Role</option>
                                    <option value="member" {{ old('role') === 'member' ? 'selected' : '' }}>👤 Member</option>
                                    <option value="kasir" {{ old('role') === 'kasir' ? 'selected' : '' }}>💳 Kasir</option>
                                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>👑 Admin</option>
                                </select>
                                @error('role')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-bold text-[#2F1B14] mb-2">🔒 Kata Sandi</label>
                                <input type="password" 
                                       name="password" 
                                       id="password"
                                       class="w-full border-2 border-[#8B4513] rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-[#DAA520] focus:border-[#DAA520] font-semibold text-[#2F1B14] @error('password') border-red-500 @enderror" 
                                       placeholder="Minimal 8 karakter" 
                                       required>
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-bold text-[#2F1B14] mb-2">🔒 Konfirmasi Kata Sandi</label>
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation"
                                       class="w-full border-2 border-[#8B4513] rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-[#DAA520] focus:border-[#DAA520] font-semibold text-[#2F1B14]" 
                                       placeholder="Ulangi kata sandi" 
                                       required>
                            </div>

                            <!-- Is Active -->
                            <div class="bg-[#8B4513] bg-opacity-20 rounded-lg p-4 border border-[#DAA520]">
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           id="is_active" 
                                           name="is_active"
                                           value="1"
                                           {{ old('is_active', true) ? 'checked' : '' }}
                                           class="rounded border-[#8B4513] text-[#DAA520] shadow-sm focus:ring-[#DAA520] focus:border-[#DAA520]">
                                    <label for="is_active" class="ml-3 text-[#2F1B14] font-semibold">
                                        ✅ Aktifkan user setelah dibuat
                                    </label>
                                </div>
                                <p class="text-[#8B4513] text-xs mt-1 ml-7">User dapat login dan mengakses sistem</p>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex flex-col sm:flex-row sm:justify-end gap-3 pt-4">
                                <a href="{{ route('admin.users.index') }}" 
                                   class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-300 text-center">
                                    ❌ Batal
                                </a>
                                <button type="submit" 
                                        class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-300">
                                    💾 SIMPAN USER
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>