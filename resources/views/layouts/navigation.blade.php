<nav x-data="{ open: false }" class="bg-white shadow-lg border-b border-emerald-100 transition duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            {{-- LOGO --}}
            <div class="flex items-center">
                @php
                    $homeRoute = '/';
                    if (Auth::check()) {
                        $homeRoute = Auth::user()->role === 'admin'
                            ? route('admin.index')
                            : route('siswa.index');
                    }
                @endphp

                <a href="{{ $homeRoute }}" class="flex items-center space-x-2">
                    <i class="fas fa-book-reader text-emerald-600 text-2xl"></i>
                    <span class="font-bold text-xl text-gray-800">Perpustakaan Digital</span>
                </a>
            </div>


            {{-- MENU DESKTOP --}}
            <div class="hidden sm:flex sm:items-center sm:space-x-8">
                @auth
                    @if (Auth::check() && strtolower(Auth::user()->role) === 'admin')
                        <x-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.index')">
                            <i class="fas fa-chart-line mr-2 text-sm"></i> Dashboard
                        </x-nav-link>
                        <x-nav-link :href="route('admin.peminjaman.index')" :active="request()->routeIs('admin.peminjaman.*')">
                            <i class="fas fa-receipt mr-2 text-sm"></i> Kelola Peminjaman
                        </x-nav-link>


                    @elseif (Auth::user()->role === 'siswa')
                        <x-nav-link :href="route('siswa.index')" :active="request()->routeIs('siswa.index')">
                            <i class="fas fa-home mr-2 text-sm"></i> Dashboard
                        </x-nav-link>
                        <x-nav-link :href="route('siswa.books.index')" :active="request()->routeIs('siswa.books.index')">
                            <i class="fas fa-search mr-2 text-sm"></i> Daftar Buku
                        </x-nav-link>
                        <x-nav-link :href="route('siswa.history')" :active="request()->routeIs('siswa.history')">
                            <i class="fas fa-history mr-2 text-sm"></i> Riwayat Pinjaman
                        </x-nav-link>
                    @endif
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-emerald-700 font-semibold">Login</a>
                    <a href="{{ route('register') }}"
                        class="text-emerald-600 hover:text-emerald-700 font-semibold">Register</a>
                @endguest
            </div>

            {{-- PROFILE DROPDOWN --}}
            @auth
                <div class="hidden sm:flex sm:items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center p-2 border border-transparent text-sm font-semibold rounded-full text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none transition">
                                <span
                                    class="w-8 h-8 flex items-center justify-center rounded-full bg-emerald-700 text-white text-xs mr-2">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="ml-1 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" d="M5.293 7.293L10 12l4.707-4.707" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                <i class="fas fa-user-circle mr-2 text-gray-500"></i> Profile
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endauth

            {{-- MOBILE TOGGLE --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="p-2 rounded-md text-gray-500 hover:text-emerald-600 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- MENU MOBILE --}}
    <div x-show="open" class="sm:hidden border-t border-gray-200 bg-white">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @if (Auth::user()->role === 'admin')
                    <x-responsive-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.index')"><i
                            class="fas fa-chart-line mr-2"></i> Dashboard</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.books.index')" :active="request()->routeIs('admin.books.*')"><i
                            class="fas fa-book mr-2"></i> Kelola Buku</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.peminjaman.index')"
                        :active="request()->routeIs('admin.peminjaman.*')"><i class="fas fa-receipt mr-2"></i> Kelola
                        Pinjaman</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')"><i
                            class="fas fa-users-cog mr-2"></i> Kelola Pengguna</x-responsive-nav-link>
                @elseif (Auth::user()->role === 'siswa')
                    <x-responsive-nav-link :href="route('siswa.index')" :active="request()->routeIs('siswa.index')"><i
                            class="fas fa-home mr-2"></i> Dashboard</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('siswa.books.index')"
                        :active="request()->routeIs('siswa.books.index')"><i class="fas fa-search mr-2"></i> Daftar
                        Buku</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('siswa.history')" :active="request()->routeIs('siswa.history')"><i
                            class="fas fa-history mr-2"></i> Riwayat Pinjaman</x-responsive-nav-link>
                @endif
            @endauth

            @guest
                <x-responsive-nav-link :href="route('login')"><i class="fas fa-sign-in-alt mr-2"></i>
                    Login</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')"><i class="fas fa-user-plus mr-2"></i>
                    Register</x-responsive-nav-link>
            @endguest
        </div>

        {{-- PROFILE MOBILE --}}
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-bold text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        <i class="fas fa-user-circle mr-2 text-gray-500"></i> Profile
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link href="{{ route('logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>