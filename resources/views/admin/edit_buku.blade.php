<x-app-layout>
    <div class="bg-white shadow-xl sm:rounded-xl mb-8 border-l-4 border-blue-500 overflow-hidden">
        <div class="p-4 bg-gray-800 text-white font-extrabold text-lg">
            Update Informasi Buku
        </div>
        
        <div class="p-6">
            <form id="editBookForm" 
                action="{{ route('admin.books.update', $book->id) }}" 
                method="POST" 
                enctype="multipart/form-data">

                @csrf
                @method('PUT')

                {{-- NAMA BUKU & KATEGORI --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-4">
                    <div class="col-span-1 md:col-span-8">
                        <label for="nama_buku" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Buku <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                            id="nama_buku" 
                            name="nama_buku" 
                            value="{{ old('nama_buku', $book->nama_buku) }}" 
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150">
                        @error('nama_buku')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-1 md:col-span-4">
                        <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select id="kategori" name="kategori" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150">
                            <option value="">Pilih Kategori</option>
                            @foreach (['Fiksi', 'Non-Fiksi', 'Sains', 'Sejarah', 'Teknologi'] as $kategori)
                                <option value="{{ $kategori }}" 
                                    {{ old('kategori', $book->kategori) == $kategori ? 'selected' : '' }}>
                                    {{ $kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- JUMLAH DAN TAHUN TERBIT --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">
                            Jumlah/Stok Buku <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                            id="jumlah" 
                            name="jumlah" 
                            min="0" 
                            value="{{ old('jumlah', $book->jumlah) }}" 
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150">
                        @error('jumlah')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="tahun_terbit" class="block text-sm font-medium text-gray-700 mb-1">
                            Tahun Terbit
                        </label>
                        <input type="number" 
                            id="tahun_terbit" 
                            name="tahun_terbit" 
                            min="1900" 
                            value="{{ old('tahun_terbit', $book->tahun_terbit) }}" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150">
                        @error('tahun_terbit')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- GAMBAR BUKU --}}
                <div class="mb-4">
                    <label for="gambar_buku" class="block text-sm font-medium text-gray-700 mb-1">
                        Gambar Buku (Cover)
                    </label>

                    @if ($book->gambar_buku)
                        <div class="mb-3 flex items-center gap-4">
                            <img src="{{ asset('storage/' . $book->gambar_buku) }}" alt="Cover Buku" class="w-20 h-28 object-cover rounded-lg shadow">
                            <span class="text-sm text-gray-500">Gambar saat ini: <strong>{{ basename($book->gambar_buku) }}</strong></span>
                        </div>
                    @endif

                    <div class="flex items-stretch border border-gray-300 rounded-lg">
                        <input type="file" id="gambar_buku" name="gambar_buku" accept="image/*" class="hidden-file-input">
                        <label for="gambar_buku" class="bg-blue-500 text-white px-4 py-2 cursor-pointer rounded-l-lg hover:bg-blue-600 transition">Pilih File</label>
                        <span id="file-name-display" class="flex-grow px-3 py-2 text-gray-500 text-sm">
                            Pilih file baru (kosongkan jika tidak diubah)
                        </span>
                    </div>
                    @error('gambar_buku')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    <small class="block text-xs text-gray-500 mt-1">
                        Maksimal ukuran file: 2MB. Format: JPG, PNG.
                    </small>
                </div>

                {{-- DESKRIPSI --}}
                <div class="mb-6">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">
                        Deskripsi Buku
                    </label>
                    <textarea id="deskripsi" 
                        name="deskripsi" 
                        rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150">{{ old('deskripsi', $book->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <hr class="my-6 border-t border-gray-200">

                {{-- TOMBOL --}}
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.books.index') }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-lg font-semibold text-xs uppercase hover:bg-gray-600 transition">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                    <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg font-semibold text-xs uppercase hover:bg-blue-600 transition">
                        <i class="fas fa-sync-alt mr-2"></i> Update Buku
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // tampilkan nama file yang dipilih
        document.addEventListener('DOMContentLoaded', () => {
            const fileInput = document.getElementById('gambar_buku');
            const fileNameDisplay = document.getElementById('file-name-display');

            fileInput.addEventListener('change', e => {
                const fileName = e.target.files.length > 0 
                    ? e.target.files[0].name 
                    : 'Pilih file baru (kosongkan jika tidak diubah)';
                fileNameDisplay.textContent = fileName;
            });
        });
    </script>
</x-app-layout>
