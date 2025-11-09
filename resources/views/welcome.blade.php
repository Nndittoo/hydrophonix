<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Hidrophonix - Tanam Mudah & Menyenangkan</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>

    <!-- [PERUBAHAN] Padding diubah agar lebih mobile-friendly -->
    <body class="bg-gray-50 text-gray-900 flex p-4 sm:p-6 lg:p-8 items-center min-h-screen flex-col font-sans antialiased">

        <!-- [PERUBAHAN] max-w-[335px] diganti menjadi w-full -->
        <header class="w-full lg:max-w-5xl text-sm mb-6">
            @if (Route::has('login'))
                <nav class="flex items-center justify-between">
                    <!-- Logo di Kiri Atas -->
                    <a href="/" class="flex items-center gap-2">
                        <img src="{{ asset("img/logo.svg") }}" class="h-8 w-auto" alt="Hidrophonix Logo"/>
                        <span class="font-bold text-lg text-gray-800">Hidrophonix</span>
                    </a>

                    <!-- Tombol Login/Register -->
                    <div class="flex gap-4">
                        @auth
                            <a
                                href="{{ url('/dashboard') }}"
                                class="inline-block px-5 py-1.5 border border-gray-300 hover:border-gray-400 text-gray-800 rounded-md text-sm leading-normal font-medium"
                            >
                                Dashboard
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="inline-block px-5 py-1.5 text-gray-700 hover:text-gray-900 rounded-md text-sm leading-normal font-medium"
                            >
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="inline-block px-5 py-1.5 border border-transparent bg-green-600 hover:bg-green-700 text-white rounded-md text-sm leading-normal font-medium">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </div>
                </nav>
            @endif
        </header>

        <!-- [PERUBAHAN] max-w-[335px] diganti menjadi w-full -->
        <main class="w-full lg:max-w-5xl space-y-16 lg:space-y-24">

            <!-- Hero Section -->
            <div class="text-center pt-10 lg:pt-20">
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900">
                    Selamat Datang di Hidrophonix
                </h1>
                <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                    Cara modern, mudah, dan menyenangkan untuk bercocok tanam hidroponik langsung dari rumah Anda.
                </p>
                <div class="mt-8">
                    <a href="{{ route('register') }}" class="inline-block px-8 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 transition duration-300">
                        Mulai Petualangan Anda
                    </a>
                </div>
            </div>

            <!-- Bagian "Apa Itu Hidroponik?" -->
            <div class="py-16 lg:py-20 bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 lg:px-12">
                    <h2 class="text-3xl font-bold text-center text-gray-900">Apa Itu Hidroponik?</h2>
                    <p class="mt-4 max-w-3xl mx-auto text-center text-gray-600">
                        Hidroponik adalah metode bercocok tanam tanpa menggunakan tanah. Semua nutrisi yang dibutuhkan tanaman diberikan melalui larutan air, sehingga lebih bersih, hemat tempat, dan memungkinkan Anda panen sayuran segar berkualitas tinggi kapan saja.
                    </p>
                </div>
            </div>

            <!-- Bagian Pratinjau Tanaman -->
            <div class="py-16 lg:py-20">
                <h2 class="text-3xl font-bold text-center text-gray-900">Pilih Tanaman Pertama Anda</h2>
                <p class="mt-4 text-center text-gray-600">Mulai misi menanam bayam, kangkung, dan lainnya.</p>
                <!-- Grid ini sudah responsif -->
                <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($plants as $plant)
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 text-center flex flex-col">
                            <img src="{{ asset('storage/' . $plant->image_url) }}" class="h-40 w-full object-cover rounded-md mb-4" alt="{{ $plant->name }}">
                            <h3 class="text-xl font-semibold text-gray-900">{{ $plant->name }}</h3>
                            <p class="text-gray-600 text-sm mt-2 flex-grow">{{ Str::limit($plant->description, 50) }}</p>
                            <a href="{{ route('login') }}" class="inline-block mt-5 px-4 py-2 bg-green-100 text-green-800 rounded-md text-sm font-medium hover:bg-green-200">
                                Lihat Detail
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Bagian Fitur (Apa yang Anda Dapatkan?) -->
            <div class="py-16 lg:py-20">
                <h2 class="text-3xl font-bold text-center text-gray-900">Apa yang Anda Dapatkan?</h2>
                <!-- Grid ini sudah responsif -->
                <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">

                    <!-- Fitur 1: Monitoring -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center">
                        <svg class="h-12 w-12 text-green-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h.01M15 12h.01M10.5 16.5h3m-6.364 3.545-.955-.955a2.25 2.25 0 0 1 0-3.182l2.121-2.121a2.25 2.25 0 0 1 3.182 0l.955.955a2.25 2.25 0 0 1 0 3.182l-2.121 2.121a2.25 2.25 0 0 1-3.182 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-4.5-4.5H9.75M15.75 12H18m-4.5 4.5h.01M12.75 18v-2.25" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 19.5h-6a2.25 2.25 0 0 1-2.25-2.25V6.75A2.25 2.25 0 0 1 7.5 4.5h6a2.25 2.25 0 0 1 2.25 2.25v6.75a2.25 2.25 0 0 1-2.25 2.25Z" />
                        </svg>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">Panduan Misi Tanam</h3>
                        <p class="mt-2 text-gray-600">
                            Sistem kami memandu Anda langkah demi langkah, dari semai hingga panen, dengan jadwal yang jelas di kalender Anda.
                        </p>
                    </div>

                    <!-- Fitur 2: Modul & Kuis -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center">
                        <svg class="h-12 w-12 text-green-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18c-2.305 0-4.408.867-6 2.292m0-14.25v14.25" />
                        </svg>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">Modul & Kuis Interaktif</h3>
                        <p class="mt-2 text-gray-600">
                            Perdalam pengetahuan Anda. Pelajari modul, ikuti kuis, dan pahami cara merawat tanaman Anda seperti seorang profesional.
                        </p>
                    </div>

                    <!-- Fitur 3: Gamifikasi -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center">
                        <svg class="h-12 w-12 text-green-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-6.75c-.621 0-1.125.504-1.125 1.125V18.75m9 0h-9" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 6.375a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm10.5 0a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-3.375 0a1.125 1.125 0 0 1-2.25 0c0-.621.504-1.125 1.125-1.125s1.125.504 1.125 1.125Z" />
                        </svg>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">Level & Papan Peringkat</h3>
                        <p class="mt-2 text-gray-600">
                            Selesaikan kuis untuk mendapatkan skor, naik level, dan buka modul baru. Bersainglah dan jadilah master Hidrophonix!
                        </p>
                    </div>
                </div>
            </div>

            <!-- Bagian Pratinjau Modul -->
            <div class="py-16 lg:py-20 bg-white rounded-lg shadow-sm border border-gray-200">
                <h2 class="text-3xl font-bold text-center text-gray-900">Perdalam Pengetahuan Anda</h2>
                <p class="mt-4 text-center text-gray-600">Modul kami dirancang untuk membawa Anda dari pemula hingga ahli.</p>
                <!-- Grid ini sudah responsif -->
                <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto px-6 lg:px-0">
                    @foreach($modules as $module)
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 flex flex-col">
                            <span class="text-sm font-semibold {{ $module->level_required > 1 ? 'text-yellow-700' : 'text-green-700' }}">
                                {{ $module->level_required > 1 ? '🔒 Perlu Lv. ' . $module->level_required : 'Modul Level 1' }}
                            </span>
                            <h3 class="mt-2 text-xl font-semibold text-gray-900">{{ $module->title }}</h3>
                            <p class="text-gray-600 text-sm mt-2 flex-grow">{{ Str::limit(strip_tags($module->content), 100) }}</p>
                            <a href="{{ route('login') }}" class="inline-block mt-5 px-4 py-2 bg-green-600 text-white rounded-md text-sm font-medium hover:bg-green-700 text-center">
                                Mulai Baca
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Bagian "Tujuan Kami" -->
            <div class="py-16 lg:py-20 text-center">
                <h2 class="text-3xl font-bold text-gray-900">Tujuan Kami</h2>
                <p class="mt-4 max-w-3xl mx-auto text-gray-600">
                    Kami percaya semua orang bisa menanam. Hidrophonix dibuat untuk mendemistifikasi hidroponik, membuatnya dapat diakses oleh siapa saja, dan mengubah proses berkebun Anda menjadi sebuah permainan yang seru dan bermanfaat.
                </p>
            </div>

        </main>

        <!-- [PERUBAHAN] max-w-[335px] diganti menjadi w-full -->
        <footer class="w-full lg:max-w-5xl text-center py-6 mt-10 border-t border-gray-200">
            <p class="text-sm text-gray-500">
                &copy; {{ date('Y') }} Hidrophonix. Dibuat dengan Laravel.
            </p>
        </footer>

    </body>
</html>
