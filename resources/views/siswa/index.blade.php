<x-app-layout>
    {{-- Halaman Dashboard Siswa Sederhana: Hanya Katalog --}}
    <div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8">
        
        {{-- Pesan Status (Success/Error) --}}
        @if (session('success'))
            <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg relative mb-4 shadow-sm" role="alert">
                <strong class="font-bold mr-1">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4 shadow-sm" role="alert">
                <strong class="font-bold mr-1">Gagal!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        
        {{-- Card Ringkasan Dihapus karena membutuhkan variabel $borrowings --}}
        
        
        {{-- ------------------------------------------------------------- --}}
        {{-- BAGIAN 1: KATALOG BUKU PERPUSTAKAAN (Tabel Katalog) --}}
        {{-- ------------------------------------------------------------- --}}

        <div id="katalog" class="bg-white shadow-xl sm:rounded-xl overflow-hidden border border-gray-100">
            <div class="p-4 bg-indigo-800 text-white font-extrabold rounded-t-xl shadow-lg">
                <h3 class="text-xl font-bold flex items-center">
                    <i class="fas fa-book-open mr-2"></i> Katalog Buku Perpustakaan
                </h3>
            </div>
            <div class="p-4 overflow-x-auto">
                @if ($books->isEmpty())
                    <p class="text-center text-gray-500 py-8">
                        Ups! Belum ada data buku yang tersedia dengan stok yang cukup.
                    </p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">COVER</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">JUDUL BUKU</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">KATEGORI</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">STOK</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- Menggunakan variabel books --}}
                            @foreach ($books as $index => $book)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{-- Tampilkan cover atau placeholder --}}
                                        <img src="{{ $book->gambar_buku 
                                            ? asset('storage/' . $book->gambar_buku) 
                                            : 'https://placehold.co/50x75/009688/white?text=COVER' }}" 
                                            alt="Cover Buku" class="w-12 h-18 object-cover rounded-md shadow-sm">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $book->nama_buku }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                            {{ $book->kategori }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-semibold 
                                        @if($book->jumlah > 10) text-green-600 
                                        @elseif($book->jumlah > 0) text-yellow-600
                                        @else text-red-600 
                                        @endif">
                                        {{ $book->jumlah }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        {{-- Logika Tombol Aksi: Hanya cek Stok, Pengecekan isBorrowed dihilangkan --}}
                                        @if($book->jumlah > 0)
                                            {{-- Tombol Pinjam (Hijau) --}}
                                            <form action="{{ route('pinjam.store') }}" method="POST" class="inline">
                                                @csrf
                                                {{-- Tambahkan book_id sebagai input hidden --}}
                                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                                <button type="submit" class="px-4 py-2 text-xs font-semibold rounded-lg bg-green-600 text-white hover:bg-green-700 transition shadow-md">
                                                    <i class="fas fa-arrow-circle-right mr-1"></i> Pinjam
                                                </button>
                                            </form>
                                        @else
                                            {{-- Stok Habis --}}
                                            <button disabled class="px-4 py-2 text-xs font-semibold rounded-lg bg-red-600 text-white opacity-70 cursor-not-allowed shadow-sm">
                                                <i class="fas fa-ban mr-1"></i> Stok Habis
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
