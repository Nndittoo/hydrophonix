<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📚 {{ __('Modul Pembelajaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- [BARU] Kartu Hero Sesuai Tema -->
            <div class="bg-green-600 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-white flex items-center space-x-4">
                    <!-- Ikon Buku -->
                    <svg class="h-12 w-12 text-green-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18c-2.305 0-4.408.867-6 2.292m0-14.25v14.25" />
                    </svg>
                    <div>
                        <h3 class="text-2xl font-semibold">Katalog Modul</h3>
                        <p class="text-green-100 mt-1">
                            Level Anda saat ini: <span class="font-bold">Level {{ Auth::user()->level }}</span>. Terus belajar untuk membuka modul baru!
                        </p>
                    </div>
                </div>
            </div>

            <!-- Notifikasi Error (jika mencoba membuka modul terkunci) -->
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
             <!-- Notifikasi Info (jika sudah skor 100) -->
            @if (session('info'))
                <div class="mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('info') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @php
                        $userLevel = Auth::user()->level;
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @forelse ($modules as $module)
                            @if ($userLevel >= $module->level_required)
                                <!-- 1. TAMPILAN MODUL TERBUKA (Eye-Catching) -->
                                <div class="bg-white border border-gray-200 rounded-lg shadow-sm flex flex-col justify-between transition-all hover:shadow-md">
                                    <div class="p-5">
                                        <div class="flex items-center justify-between mb-2">
                                            <!-- Tag Level Hijau -->
                                            <span class="text-xs font-semibold bg-green-100 text-green-800 px-3 py-1 rounded-full">
                                                Perlu Lv. {{ $module->level_required }}
                                            </span>
                                            <!-- Ikon Centang -->
                                            <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                        </div>
                                        <h4 class="font-bold text-lg text-gray-900">{{ $module->title }}</h4>
                                        <!-- Pratinjau Konten (Bersih) -->
                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ Str::limit(strip_tags($module->content), 100) }}
                                        </p>
                                    </div>
                                    <div class="px-5 pb-5">
                                        <!-- Tombol Hijau Sesuai Tema -->
                                        <a href="{{ route('modules.show', $module->slug) }}" class="inline-block w-full text-center px-4 py-2 bg-green-600 text-white rounded-md text-sm font-semibold hover:bg-green-700 shadow-sm">
                                            Mulai Baca
                                        </a>
                                    </div>
                                </div>
                            @else
                                <!-- 2. TAMPILAN MODUL TERKUNCI (Eye-Catching) -->
                                <div class="bg-gray-100 border border-gray-200 rounded-lg shadow-sm flex flex-col justify-between opacity-80">
                                    <div class="p-5">
                                        <div class="flex items-center justify-between mb-2">
                                            <!-- Tag Level Abu-abu -->
                                            <span class="text-xs font-semibold bg-gray-200 text-gray-700 px-3 py-1 rounded-full">
                                                Perlu Lv. {{ $module->level_required }}
                                            </span>
                                            <!-- Ikon Gembok -->
                                            <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 0 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                            </svg>
                                        </div>
                                        <h4 class="font-bold text-lg text-gray-500">{{ $module->title }}</h4>
                                        <!-- Deskripsi Terkunci -->
                                        <p class="text-sm text-gray-500 mt-1">
                                            Selesaikan kuis lain untuk mencapai level {{ $module->level_required }} dan membuka modul ini.
                                        </p>
                                    </div>
                                    <div class="px-5 pb-5">
                                        <!-- Tombol Terkunci -->
                                        <span class="inline-block w-full text-center px-4 py-2 bg-gray-300 text-gray-500 rounded-md text-sm font-medium cursor-not-allowed">
                                            🔒 Terkunci
                                        </span>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <p class="text-gray-500">Belum ada modul yang tersedia.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
