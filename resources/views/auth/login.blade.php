<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <!-- [DIUBAH] Label sesuai screenshot -->
            <x-input-label for="email" value="Email / Username" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="contoh@gmail.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <!-- [DIUBAH] Label (memperbaiki typo 'Passworrd') -->
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- [DIUBAH] Tombol Masuk -->
        <div class="mt-6">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Masuk
            </button>
            <a href="{{ route("welcome") }}" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-green-600 hover:bg-[#aeaeae] transition ease-out hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 mt-2"> Halaman Awal </a>
        </div>

        <!-- [BARU] Link Daftar -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-medium text-green-700 hover:text-green-900 underline">
                    Daftar
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
