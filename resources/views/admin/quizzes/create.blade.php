<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Kuis Baru - Langkah 1 dari 3') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Header Kartu -->
                    <div class="border-b border-gray-200 pb-4 mb-6">
                        <h3 class="text-xl font-semibold text-gray-900">Formulir Kuis Baru</h3>
                        <p class="text-sm text-gray-500 mt-1">Pilih modul yang ingin Anda tambahkan kuisnya dan beri nama kuis tersebut.</p>
                    </div>

                    <!-- Formulir -->
                    <form method="POST" action="{{ route('admin.quizzes.store') }}">
                        @csrf

                        <!-- Dropdown Modul -->
                        <div>
                            <x-input-label for="module_id" value="Pilih Modul" />
                            <select id="module_id" name="module_id" required
                                    class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm">

                                <!-- Opsi default jika tidak ada modul -->
                                @if($availableModules->isEmpty())
                                    <option value="" disabled>Tidak ada modul yang tersedia (semua sudah memiliki kuis).</option>
                                @else
                                    <option value="" disabled selected>Pilih salah satu modul...</option>
                                    @foreach($availableModules as $module)
                                        <option value="{{ $module->id }}">{{ $module->title }} (Lv. {{ $module->level_required }})</option>
                                    @endforeach
                                @endif
                            </select>

                            <!-- Link untuk membuat modul baru -->
                            @if($availableModules->isEmpty())
                                <p class="mt-2 text-sm text-gray-500">
                                    Anda harus <a href="{{ route('admin.modules.create') }}" class="text-green-600 underline font-medium">membuat modul baru</a> terlebih dahulu.
                                </p>
                            @endif
                            <x-input-error :messages="$errors->get('module_id')" class="mt-2" />
                        </div>

                        <!-- Judul Kuis -->
                        <div class="mt-4">
                            <x-input-label for="title" value="Judul Kuis" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus placeholder="Contoh: Uji Pengetahuan Dasar Modul 1" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="flex items-center justify-end mt-6 pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.quizzes.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Batal
                            </a>

                            <!-- Tombol submit (nonaktif jika tidak ada modul) -->
                            <button type="submit"
                                    @if($availableModules->isEmpty()) disabled @endif
                                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-800 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Buat & Lanjut (Langkah 2)
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
