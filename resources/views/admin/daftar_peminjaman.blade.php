<x-app-layout>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full text-sm text-left text-gray-600">
            <thead class="bg-emerald-500 text-white uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Nama Peminjam</th>
                    <th class="px-6 py-3">Judul Buku</th>
                    <th class="px-6 py-3">Tanggal Pinjam</th>
                    <th class="px-6 py-3">Tanggal Kembali</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjaman as $item)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3">{{ $loop->iteration }}</td>
                        <td class="px-6 py-3">{{ $item->peminjam->name ?? '-' }}</td>
                        <td class="px-6 py-3">{{ $item->book->nama_buku ?? '-' }}</td>
                        <td class="px-6 py-3">
                            {{ $item->tanggal_pinjam ? $item->tanggal_pinjam->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-3">
                            {{ $item->tanggal_kembali_aktual ? $item->tanggal_kembali_aktual->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-3">
                            @switch($item->status)
                                @case('Diajukan')
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">Diajukan</span>
                                    @break
                                @case('Dipinjam')
                                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">Dipinjam</span>
                                    @break
                                @case('Dikembalikan')
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Dikembalikan</span>
                                    @break
                                @case('Ditolak')
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Ditolak</span>
                                    @break
                                @default
                                    <span class="text-gray-500">-</span>
                            @endswitch
                        </td>
                        <td class="px-6 py-3 text-center">
                            @if ($item->status === 'Diajukan')
                                <form action="{{ route('admin.peminjaman.setuju', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs">
                                        Setujui
                                    </button>
                                </form>
                            @elseif ($item->status === 'Dipinjam')
                                <form action="{{ route('admin.peminjaman.kembali', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs">
                                        Kembalikan
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 text-xs italic">Tidak ada aksi</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada data peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</x-app-layout>