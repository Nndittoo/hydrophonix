<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <!-- Menambahkan font-weight 700 (bold) untuk judul -->
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Menghapus referensi dark mode -->
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:flex-row">

            <!-- [PERUBAHAN] Kolom Kiri (Hijau) - Terlihat di MD ke atas -->
            <div class="hidden md:flex md:w-1/2 bg-green-700 text-white p-12 flex-col justify-center relative overflow-hidden">

                <!-- Dekorasi Atas Kanan -->
                <div class="absolute -top-24 -right-24 w-72 h-72 bg-green-800 rounded-full opacity-50"></div>

                <h1 class="text-5xl font-bold mb-3 z-10">Hydroponix</h1>
                <p class="text-xl font-light z-10">Tempat Belajar Bertanam Modern untuk Generasi Hijau</p>

                <!-- Dekorasi Bawah Kiri -->
                <div class="absolute -bottom-16 -left-10 w-32 h-32 bg-white rounded-full opacity-10"></div>
                <div class="absolute -bottom-5 left-20 w-8 h-8 bg-white rounded-full opacity-15"></div>
                <div class="absolute bottom-5 left-32 w-4 h-4 bg-white rounded-full opacity-20"></div>
            </div>

            <!-- [PERUBAHAN] Kolom Kanan (Form) -->
            <div class="w-full md:w-1/2 bg-white p-6 sm:p-12 flex flex-col justify-center items-center min-h-screen md:min-h-0">
                <div class="w-full max-w-sm">
                    <!-- Logo di Kanan -->
                    <div class="flex justify-center mb-4">
                        <a href="/">
                            <!-- Pastikan logo Anda ada di public/img/logo.svg -->
                            <img src="{{ asset('img/logo.svg') }}" class="w-20 h-20" alt="Logo Hydroponix">
                        </a>
                    </div>
                    <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">
                        Hydroponix
                    </h2>

                    <!-- Slot ini akan berisi form dari login.blade.php -->
                    <div>
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
