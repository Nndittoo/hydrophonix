<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Tanaman') }}: {{ $plant->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('admin.plants.update', $plant) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Penting untuk update -->

                        <!-- Nama Tanaman -->
                        <div>
                            <x-input-label for="name" value="Nama Tanaman" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $plant->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Deskripsi -->
                        <div class="mt-4">
                            <x-input-label for="description" value="Deskripsi Singkat" />
                            <textarea id="description" name="description" rows="3" class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm" required>{{ old('description', $plant->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Gambar -->
                        <div class="mt-4">
                            <x-input-label for="image_url" value="Foto Tanaman (Opsional)" />

                            <!-- Pratinjau Gambar Saat Ini -->
                            <div class="mb-2">
                                <p class="text-sm text-gray-500 mb-1">Gambar saat ini:</p>
                                <img src="{{ Storage::url($plant->image_url) }}" alt="{{ $plant->name }}" class="w-32 h-32 object-cover rounded-md border border-gray-200">
                            </div>

                            <input id="image_url" type="file" name="image_url" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" accept="image/*">
                            <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                            <x-input-error :messages="$errors->get('image_url')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.plants.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <x-primary-button class="bg-green-600 hover:bg-green-700">
                                Update Tanaman
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
