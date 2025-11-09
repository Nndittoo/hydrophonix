<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🌱 {{ __('Misi Tanaman Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Notifikasi Error/Success (Penting untuk tombol Selesai) -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if ($activePlant)
                <!-- [KARTU HERO] Menampilkan tanaman aktif -->
                <div class="bg-green-600 overflow-hidden shadow-sm sm:rounded-lg mb-6 text-white">
                    <div class="p-6 md:flex md:items-center md:space-x-6">
                        <img src="{{ asset('storage/' . $activePlant->plant->image_url) }}" alt="{{ $activePlant->plant->name }}" class="w-full md:w-48 h-48 object-cover rounded-lg shadow-md flex-shrink-0">
                        <div class="mt-4 md:mt-0">
                            <h3 class="text-sm uppercase text-green-200">Sedang Ditanam</h3>
                            <h2 class="text-4xl font-bold">{{ $activePlant->plant->name }}</h2>

                            <!-- [STATISTIK] Tiga kolom statistik -->
                            <div class="grid grid-cols-3 gap-4 mt-4 bg-green-700 bg-opacity-50 p-4 rounded-lg">
                                <div>
                                    <span class="text-xs text-green-200">UMUR TANAMAN</span>
                                    <p class="text-2xl font-bold">{{ $activePlant->plant_age }} <span class="text-lg">hari</span></p>
                                </div>
                                <div>
                                    <span class="text-xs text-green-200">TAHAP MISI</span>
                                    <p class="text-2xl font-bold">{{ $activePlant->currentMission->step_number }} <span class="text-lg">/ {{ $activePlant->plant->missions->count() }}</span></p>
                                </div>
                                <div>
                                    <span class="text-xs text-green-200">MISI DIMULAI</span>
                                    <p class="text-xl font-bold">{{ $activePlant->mission_started_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            <a href="{{ route('calendar.index') }}" class="inline-block mt-4 px-6 py-2 bg-white text-green-700 rounded-md text-sm font-semibold hover:bg-green-50 shadow">
                                Lihat Kalender
                            </a>
                        </div>
                    </div>
                </div>

                <!-- [ROADMAP MISI] -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-xl font-semibold mb-4">Roadmap Misi</h3>
                        <div class="space-y-4">

                            @php
                                $currentStep = $activePlant->currentMission->step_number;
                            @endphp

                            @foreach ($activePlant->plant->missions->sortBy('step_number') as $mission)

                                @if($mission->step_number == $currentStep)
                                    <!-- 1. MISI AKTIF -->
                                    <div class="border-2 border-green-500 bg-white rounded-lg shadow-lg p-5">
                                        <div class="flex items-center justify-between">
                                            <h4 class="text-lg font-bold text-green-600">
                                                <span class="text-gray-400 font-medium">Tahap {{ $mission->step_number }}:</span>
                                                {{ $mission->title }}
                                            </h4>
                                            <span class="px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">
                                                SEDANG BERJALAN
                                            </span>
                                        </div>
                                        <p class="text-gray-600 mt-2 mb-4">{{ $mission->description }}</p>

                                        <hr class="my-4">

                                        <!-- [PERBAIKAN] Logika Tombol Selesai Misi dengan floor() -->
                                        @php
                                            // Hitung sisa detik secara presisi
                                            $exactSecondsRemaining = $activePlant->mission_started_at->addDays($mission->duration_days)->timestamp - now()->timestamp;

                                            // Ubah ke hari dalam bentuk pecahan (float)
                                            $daysRemainingFloat = $exactSecondsRemaining / 86400; // (60*60*24)

                                            // Bulatkan ke bawah (floor) sesuai permintaan Anda
                                            $daysRemaining = floor($daysRemainingFloat);

                                            // Pengecekan kesiapan tetap menggunakan float agar akurat
                                            $isReady = $daysRemainingFloat <= 0;
                                        @endphp

                                        <form action="{{ route('user-plants.complete') }}" method="POST">
                                            @csrf
                                            <div class="flex items-center justify-between">
                                                @if ($isReady)
                                                    <p class="text-green-600 font-semibold">
                                                        🎉 Misi siap diselesaikan!
                                                    </p>
                                                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md font-semibold hover:bg-green-700 shadow-sm">
                                                        Selesaikan Misi & Lanjut
                                                    </button>
                                                @else
                                                    <p class="text-yellow-600 font-semibold">
                                                        <!-- Menampilkan sisa hari yang sudah dibulatkan ke bawah -->
                                                        Harap tunggu {{ $daysRemaining }} hari lagi.
                                                    </p>
                                                    <button type="submit" class="px-6 py-2 bg-gray-400 text-white rounded-md cursor-not-allowed" disabled>
                                                        Selesaikan Misi
                                                    </button>
                                                @endif
                                            </div>
                                        </form>
                                    </div>

                                @elseif($mission->step_number < $currentStep)
                                    <!-- 2. MISI SELESAI -->
                                    <div class="bg-gray-50 rounded-lg p-4 opacity-70">
                                        <div class="flex items-center justify-between">
                                            <h4 class="text-base font-medium text-gray-500 line-through">
                                                <span class="text-gray-400">Tahap {{ $mission->step_number }}:</span>
                                                {{ $mission->title }}
                                            </h4>
                                            <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                        </div>
                                    </div>

                                @else
                                    <!-- 3. MISI MENDATANG (TERKUNCI) -->
                                    <div class="bg-gray-50 rounded-lg p-4 opacity-70">
                                        <div class="flex items-center justify-between">
                                            <h4 class="text-base font-medium text-gray-500">
                                                <span class="text-gray-400">Tahap {{ $mission->step_number }}:</span>
                                                {{ $mission->title }}
                                            </h4>
                                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 0 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                            </svg>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                    </div>
                </div>

            @else
                <!-- Tampilan jika tidak ada tanaman aktif -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 text-center">
                        <svg class="h-16 w-16 text-gray-300 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <h3 class="text-xl font-semibold mt-4">Anda belum memiliki tanaman aktif.</h3>
                        <p class="text-gray-500 mt-2 mb-4">Mulai perjalanan hidroponik Anda sekarang!</p>
                        <a href="{{ route('plants.index') }}" class="inline-block px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 font-semibold shadow-sm">
                            Pilih Tanaman
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
