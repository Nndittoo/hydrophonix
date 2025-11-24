<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Misi') }}: {{ $mission->title }} - {{ $plant->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('admin.plants.missions.update', [$plant, $mission]) }}">
                        @csrf
                        @method('PUT') <!-- Penting untuk update -->

                        <!-- Step Number -->
                        <div>
                            <x-input-label for="step_number" value="Nomor Tahap (Urutan)" />
                            <x-text-input id="step_number" class="block mt-1 w-full" type="number" name="step_number" :value="old('step_number', $mission->step_number)" required />
                            <x-input-error :messages="$errors->get('step_number')" class="mt-2" />
                        </div>

                        <!-- Judul Misi -->
                        <div class="mt-4">
                            <x-input-label for="title" value="Judul Misi" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $mission->title)" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Deskripsi -->
                        <div class="mt-4">
                            <x-input-label for="description" value="Deskripsi Instruksi" />
                            <textarea id="description" name="description" rows="3" class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm" required>{{ old('description', $mission->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Durasi -->
                        <div class="mt-4">
                            <x-input-label for="duration_days" value="Durasi (Hari) Sebelum Misi Berikutnya" />
                            <x-text-input id="duration_days" class="block mt-1 w-full" type="number" name="duration_days" :value="old('duration_days', $mission->duration_days)" required />
                            <p class="text-xs text-gray-500 mt-1">Berapa hari pengguna harus menunggu atau melakukan aktivitas ini?</p>
                            <x-input-error :messages="$errors->get('duration_days')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.plants.missions.index', $plant) }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <x-primary-button class="bg-green-600 hover:bg-green-700">
                                Update Misi
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
