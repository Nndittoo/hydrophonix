<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- [KARTU DIPERBARUI] Informasi User & Statistik (Tata Letak Baru) -->
            <div class="p-4 sm:p-8 shadow bg-gradient-to-br from-green-800 to-green-500 sm:rounded-lg text-white grid md:grid-cols-3 gap-6 grid-cols-1">

                <!-- Kolom Kiri: Identitas User (BARU) -->
                <div class="md:col-span-1 flex flex-col items-center justify-center text-center">
                    <img class="h-24 w-24 rounded-full object-cover ring-4 ring-white shadow-lg" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=D1FAE5&color=065F46&size=128" alt="{{ Auth::user()->name }}">
                    <h2 class="text-3xl font-bold text-white mt-4">{{ $user->name }}</h2>
                    <p class="text-sm text-green-200">{{ $user->email }}</p>
                </div>

                <!-- Kolom Kanan: Detail Statistik (Diperbarui) -->
                <div class="md:col-span-2 bg-green-600 p-5 rounded-md shadow-md">
                    <h2 class="text-lg font-medium text-white">
                        Progres Level & Gamifikasi
                    </h2>

                    <div class="mt-6 space-y-6">

                        <!-- [DIPERBARUI] Info Statistik (Grid 3x2) -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-6">
                            <!-- Level -->
                            <div class="flex items-center space-x-3">
                                <svg class="h-8 w-8 text-green-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                                </svg>
                                <div>
                                    <span class="text-sm font-medium text-green-200">Level Anda</span>
                                    <p class="text-2xl font-bold text-white">Level {{ $user->level }}</p>
                                </div>
                            </div>
                            <!-- Skor -->
                            <div class="flex items-center space-x-3">
                                <svg class="h-8 w-8 text-green-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                     <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.31h5.518a.563.563 0 0 1 .321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.563.563 0 0 1-.84.61l-4.725-3.882a.563.563 0 0 0-.652 0L5.602 19.7a.563.563 0 0 1-.84-.61l1.285-5.386a.563.563 0 0 0-.182-.557l-4.204-3.602a.563.563 0 0 1 .321-.988H7.88a.563.563 0 0 0 .475-.31L10.48 3.5Z" />
                                </svg>
                                <div>
                                    <span class="text-sm font-medium text-green-200">Total Poin</span>
                                    <p class="text-2xl font-bold text-white">{{ $user->total_score }} Poin</p>
                                </div>
                            </div>
                            <!-- [BARU] Peringkat Global -->
                            <div class="flex items-center space-x-3">
                                <svg class="h-8 w-8 text-green-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-6.75c-.621 0-1.125.504-1.125 1.125V18.75m9 0h-9" />
                                </svg>
                                <div>
                                    <span class="text-sm font-medium text-green-200">Peringkat</span>
                                    <p class="text-2xl font-bold text-white">#{{ $userRank }}</p>
                                </div>
                            </div>
                            <!-- Kuis Selesai -->
                            <div class="flex items-center space-x-3">
                                <svg class="h-8 w-8 text-green-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <div>
                                    <span class="text-sm font-medium text-green-200">Kuis Selesai</span>
                                    <p class="text-2xl font-bold text-white">{{ $user->quizzes_completed }}</p>
                                </div>
                            </div>
                            <!-- [BARU] Tanaman Selesai -->
                            <div class="flex items-center space-x-3">
                                <svg class="h-8 w-8 text-green-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 0 0-.491 6.347A48.627 48.627 0 0 1 12 20.904a48.627 48.627 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.905 59.905 0 0 1 12 3.493a59.902 59.902 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                                </svg>
                                <div>
                                    <span class="text-sm font-medium text-green-200">Tanaman Panen</span>
                                    <p class="text-2xl font-bold text-white">{{ $plantsCompletedCount }}</p>
                                </div>
                            </div>
                            <!-- Tanggal Bergabung -->
                            <div class="flex items-center space-x-3">
                                <svg class="h-8 w-8 text-green-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                                <div>
                                    <span class="text-sm font-medium text-green-200">Bergabung</span>
                                    <p class="text-xl font-bold text-white">{{ $user->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Progress Bar (Tidak Berubah) -->
                        <div class="pt-6">
                            @if($nextLevelScore)
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-white font-medium">Progres ke Level {{ $user->level + 1 }}</span>
                                    <span class="text-green-200 font-medium">{{ $user->total_score }} / {{ $nextLevelScore }} Poin</span>
                                </div>
                                <div class="w-full bg-green-800 bg-opacity-50 rounded-full h-2.5">
                                    <div class="bg-white h-2.5 rounded-full" style="width: {{ $progressPercent }}%"></div>
                                </div>
                            @else
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-yellow-300 font-bold">Level Maksimal Tercapai!</span>
                                </div>
                                <div class="w-full bg-green-800 bg-opacity-50 rounded-full h-2.5">
                                    <div class="bg-yellow-300 h-2.5 rounded-full" style="width: 100%"></div>
                                </div>
                            @endif
                        </div>

                        <!-- Peta Level (Tidak Berubah) -->
                        <div class="mt-6 pt-6 border-t border-green-700 border-opacity-50">
                            <h3 class="font-medium text-white">Peta Level (Skor Minimal)</h3>
                            <ul class="mt-2 space-y-1">
                                @foreach($levelMap as $level => $score)
                                <li class="flex justify-between text-sm {{ $user->level == $level ? 'text-yellow-300 font-bold' : 'text-green-100' }}">
                                    <span>Level {{ $level }}</span>
                                    <span>{{ $score }} Poin</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <!-- [KARTU PENGATURAN] dengan Toggle Alpine.js (Tidak Berubah) -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg" x-data="{ activeTab: '' }">
                <div class="">
                    <h2 class="text-lg font-medium text-gray-900">
                        Pengaturan Akun
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Ubah informasi profil atau password Anda.
                    </p>

                    <!-- Tombol Toggle -->
                    <div class="mt-6 flex space-x-4">
                        <button
                            @click="activeTab = (activeTab === 'profile' ? '' : 'profile')"
                            :class="activeTab === 'profile' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700'"
                            class="px-5 py-2 rounded-md font-medium text-sm transition-colors duration-200">
                            Ubah Informasi Profil
                        </button>
                        <button
                            @click="activeTab = (activeTab === 'password' ? '' : 'password')"
                            :class="activeTab === 'password' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700'"
                            class="px-5 py-2 rounded-md font-medium text-sm transition-colors duration-200">
                            Ubah Password
                        </button>
                    </div>

                    <!-- Konten Toggle 1: Update Informasi Profil -->
                    <div x-show="activeTab === 'profile'"
                         x-transition
                         style="display: none;"
                         class="mt-6 border-t pt-6">

                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-md font-medium text-gray-700">Formulir Informasi Profil</h3>
                            <button @click="activeTab = ''" class="text-sm text-gray-200 hover:text-white hover:bg-red-600 transition bg-red-500 py-2 px-4 rounded-sm">Tutup</button>
                        </div>
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <!-- Konten Toggle 2: Update Password -->
                    <div x-show="activeTab === 'password'"
                         x-transition
                         style="display: none;"
                         class="mt-6 border-t pt-6">

                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-md font-medium text-gray-700">Formulir Ubah Password</h3>
                            <button @click="activeTab = ''" class="text-sm text-gray-200 hover:text-white hover:bg-red-600 transition bg-red-500 py-2 px-4 rounded-sm">Tutup</button>
                        </div>
                        @include('profile.partials.update-password-form')
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
