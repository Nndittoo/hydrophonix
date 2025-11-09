<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Modul Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Header Kartu -->
                    <div class="border-b border-gray-200 pb-4 mb-6">
                        <h3 class="text-xl font-semibold text-gray-900">Formulir Modul Baru</h3>
                        <p class="text-sm text-gray-500 mt-1">Isi detail di bawah ini untuk menambahkan modul pembelajaran baru ke sistem.</p>
                    </div>

                    <!-- [PERUBAHAN] Menambahkan x-data untuk Alpine.js -->
                    <form method="POST" action="{{ route('admin.modules.store') }}" enctype="multipart/form-data"
                          x-data="{ fileName: '' }">
                        @csrf

                        <!-- Judul Modul -->
                        <div>
                            <x-input-label for="title" value="Judul Modul" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus placeholder="Contoh: Pengenalan Nutrisi AB Mix" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Level Dibutuhkan -->
                        <div class="mt-4">
                            <x-input-label for="level_required" value="Level Dibutuhkan" />
                            <x-text-input id="level_required" class="block mt-1 w-full" type="number" name="level_required" :value="old('level_required', 1)" required min="1" />
                            <x-input-error :messages="$errors->get('level_required')" class="mt-2" />
                        </div>

                        <!-- Deskripsi Singkat -->
                        <div class="mt-4">
                            <x-input-label for="description" value="Deskripsi Singkat (Pratinjau)" />
                            <textarea id="description" name="description" rows="3"
                                      class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm"
                                      placeholder="Deskripsi singkat ini akan muncul di kartu pratinjau modul...">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- [PERUBAHAN] Input File PDF diganti dengan Dropzone -->
                        <div class="mt-4">
                            <x-input-label for="file_path" value="File PDF Modul" />
                            <div class="flex items-center justify-center w-full">
                                <!-- [TEMA] Warna 'dark:' dihapus dan diganti dengan tema hijau -->
                                <label for="dropzone-file"
                                       class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-green-50 hover:bg-green-100">

                                    <!-- Konten di dalam dropzone -->
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <!-- [PERUBAHAN] Ikon disesuaikan dengan tema -->
                                        <svg class="w-10 h-10 mb-4 text-green-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                        </svg>
                                        <!-- [PERUBAHAN] Teks diubah dan ditambahkan Alpine.js -->
                                        <p class="mb-2 text-sm text-green-800" x-show="!fileName">
                                            <span class="font-semibold">Klik untuk upload</span> atau seret dan lepas
                                        </p>
                                        <p class="text-xs text-green-700" x-show="!fileName">
                                            Hanya file .pdf (MAKS. 10MB)
                                        </p>
                                        <!-- Ini akan menampilkan nama file yang dipilih -->
                                        <p class="mb-2 text-sm text-green-900 font-semibold" x-show="fileName" x-text="fileName"></p>
                                    </div>

                                    <!-- [PERUBAHAN] Input file dihubungkan ke 'name' dan Alpine.js -->
                                    <input id="dropzone-file"
                                           name="file_path"
                                           type="file"
                                           class="hidden"
                                           accept=".pdf"
                                           required
                                           @change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''" />
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('file_path')" class="mt-2" />
                        </div>
                        <!-- [AKHIR PERUBAHAN] -->

                        <!-- Tombol Simpan -->
                        <div class="flex items-center justify-end mt-6 pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.modules.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-800 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Simpan Modul
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
