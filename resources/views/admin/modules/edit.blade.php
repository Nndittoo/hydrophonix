<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Modul: ') }} {{ $module->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Formulir -->
                    <form method="POST" action="{{ route('admin.modules.update', $module) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- [PENTING] Gunakan metode PUT untuk update -->

                        <!-- Judul Modul -->
                        <div>
                            <x-input-label for="title" value="Judul Modul" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $module->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Level Dibutuhkan -->
                        <div class="mt-4">
                            <x-input-label for="level_required" value="Level Dibutuhkan" />
                            <x-text-input id="level_required" class="block mt-1 w-full" type="number" name="level_required" :value="old('level_required', $module->level_required)" required />
                            <x-input-error :messages="$errors->get('level_required')" class="mt-2" />
                        </div>

                        <!-- Deskripsi Singkat -->
                        <div class="mt-4">
                            <x-input-label for="description" value="Deskripsi Singkat (Pratinjau)" />
                            <textarea id="description" name="description" rows="3"
                                      class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm">{{ old('description', $module->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Upload File PDF -->
                        <div class="mt-4">
                            <x-input-label for="file_path" value="Upload PDF Baru (Opsional)" />
                            <p class="text-sm text-gray-500 mb-2">
                                File saat ini: <a href="{{ Storage::url($module->file_path) }}" target="_blank" class="text-green-600 underline">Lihat PDF Saat Ini</a>.
                                <br>Kosongkan jika tidak ingin mengganti file.
                            </p>
                            <input id="file_path" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                   type="file" name="file_path">
                            <x-input-error :messages="$errors->get('file_path')" class="mt-2" />
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.modules.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Batal
                            </a>
                            <x-primary-button class="ms-3 bg-green-600 hover:bg-green-700">
                                Update Modul
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
