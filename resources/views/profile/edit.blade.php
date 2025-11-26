<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- 1. KARTU STATISTIK UTAMA (Hijau) -->
            <div class="p-6 sm:p-10 shadow-xl bg-gradient-to-br from-green-700 to-green-500 sm:rounded-xl text-white grid md:grid-cols-3 gap-8 grid-cols-1 items-center">

                <!-- Kolom Kiri: Identitas User -->
                <div class="md:col-span-1 flex flex-col items-center justify-center text-center border-b md:border-b-0 md:border-r border-green-400 pb-6 md:pb-0 md:pr-6">
                    <div class="relative">
                        <img class="h-28 w-28 rounded-full object-cover ring-4 ring-white shadow-lg" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=D1FAE5&color=065F46&size=128" alt="{{ Auth::user()->name }}">
                        <span class="absolute bottom-0 right-0 bg-yellow-400 text-green-900 text-xs font-bold px-2 py-1 rounded-full border-2 border-white">
                            Lv. {{ $user->level }}
                        </span>
                    </div>
                    <h2 class="text-3xl font-bold text-white mt-4">{{ $user->name }}</h2>
                    <p class="text-sm text-green-100">{{ $user->email }}</p>
                    <div class="mt-4 flex items-center space-x-2 bg-green-800 bg-opacity-30 px-4 py-1 rounded-full">
                        <span class="text-yellow-300">★</span>
                        <span class="font-bold">{{ $user->total_score }} Poin</span>
                    </div>
                </div>

                <!-- Kolom Kanan: Detail Statistik -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-green-100 mb-4 uppercase tracking-wider">Statistik Performa</h3>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                        <div class="bg-white bg-opacity-10 rounded-lg p-3 text-center backdrop-blur-sm">
                            <span class="block text-2xl font-bold text-white">#{{ $userRank }}</span>
                            <span class="text-xs text-green-100">Peringkat</span>
                        </div>
                        <div class="bg-white bg-opacity-10 rounded-lg p-3 text-center backdrop-blur-sm">
                            <span class="block text-2xl font-bold text-white">{{ $user->quizzes_completed }}</span>
                            <span class="text-xs text-green-100">Kuis Selesai</span>
                        </div>
                        <div class="bg-white bg-opacity-10 rounded-lg p-3 text-center backdrop-blur-sm">
                            <span class="block text-2xl font-bold text-white">{{ $plantsCompletedCount }}</span>
                            <span class="text-xs text-green-100">Panen</span>
                        </div>
                        <div class="bg-white bg-opacity-10 rounded-lg p-3 text-center backdrop-blur-sm">
                            <!-- [DIPERBAIKI] Menambahkan (int) atau floor() untuk membulatkan hari -->
                            <span class="block text-2xl font-bold text-white">{{ (int) $user->created_at->diffInDays(now()) }}</span>
                            <span class="text-xs text-green-100">Hari Aktif</span>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div>
                        @if($nextLevelScore)
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-green-100">Menuju Level {{ $user->level + 1 }}</span>
                                <span class="text-white font-bold">{{ $user->total_score }} / {{ $nextLevelScore }} XP</span>
                            </div>
                            <div class="w-full bg-green-900 bg-opacity-40 rounded-full h-3">
                                <div class="bg-yellow-400 h-3 rounded-full transition-all duration-1000" style="width: {{ $progressPercent }}%"></div>
                            </div>
                        @else
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-yellow-300 font-bold">Level Maksimal Tercapai!</span>
                            </div>
                            <div class="w-full bg-green-900 bg-opacity-40 rounded-full h-3">
                                <div class="bg-yellow-400 h-3 rounded-full" style="width: 100%"></div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- 2. BADGE COLLECTION (Baru) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="bg-yellow-100 text-yellow-700 p-2 rounded-lg mr-3">🏆</span>
                        Koleksi Lencana (Badges)
                    </h3>

                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        @foreach($badges as $badge)
                            <div class="flex flex-col items-center p-4 rounded-xl border {{ $badge['unlocked'] ? 'bg-yellow-50 border-yellow-200' : 'bg-gray-50 border-gray-200 opacity-60 grayscale' }}">
                                <div class="text-4xl mb-2">{{ $badge['icon'] }}</div>
                                <h4 class="font-bold text-sm text-center {{ $badge['unlocked'] ? 'text-gray-800' : 'text-gray-500' }}">{{ $badge['name'] }}</h4>
                                <p class="text-xs text-center mt-1 {{ $badge['unlocked'] ? 'text-gray-600' : 'text-gray-400' }}">{{ $badge['desc'] }}</p>
                                @if(!$badge['unlocked'])
                                    <span class="mt-2 text-[10px] uppercase font-bold text-gray-400 border border-gray-300 px-2 py-0.5 rounded-full">Terkunci</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- 3. RIWAYAT TANAMAN (Baru) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <span class="bg-green-100 text-green-700 p-2 rounded-lg mr-3">🌿</span>
                            Kebun Saya
                        </h3>
                        <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                            @forelse($myPlants as $plant)
                                <div class="flex items-center justify-between p-3 border rounded-lg {{ $plant->status == 'active' ? 'border-green-200 bg-green-50' : 'border-gray-100 bg-gray-50' }}">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ asset('storage/' . $plant->plant->image_url) }}" class="w-12 h-12 rounded-md object-cover" alt="{{ $plant->plant->name }}">
                                        <div>
                                            <p class="font-bold text-gray-800">{{ $plant->plant->name }}</p>
                                            <p class="text-xs text-gray-500">Mulai: {{ $plant->created_at->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        @if($plant->status == 'active')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Panen
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">Belum ada riwayat tanaman.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- 4. RIWAYAT KUIS (Baru) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <span class="bg-blue-100 text-blue-700 p-2 rounded-lg mr-3">📝</span>
                            Riwayat Akademik
                        </h3>
                        <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                            @forelse($myQuizzes as $attempt)
                                <div class="flex items-center justify-between p-3 border border-gray-100 rounded-lg hover:bg-gray-50">
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $attempt->quiz->title }}</p>
                                        <p class="text-xs text-gray-500">{{ $attempt->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xl font-bold {{ $attempt->score >= 80 ? 'text-green-600' : ($attempt->score >= 60 ? 'text-blue-600' : 'text-red-500') }}">
                                            {{ $attempt->score }}
                                        </span>
                                        <span class="text-xs text-gray-400 block">Poin</span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">Belum ada kuis yang dikerjakan.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>

            <!-- 5. PENGATURAN AKUN (Toggle) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" x-data="{ activeTab: '' }">
                <div class="p-6 sm:p-8">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900">⚙️ Pengaturan Akun</h2>
                            <p class="text-sm text-gray-600">Ubah informasi profil atau password Anda.</p>
                        </div>
                        <div class="flex space-x-2">
                            <button
                                @click="activeTab = (activeTab === 'profile' ? '' : 'profile')"
                                :class="activeTab === 'profile' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700'"
                                class="px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                Edit Profil
                            </button>
                            <button
                                @click="activeTab = (activeTab === 'password' ? '' : 'password')"
                                :class="activeTab === 'password' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700'"
                                class="px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                Ganti Password
                            </button>
                        </div>
                    </div>

                    <!-- Form Profil -->
                    <div x-show="activeTab === 'profile'" x-transition style="display: none;" class="mt-6 border-t pt-6">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <!-- Form Password -->
                    <div x-show="activeTab === 'password'" x-transition style="display: none;" class="mt-6 border-t pt-6">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <!-- Hapus Akun (Disembunyikan di Accordion Merah) -->
            <div class="bg-red-50 border border-red-200 overflow-hidden shadow-sm sm:rounded-lg" x-data="{ open: false }">
                <div class="p-4 cursor-pointer flex justify-between items-center" @click="open = !open">
                    <span class="text-red-700 font-medium text-sm">Zona Bahaya: Hapus Akun</span>
                    <svg class="w-5 h-5 text-red-500 transform transition-transform" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div x-show="open" class="p-6 border-t border-red-200 bg-white" style="display: none;">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
