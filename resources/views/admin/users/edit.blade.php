<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h2 class="font-brand text-2xl md:text-3xl text-[#F5DEB3]">
                ✏️ EDIT USER: {{ $user->name }}
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
                        <div class="h-16 w-16 mx-auto rounded-full bg-gradient-to-r from-[#F5DEB3] to-[#E6D3A3] flex items-center justify-center text-[#2F1B14] font-bold text-2xl mb-2">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <h3 class="font-brand text-xl md:text-2xl text-[#F5DEB3] mb-2">EDIT USER</h3>
                        <p class="text-[#DAA520] text-sm">Perbarui informasi user {{ $user->name }}</p>
                    </div>

                    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="bg-[#F5DEB3] rounded-xl p-6 border-2 border-[#DAA520]">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-bold text-[#2F1B14] mb-2">👤 Nama Lengkap</label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name', $user->name) }}"
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
                                       value="{{ old('email', $user->email) }}"
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
                                    <option value="member" {{ old('role', $user->role) === 'member' ? 'selected' : '' }}>👤 Member</option>
                                    <option value="kasir" {{ old('role', $user->role) === 'kasir' ? 'selected' : '' }}>💳 Kasir</option>
                                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>👑 Admin</option>
                                </select>
                                @error('role')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password (Optional) -->
                            <div class="bg-[#8B4513] bg-opacity-20 rounded-lg p-4 border border-[#8B4513]">
                                <h4 class="text-[#2F1B14] font-bold mb-3">🔒 Ubah Kata Sandi (Opsional)</h4>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label for="password" class="block text-sm font-semibold text-[#2F1B14] mb-2">Kata Sandi Baru</label>
                                        <input type="password" 
                                               name="password" 
                                               id="password"
                                               class="w-full border border-[#8B4513] rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#DAA520] focus:border-[#DAA520] text-[#2F1B14] @error('password') border-red-500 @enderror" 
                                               placeholder="Kosongkan jika tidak ingin mengubah">
                                        @error('password')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-semibold text-[#2F1B14] mb-2">Konfirmasi Kata Sandi</label>
                                        <input type="password" 
                                               name="password_confirmation" 
                                               id="password_confirmation"
                                               class="w-full border border-[#8B4513] rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#DAA520] focus:border-[#DAA520] text-[#2F1B14]" 
                                               placeholder="Ulangi kata sandi baru">
                                    </div>
                                </div>
                            </div>

                            <!-- Is Active -->
                            <div class="bg-[#8B4513] bg-opacity-20 rounded-lg p-4 border border-[#DAA520]">
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           id="is_active" 
                                           name="is_active"
                                           value="1"
                                           {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                           class="rounded border-[#8B4513] text-[#DAA520] shadow-sm focus:ring-[#DAA520] focus:border-[#DAA520]">
                                    <label for="is_active" class="ml-3 text-[#2F1B14] font-semibold">
                                        {{ $user->is_active ? '✅' : '❌' }} Status Aktif
                                    </label>
                                </div>
                                <p class="text-[#8B4513] text-xs mt-1 ml-7">
                                    {{ $user->is_active ? 'User dapat login dan mengakses sistem' : 'User tidak dapat login ke sistem' }}
                                </p>
                            </div>

                            <!-- User Info -->
                            <div class="bg-blue-100 rounded-lg p-4 border border-blue-300">
                                <h4 class="text-blue-800 font-bold mb-2">ℹ️ Informasi User</h4>
                                <div class="text-sm text-blue-700 space-y-1">
                                    <p><strong>Terdaftar:</strong> {{ $user->created_at->format('d M Y H:i') }}</p>
                                    <p><strong>Terakhir Update:</strong> {{ $user->updated_at->format('d M Y H:i') }}</p>
                                    @if($user->email_verified_at)
                                        <p><strong>Email Verified:</strong> {{ $user->email_verified_at->format('d M Y H:i') }}</p>
                                    @else
                                        <p><strong>Email:</strong> <span class="text-red-600">Belum diverifikasi</span></p>
                                    @endif
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex flex-col sm:flex-row sm:justify-end gap-3 pt-4">
                                <a href="{{ route('admin.users.index') }}" 
                                   class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-300 text-center">
                                    ❌ Batal
                                </a>
                                <button type="submit" 
                                        class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-300">
                                    💾 UPDATE USER
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>