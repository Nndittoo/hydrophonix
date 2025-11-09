<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- [DIUBAH] Kartu Heading / Selamat Datang (Lebih Eye-Catching) -->
            <div class="bg-green-600 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-white">
                    <div class="flex items-center space-x-4">
                        <svg class="h-12 w-12 text-green-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-1.5 5.231 5.231m0 0a.563.563 0 0 1 .53 0l2.121 2.121.53.53a.563.563 0 0 1 0 .792l-2.121 2.121a.563.563 0 0 1-.792 0l-2.121-2.121a.563.563 0 0 1 0-.792l.53-.53Z" />
                        </svg>
                        <div>
                            <h3 class="text-2xl font-semibold">
                                Selamat Datang, {{ Auth::user()->name }}!
                            </h3>
                            <p class="text-green-100 mt-1">
                                Ini adalah pusat kendali Anda. Mari kita tumbuhkan tanaman dan pengetahuan Anda hari ini.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tata Letak Grid Utama (Tetap 2 kolom) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Kolom Kiri (Lebar) -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Widget Tanaman Aktif -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h4 class="text-lg font-semibold mb-4">🌱 Tanaman Aktif Anda</h4>

                            @if ($activePlant)
                                <div class="space-y-4">
                                    <p class="text-4xl font-bold text-green-600">{{ $activePlant->plant->name }}</p>

                                    <!-- [DIUBAH] Misi saat ini di-highlight -->
                                    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                                        <span class="text-sm text-gray-500">Misi Saat Ini:</span>
                                        <p class="font-medium text-lg text-gray-800">{{ $activePlant->currentMission->title }}</p>
                                    </div>

                                    <div>
                                        <span class="text-sm text-gray-500">Umur Tanaman:</span>
                                        <p class="font-medium text-lg">{{ $activePlant->plant_age }} hari</p>
                                    </div>

                                    <div class="pt-2">
                                        <a href="{{ route('user-plants.index') }}" class="inline-flex items-center px-5 py-2 bg-green-600 text-white rounded-md text-sm font-semibold hover:bg-green-700 shadow-sm">
                                            <span>Lihat Misi</span>
                                            <svg class="w-4 h-4 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m12.75 15 3-3m0 0-3-3m3 3h-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="text-center p-4 border-2 border-dashed rounded-lg">
                                    <p class="text-gray-600 mb-3">Kebun Anda masih kosong. Siap memulai?</p>
                                    <a href="{{ route('plants.index') }}" class="inline-block px-5 py-2 bg-green-600 text-white rounded-md text-sm font-semibold hover:bg-green-700 shadow-sm">
                                        Mulai Tanam
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Widget Progres Level (Tetap) -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h4 class="text-lg font-semibold mb-4">📚 Progres Level Anda</h4>
                            <div class="flex items-center space-x-4">
                                <span class="flex items-center justify-center h-12 w-12 bg-green-100 text-green-700 font-bold rounded-full text-xl">
                                    {{ Auth::user()->level }}
                                </span>
                                <div class="w-full">
                                    @if($nextLevelScore)
                                        <div class="flex justify-between text-sm mb-1">
                                            <span class="text-gray-700 font-medium">Progres ke Level {{ Auth::user()->level + 1 }}</span>
                                            <span class="text-gray-500 font-medium">{{ Auth::user()->total_score }} / {{ $nextLevelScore }} Poin</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $progressPercent }}%"></div>
                                        </div>
                                    @else
                                        <div class="text-green-600 font-semibold">Level Maksimal Tercapai!</div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-green-600 h-2.5 rounded-full" style="width: 100%"></div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Widget Modul Dapat Diakses -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <!-- [PERUBAHAN] Judul diubah agar lebih akurat -->
                            <h4 class="text-lg font-semibold mb-4">📖 Modul yang Telah Terbuka</h4>
                            <div class="space-y-3">
                                @forelse ($accessibleModules as $module)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-md transition-all hover:bg-gray-100">
                                        <div class="flex items-center space-x-3">
                                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18c-2.305 0-4.408.867-6 2.292m0-14.25v14.25" /></svg>
                                            <span class="font-medium text-gray-700">{{ $module->title }}</span>
                                        </div>
                                        <a href="{{ route('modules.show', $module->slug) }}" class="inline-block px-4 py-1 bg-green-100 text-green-800 rounded-md text-sm font-medium hover:bg-green-200 transition-colors">
                                            Mulai Baca
                                        </a>
                                    </div>
                                @empty
                                    <div class="text-gray-500 text-sm p-3">
                                        Belum ada modul yang tersedia di sistem.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Widget Skor Kuis Terbaik -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h4 class="text-lg font-semibold mb-4">🎯 Skor Kuis Terbaik Anda</h4>
                            <div class="space-y-3">
                                @forelse ($completedQuizzes as $attempt)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-md">
                                        <div class="flex items-center space-x-3">
                                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                                            <div>
                                                <a href="{{ route('modules.show', $attempt->quiz->module->slug) }}" class="font-medium text-green-600 hover:text-green-800 hover:underline">
                                                    {{ $attempt->quiz->title }}
                                                </a>
                                                <span class="block text-xs text-gray-500">(dari Modul: {{ $attempt->quiz->module->title }})</span>
                                            </div>
                                        </div>
                                        @if($attempt->best_score == 100)
                                            <!-- [DIUBAH] Warna Bintang Emas/Kuning -->
                                            <span class="px-3 py-1 text-sm font-bold text-yellow-800 bg-yellow-300 rounded-full">
                                                {{ $attempt->best_score }} ⭐
                                            </span>
                                        @else
                                            <!-- [DIUBAH] Warna Hijau Konsisten -->
                                            <span class="px-3 py-1 text-sm font-medium text-green-800 bg-green-100 rounded-full">
                                                {{ $attempt->best_score }}
                                            </span>
                                        @endif
                                    </div>
                                @empty
                                    <div class="text-gray-500 text-sm p-3">
                                        Anda belum menyelesaikan kuis apapun. Ayo mulai belajar!
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Kolom Kanan (Sidebar) -->
                <div class="lg:col-span-1 space-y-6">

                    <!-- [DIUBAH] Widget Statistik (dengan Ikon) -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h4 class="text-lg font-semibold mb-5">🏆 Statistik Anda</h4>
                            <ul class="space-y-5">
                                <li class="flex items-center space-x-3">
                                    <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-6.75c-.621 0-1.125.504-1.125 1.125V18.75m9 0h-9" /></svg>
                                    <span class="text-gray-600">Peringkat Global</span>
                                    <span class="font-bold text-lg text-green-600 ml-auto">#{{ $userRank }}</span>
                                </li>
                                <li class="flex items-center space-x-3">
                                    <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.31h5.518a.563.563 0 0 1 .321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.563.563 0 0 1-.84.61l-4.725-3.882a.563.563 0 0 0-.652 0L5.602 19.7a.563.563 0 0 1-.84-.61l1.285-5.386a.563.563 0 0 0-.182-.557l-4.204-3.602a.563.563 0 0 1 .321-.988H7.88a.563.563 0 0 0 .475-.31L10.48 3.5Z" /></svg>
                                    <span class="text-gray-600">Total Skor</span>
                                    <span class="font-bold text-lg text-gray-900 ml-auto">{{ Auth::user()->total_score }}</span>
                                </li>
                                <li class="flex items-center space-x-3">
                                    <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                                    <span class="text-gray-600">Kuis Selesai</span>
                                    <span class="font-bold text-lg text-gray-900 ml-auto">{{ $quizCompletedCount }}</span>
                                </li>
                                <li class="flex items-center space-x-3">
                                    <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18c-2.305 0-4.408.867-6 2.292m0-14.25v14.25" /></svg>
                                    <span class="text-gray-600">Modul Tersedia</span>
                                    <span class="font-bold text-lg text-gray-900 ml-auto">{{ $moduleCount }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- [DIUBAH] Widget Aksi Cepat (lebih interaktif) -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h4 class="text-lg font-semibold mb-4">⚡ Aksi Cepat</h4>
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('calendar.index') }}" class="flex items-center justify-between p-3 rounded-md hover:bg-green-50 transition-colors">
                                        <span class="font-medium text-green-600">Lihat Kalender Tanam</span>
                                        <svg class="h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('modules.index') }}" class="flex items-center justify-between p-3 rounded-md hover:bg-green-50 transition-colors">
                                        <span class="font-medium text-green-600">Telusuri Semua Modul</span>
                                        <svg class="h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('leaderboard.index') }}" class="flex items-center justify-between p-3 rounded-md hover:bg-green-50 transition-colors">
                                        <span class="font-medium text-green-600">Lihat Papan Peringkat</span>
                                        <svg class="h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('profile.edit') }}" class="flex items-center justify-between p-3 rounded-md hover:bg-green-50 transition-colors">
                                        <span class="font-medium text-green-600">Edit Profil & Level</span>
                                        <svg class="h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
