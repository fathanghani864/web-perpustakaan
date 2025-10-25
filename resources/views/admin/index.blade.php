<x-app-layout>


    

    <div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8">
        
        {{-- Pesan Status (Success/Error) --}}
        @if (session('success'))
            {{-- Menggunakan warna hijau cerah sesuai desain --}}
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
        
        {{-- Card Utama --}}
        <div class="bg-white shadow-xl sm:rounded-xl overflow-hidden border border-gray-100">
            
            {{-- HEADER CARD SESUAI DESAIN: Biru Gelap --}}
            <div class="p-4 bg-gray-800 text-white font-extrabold flex justify-between items-center rounded-t-xl">
                <h1 class="text-xl font-bold">Tabel Data Buku (CRUD)</h1>
                
                {{-- TOMBOL TAMBAH SESUAI DESAIN: Oranye/Kuning --}}
               <a href="{{ route('admin.tambah_buku') }}" 
   class="inline-flex items-center px-4 py-2 bg-amber-500 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-600 active:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
    Tambah Buku Baru
</a>

            </div>

            {{-- Tabel Data --}}
            <div class="p-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cover</th>
                            {{-- Mengubah nama kolom --}}
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul / Nama Buku</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tahun Terbit</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($books as $b)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}</td>
                                
                                {{-- Kolom Gambar Cover (PERBAIKAN DIMULAI DI SINI) --}}
                               <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">
                                    <img 
                                        src="{{ $b->gambar_buku 
                                            ? asset('storage/' . $b->gambar_buku) 
                                            : 'https://placehold.co/50x75/009688/white?text=COVER' }}"
                                        alt="{{ $b->nama_buku ?? 'Cover Buku' }}" 
                                        class="w-10 h-[60px] object-cover rounded-md shadow-md"
                                        onerror="this.onerror=null;this.src='https://placehold.co/50x75/009688/white?text=COVER';"
                                    >
                                </td>
                                {{-- PERBAIKAN SELESAI --}}

                                <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $b->nama_buku }}</td>
                                
                                {{-- Badge Kategori --}}
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $b->kategori }}
                                    </span>
                                </td>
                                
                                {{-- Badge Stok --}}
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-center">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full 
                                        {{ $b->jumlah > 10 ? 'bg-green-100 text-green-800' : ($b->jumlah > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ $b->jumlah }}
                                    </span>
                                </td>
                                
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-500">{{ $b->tahun_terbit ?? '-' }}</td>
                                
                                {{-- Kolom Aksi --}}
                                <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-center">
                                    <div class="flex justify-center space-x-2">
                                        {{-- Tombol Edit (Warna Biru Solid) --}}
                                        <a href="{{ route('admin.books.edit', $b->id) }}" class="px-4 py-2 text-xs font-semibold rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition duration-150 shadow-md" title="Edit">
                                            Edit
                                        </a>

                                        {{-- Tombol Hapus (Warna Merah Solid) --}}
                                        <form action="{{ route('admin.books.destroy', $b->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku {{ $b->nama_buku }}?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-4 py-2 text-xs font-semibold rounded-lg bg-red-600 text-white hover:bg-red-700 transition duration-150 shadow-md" title="Hapus">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-base text-gray-500 bg-gray-50">
                                    Ups! Belum ada data buku yang tersedia.
                                    <p class="mt-2 text-sm">Saat ini, koleksi buku di perpustakaan masih kosong. Silakan tambahkan buku baru untuk memulai koleksi Anda.</p>
                                    <a href="{{ route('admin.index') }}" class="mt-4 inline-block text-indigo-600 font-semibold hover:text-indigo-800 transition duration-150">
                                        <i class="fas fa-plus mr-1"></i> Tambah Buku Pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
</x-app-layout>
