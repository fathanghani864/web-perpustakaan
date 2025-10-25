<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8">
        
        {{-- Definisikan Skema Warna --}}
        @php
            // Warna Primary (untuk ikon dan garis penekanan): Emerald 700
            $primaryColorClass = 'text-emerald-700 border-emerald-700';
            // Warna Secondary (untuk card header): Gray 800
            $secondaryColorClass = 'bg-gray-800 text-white';
            // Tombol Simpan: Emerald 600
            $saveButtonClass = 'bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-500';
            // Tombol Kembali: Gray 500
            $backButtonClass = 'bg-gray-500 hover:bg-gray-600 focus:ring-gray-500';
        @endphp

        {{-- Judul Halaman dengan Ikon --}}
        <h1 class="text-3xl font-extrabold mb-6 text-gray-900 flex items-center">
            <i class="fas fa-book-medical mr-3 {{ $primaryColorClass }} text-2xl"></i> Tambah Koleksi Buku Baru
        </h1>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-l-4 {{ $primaryColorClass }}">
            
            {{-- Card Header --}}
            <div class="p-6 flex items-center {{ $secondaryColorClass }} rounded-t-lg">
                <i class="fas fa-info-circle mr-2 text-white"></i>
                <h6 class="text-xl font-semibold">Formulir Detail Metadata Buku</h6>
            </div>
            
            <div class="p-6">
                
                <form action="{{ route('admin.tambah_buku') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    {{-- Bagian 1: Detail Utama --}}
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-6">
                        
                        <div class="md:col-span-7">
                            <div class="mb-4">
                                <label for="nama_buku" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="fas fa-signature mr-1"></i> Judul Buku <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_buku" id="nama_buku" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 
                                    @error('nama_buku') border-red-500 @enderror" 
                                    value="{{ old('nama_buku') }}" placeholder="Contoh: Filsafat Manusia Abad ke-21" required>
                                @error('nama_buku')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                           <div class="mb-4">
                                <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="fas fa-tags mr-1"></i> Kategori <span class="text-red-500">*</span>
                                </label>
                                <select name="kategori" id="kategori" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 
                                    @error('kategori') border-red-500 @enderror" required>
                                    <option value="">--- Pilih Kategori ---</option>
                                    
                                    {{-- Menggunakan string nama kategori --}}
                                    <option value="Fiksi (Novel)" {{ old('kategori') == 'Fiksi (Novel)' ? 'selected' : '' }}>Fiksi (Novel)</option>
                                    <option value="Non-Fiksi (Sains)" {{ old('kategori') == 'Non-Fiksi (Sains)' ? 'selected' : '' }}>Non-Fiksi (Sains)</option>
                                    <option value="Sejarah & Budaya" {{ old('kategori') == 'Sejarah & Budaya' ? 'selected' : '' }}>Sejarah & Budaya</option>
                                    <option value="Teknologi & Komputer" {{ old('kategori') == 'Teknologi & Komputer' ? 'selected' : '' }}>Teknologi & Komputer</option>

                                </select>
                                @error('kategori')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div> {{-- End Col-span-7 --}}
                        
                        <div class="md:col-span-5">
                            <div class="mb-4">
                                <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="fas fa-box-open mr-1"></i> Jumlah Stok <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="jumlah" id="jumlah" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 
                                    @error('jumlah') border-red-500 @enderror" 
                                    value="{{ old('jumlah') }}" min="0" placeholder="Masukkan jumlah stok awal" required>
                                @error('jumlah')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="tahun_terbit" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="fas fa-calendar-alt mr-1"></i> Tahun Terbit
                                </label>
                                <input type="number" name="tahun_terbit" id="tahun_terbit" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 
                                    @error('tahun_terbit') border-red-500 @enderror" 
                                    value="{{ old('tahun_terbit') }}" min="1900" max="{{ date('Y') }}" placeholder="{{ date('Y') }}">
                                @error('tahun_terbit')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div> {{-- End Col-span-5 --}}
                    </div> {{-- End Grid Utama --}}

                    <hr class="my-6 border-gray-200">
                    
                    {{-- Bagian 2: Deskripsi & Sampul --}}
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-6">
                        
                        <div class="md:col-span-9">
                            <div class="mb-4">
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="fas fa-pen-alt mr-1"></i> Sinopsis/Deskripsi Buku
                                </label>
                                <textarea name="deskripsi" id="deskripsi" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 
                                    @error('deskripsi') border-red-500 @enderror" 
                                    rows="5" placeholder="Masukkan sinopsis, ringkasan, atau deskripsi singkat buku.">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="md:col-span-3">
                            <div class="mb-4">
                                <label for="gambar_buku" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="fas fa-image mr-1"></i> Sampul Buku (Cover)
                                </label>
                                <input type="file" name="gambar_buku" id="gambar_buku" 
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 
                                    @error('gambar_buku') border-red-500 @enderror">
                                <p class="mt-2 text-sm text-gray-500">Format: JPG/PNG, Max: 2MB.</p>
                                @error('gambar_buku')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div> {{-- End Grid Deskripsi/Sampul --}}

                    <hr class="my-6 border-gray-200">

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('admin.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white {{ $backButtonClass }} focus:outline-none focus:ring-2 focus:ring-offset-2 transition duration-150 ease-in-out">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white {{ $saveButtonClass }} focus:outline-none focus:ring-2 focus:ring-offset-2 transition duration-150 ease-in-out">
                            <i class="fas fa-save mr-2"></i> Simpan Buku Baru
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
