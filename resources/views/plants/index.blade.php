<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🌱 {{ __('Katalog Tanaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Notifikasi (jika ada error, dll) -->
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- [BARU] Bagian Tanaman Aktif Anda -->
            @if ($activePlant)
                <div class="bg-green-600 overflow-hidden shadow-sm sm:rounded-lg mb-6 text-white">
                    <div class="p-6 md:flex md:items-center md:space-x-6">
                        <img src="{{ asset('storage/' . $activePlant->plant->image_url) }}" alt="{{ $activePlant->plant->name }}" class="w-full md:w-48 h-48 object-cover rounded-lg shadow-md">
                        <div class="mt-4 md:mt-0">
                            <h3 class="text-sm uppercase text-green-200">Sedang Ditanam</h3>
                            <h2 class="text-4xl font-bold">{{ $activePlant->plant->name }}</h2>
                            <p class="text-green-100 mt-2">
                                Misi saat ini: <span class="font-semibold">{{ $activePlant->currentMission->title }}</span>
                            </p>
                            <p class="text-green-100">
                                Umur tanaman: <span class="font-semibold">{{ $activePlant->plant_age }} hari</span>
                            </p>
                            <a href="{{ route('user-plants.index') }}" class="inline-block mt-4 px-6 py-2 bg-white text-green-700 rounded-md text-sm font-semibold hover:bg-green-50 shadow">
                                Lanjutkan Misi
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- [BARU] Bagian Katalog Tanaman -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-semibold mb-2">Pilih Misi Tanam Baru</h3>

                    @if ($activePlant)
                        <div class="mb-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                            <p class="font-bold">Perhatian</p>
                            <p>Anda harus menyelesaikan misi <span class="font-semibold">{{ $activePlant->plant->name }}</span> sebelum dapat memulai misi baru.</p>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                        @forelse ($allPlants as $plant)
                            <div class="border rounded-lg shadow flex flex-col {{ $activePlant && $activePlant->plant_id == $plant->id ? 'bg-gray-100 opacity-60' : 'bg-white' }}">
                                <img src="{{ asset('storage/' . $plant->image_url) }}" alt="{{ $plant->name }}" class="rounded-t-lg h-40 w-full object-cover">
                                <div class="p-4 flex flex-col flex-grow">
                                    <h4 class="font-semibold text-lg">{{ $plant->name }}</h4>
                                    <p class="text-sm text-gray-600 mt-1 mb-4 flex-grow">
                                        {{ Str::limit($plant->description, 70) }}
                                    </p>

                                    <!-- Logika Tombol Sesuai Status -->
                                    <div class="mt-auto">
                                        @if($activePlant && $activePlant->plant_id == $plant->id)
                                            <!-- Tanaman ini sedang aktif -->
                                            <span class="inline-block w-full text-center mt-2 px-4 py-2 bg-green-200 text-green-800 rounded-md text-sm font-semibold">
                                                🌱 Sedang Ditanam
                                            </span>
                                        @elseif($activePlant)
                                            <!-- User punya tanaman lain yang aktif -->
                                            <button class="inline-block w-full text-center mt-2 px-4 py-2 bg-gray-200 text-gray-500 rounded-md text-sm font-medium cursor-not-allowed" disabled title="Selesaikan misi Anda saat ini">
                                                Lihat Misi
                                            </button>
                                        @else
                                            <!-- Tidak ada tanaman aktif, tombol normal -->
                                            <a href="{{ route('plants.show', $plant->id) }}" class="inline-block w-full text-center mt-2 px-4 py-2 bg-green-600 text-white rounded-md text-sm font-semibold hover:bg-green-700 shadow-sm">
                                                Lihat Misi
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>Belum ada data tanaman yang ditambahkan oleh admin.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
