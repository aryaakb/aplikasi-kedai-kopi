<x-app-layout>
    <x-slot name="header">
        <h2 class="font-brand text-3xl leading-tight text-[#F5DEB3]">
            ➕ TAMBAH PRODUK BARU
        </h2>
    </x-slot>

    {{-- Alpine.js component untuk menangani modal dan validasi --}}
    <div x-data="{
        showCategoryModal: false, 
        newCategoryName: '',
        // Form validation data
        form: {
            name: '',
            category: '',
            description: '',
            price: '',
            stock: '',
            image_url: ''
        },
        errors: {},
        
        // Validation methods
        validateName() {
            if (this.form.name.trim() === '') {
                this.errors.name = 'Nama produk harus diisi';
                return false;
            } else if (this.form.name.length < 3) {
                this.errors.name = 'Nama produk minimal 3 karakter';
                return false;
            }
            delete this.errors.name;
            return true;
        },
        
        validatePrice() {
            if (this.form.price === '' || this.form.price <= 0) {
                this.errors.price = 'Harga harus lebih dari 0';
                return false;
            } else if (this.form.price < 1000) {
                this.errors.price = 'Harga minimal Rp 1.000';
                return false;
            }
            delete this.errors.price;
            return true;
        },
        
        validateStock() {
            if (this.form.stock === '' || this.form.stock < 0) {
                this.errors.stock = 'Stok tidak boleh negatif';
                return false;
            }
            delete this.errors.stock;
            return true;
        },
        
        validateCategory() {
            if (this.form.category === '') {
                this.errors.category = 'Kategori harus dipilih';
                return false;
            }
            delete this.errors.category;
            return true;
        },
        
        validateUrl() {
            if (this.form.image_url && this.form.image_url.trim() !== '') {
                const urlPattern = /^https?:\/\/.+/;
                if (!urlPattern.test(this.form.image_url)) {
                    this.errors.image_url = 'URL gambar harus diawali dengan http:// atau https://';
                    return false;
                }
            }
            delete this.errors.image_url;
            return true;
        },
        
        validateForm() {
            const nameValid = this.validateName();
            const priceValid = this.validatePrice();
            const stockValid = this.validateStock();
            const categoryValid = this.validateCategory();
            const urlValid = this.validateUrl();
            
            return nameValid && priceValid && stockValid && categoryValid && urlValid;
        }
    }">
        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gradient-to-br from-[#8B4513] to-[#A0522D] overflow-hidden shadow-xl sm:rounded-xl border-2 border-[#DAA520]">
                    <div class="p-8">
                        <div class="mb-6 text-center">
                            <h3 class="font-brand text-2xl text-[#F5DEB3] mb-2">🔥 TAMBAH PRODUK NOFVCKINGCOFFEE 🔥</h3>
                            <p class="text-[#DAA520] text-sm">Buat produk kopi tanpa drama yang berkualitas!</p>
                        </div>
                        
                        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" 
                              @submit="if(!validateForm()) { $event.preventDefault(); }"
                              class="bg-[#F5DEB3] rounded-xl p-6 border-2 border-[#DAA520]">
                            @csrf
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-bold text-[#2F1B14] mb-2">☕ Nama Produk</label>
                                    <input type="text" 
                                           name="name" 
                                           id="name" 
                                           x-model="form.name"
                                           @blur="validateName()"
                                           @input="validateName()"
                                           :class="{'border-red-500': errors.name, 'border-[#8B4513]': !errors.name}"
                                           class="w-full border-2 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-[#DAA520] focus:border-[#DAA520] font-semibold text-[#2F1B14]" 
                                           placeholder="Contoh: Honest Americano" required>
                                    <div x-show="errors.name" x-text="errors.name" class="text-red-500 text-sm mt-1"></div>
                                </div>

                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <label for="category" class="block text-sm font-bold text-[#2F1B14]">🏷️ Kategori</label>
                                        <button @click.prevent="showCategoryModal = true" type="button" class="text-sm text-[#8B4513] hover:text-[#DAA520] font-semibold transition-colors">
                                            ➕ Tambah Kategori Baru
                                        </button>
                                    </div>
                                    <select name="category" 
                                            id="category" 
                                            x-model="form.category"
                                            @change="validateCategory()"
                                            :class="{'border-red-500': errors.category, 'border-[#8B4513]': !errors.category}"
                                            class="w-full border-2 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-[#DAA520] focus:border-[#DAA520] font-semibold text-[#2F1B14]" required>
                                        <option value="" disabled selected>Pilih Kategori Produk</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category }}">{{ $category }}</option>
                                        @endforeach
                                    </select>
                                    <div x-show="errors.category" x-text="errors.category" class="text-red-500 text-sm mt-1"></div>
                                </div>

                                <div>
                                    <label for="description" class="block text-sm font-bold text-[#2F1B14] mb-2">📝 Deskripsi Produk</label>
                                    <textarea name="description" id="description" rows="4" class="w-full border-2 border-[#8B4513] rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-[#DAA520] focus:border-[#DAA520] text-[#2F1B14]" placeholder="Ceritakan tentang produk ini... Contoh: Espresso murni tanpa drama, rasa yang jujur dan kuat."></textarea>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="price" class="block text-sm font-bold text-[#2F1B14] mb-2">💰 Harga (Rp)</label>
                                        <input type="number" 
                                               name="price" 
                                               id="price" 
                                               min="0" 
                                               step="1000" 
                                               x-model="form.price"
                                               @blur="validatePrice()"
                                               @input="validatePrice()"
                                               :class="{'border-red-500': errors.price, 'border-[#8B4513]': !errors.price}"
                                               class="w-full border-2 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-[#DAA520] focus:border-[#DAA520] font-semibold text-[#2F1B14]" 
                                               placeholder="25000" required>
                                        <div x-show="errors.price" x-text="errors.price" class="text-red-500 text-sm mt-1"></div>
                                    </div>

                                    <div>
                                        <label for="stock" class="block text-sm font-bold text-[#2F1B14] mb-2">📦 Stok</label>
                                        <input type="number" 
                                               name="stock" 
                                               id="stock" 
                                               min="0" 
                                               x-model="form.stock"
                                               @blur="validateStock()"
                                               @input="validateStock()"
                                               :class="{'border-red-500': errors.stock, 'border-[#8B4513]': !errors.stock}"
                                               class="w-full border-2 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-[#DAA520] focus:border-[#DAA520] font-semibold text-[#2F1B14]" 
                                               placeholder="50" required>
                                        <div x-show="errors.stock" x-text="errors.stock" class="text-red-500 text-sm mt-1"></div>
                                    </div>
                                </div>

                                <div>
                                    <label for="image_url" class="block text-sm font-bold text-[#2F1B14] mb-2">🖼️ URL Gambar</label>
                                    <input type="url" 
                                           name="image_url" 
                                           id="image_url" 
                                           x-model="form.image_url"
                                           @blur="validateUrl()"
                                           @input="validateUrl()"
                                           :class="{'border-red-500': errors.image_url, 'border-[#8B4513]': !errors.image_url}"
                                           class="w-full border-2 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-[#DAA520] focus:border-[#DAA520] text-[#2F1B14]" 
                                           placeholder="https://images.unsplash.com/photo-xxx">
                                    <div x-show="errors.image_url" x-text="errors.image_url" class="text-red-500 text-sm mt-1"></div>
                                    <p class="mt-2 text-sm text-[#8B4513]">💡 Tips: Gunakan URL gambar dari Unsplash untuk hasil terbaik</p>
                                </div>

                                <div>
                                    <label for="image" class="block text-sm font-bold text-[#2F1B14] mb-2">📤 Atau Upload Gambar</label>
                                    <input type="file" name="image" id="image" accept="image/*" class="w-full text-sm text-[#2F1B14] file:mr-4 file:py-3 file:px-4 file:rounded-lg file:border-2 file:border-[#8B4513] file:text-sm file:font-semibold file:bg-[#DAA520] file:text-[#2F1B14] hover:file:bg-[#B8860B] file:transition-colors">
                                </div>

                                <div class="flex justify-end gap-4 pt-4">
                                    <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-300">
                                        ❌ Batal
                                    </a>
                                    <button type="submit" class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-300">
                                        💾 SIMPAN PRODUK
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal untuk menambah kategori baru -->
        <div x-show="showCategoryModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
            <div @click.away="showCategoryModal = false" class="bg-gradient-to-br from-[#F5DEB3] to-[#E6D3A3] rounded-xl shadow-2xl p-6 w-full max-w-md mx-4 border-2 border-[#DAA520]">
                <h3 class="font-brand text-2xl text-[#2F1B14] mb-6 text-center">🏷️ TAMBAH KATEGORI BARU</h3>
                <div>
                    <label for="new_category_name_create" class="block text-sm font-bold text-[#2F1B14] mb-2">☕ Nama Kategori</label>
                    <input type="text" id="new_category_name_create" x-model="newCategoryName" @keydown.enter.prevent="
                        if (newCategoryName.trim() !== '') {
                            const select = document.getElementById('category');
                            const option = document.createElement('option');
                            option.value = newCategoryName.trim();
                            option.text = newCategoryName.trim();
                            option.selected = true;
                            select.appendChild(option);
                            newCategoryName = '';
                            showCategoryModal = false;
                        }
                    " class="w-full border-2 border-[#8B4513] rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-[#DAA520] focus:border-[#DAA520] font-semibold text-[#2F1B14]" placeholder="Contoh: Minuman Dingin, Makanan, dll">
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button @click="showCategoryModal = false" type="button" class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-bold py-3 px-4 rounded-lg transition-all duration-300">
                        ❌ Batal
                    </button>
                    <button @click="
                        if (newCategoryName.trim() !== '') {
                            const select = document.getElementById('category');
                            const option = document.createElement('option');
                            option.value = newCategoryName.trim();
                            option.text = newCategoryName.trim();
                            option.selected = true;
                            select.appendChild(option);
                            newCategoryName = '';
                            showCategoryModal = false;
                        }
                    " type="button" class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-3 px-4 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-300">
                        💾 SIMPAN KATEGORI
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>