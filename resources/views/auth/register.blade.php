<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-50 to-emerald-100 py-12">
        <div class="bg-white shadow-lg rounded-2xl w-full max-w-md p-8 border border-green-100">
            <div class="flex flex-col items-center mb-6">
                <div class="bg-green-100 p-3 rounded-full">
                    📚
                </div>
                <h2 class="mt-3 text-2xl font-bold text-green-700 text-center">
                    Daftar Akun Perpustakaan
                </h2>
                <p class="text-sm text-gray-500 text-center mt-1">
                    Silakan isi data di bawah untuk membuat akun
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                    <div class="flex items-center border rounded-lg mt-1 px-3">
                        <span class="text-green-500 mr-2">👤</span>
                        <input id="name" class="w-full py-2 focus:outline-none" type="text" name="name" :value="old('name')" required autofocus>
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Role -->
                <div class="mb-4">
                    <label for="role" class="block text-sm font-semibold text-gray-700">Daftar Sebagai</label>
                    <div class="flex items-center border rounded-lg mt-1 px-3">
                        <span class="text-green-500 mr-2">🧑‍💻</span>
                        <select id="role" name="role" class="w-full py-2 bg-transparent focus:outline-none" required>
                            <option value="">Pilih peran...</option>
                            <option value="Siswa">Siswa</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
                    <div class="flex items-center border rounded-lg mt-1 px-3">
                        <span class="text-green-500 mr-2">✉️</span>
                        <input id="email" class="w-full py-2 focus:outline-none" type="email" name="email" :value="old('email')" required>
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-semibold text-gray-700">Kata Sandi</label>
                    <div class="flex items-center border rounded-lg mt-1 px-3">
                        <span class="text-green-500 mr-2">🔒</span>
                        <input id="password" class="w-full py-2 focus:outline-none" type="password" name="password" required>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Konfirmasi Kata Sandi</label>
                    <div class="flex items-center border rounded-lg mt-1 px-3">
                        <span class="text-green-500 mr-2">✅</span>
                        <input id="password_confirmation" class="w-full py-2 focus:outline-none" type="password" name="password_confirmation" required>
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-green-600 transition">Sudah punya akun?</a>
                    <button type="submit" class="bg-black hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition-all duration-200">
                        Daftar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
