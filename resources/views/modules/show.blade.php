<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $module->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- [TEMA] Notifikasi diubah menjadi hijau -->
            @if (session('info'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('info') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if($module->file_path)

                        <!-- [DIRAPIKAN] Header Modul & Tombol Kuis -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8 items-center border-b border-gray-200 pb-6 mb-6">

                            <!-- Kolom Kiri: Info Modul -->
                            <div>
                                <h3 class="text-3xl font-bold text-gray-800">{{ $module->title }}</h3>
                                <p class="text-gray-600 mt-2">{{ $module->description }}</p>
                            </div>

                            <!-- Kolom Kanan: Tombol Aksi Kuis -->
                            @if ($module->quiz)
                                <div class="flex flex-col items-center md:items-end w-full">
                                    <span class="text-lg italic text-gray-500 font-semibold">Uji Pemahaman Anda 📝</span>
                                    <a href="{{ route('quiz.show', $module->quiz->id) }}"
                                       class="mt-2 w-full md:w-auto text-center px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 font-semibold shadow-sm transition-colors duration-200">
                                        <!-- [DIRAPIKAN] Teks tombol disederhanakan -->
                                        Mulai Kuis
                                    </a>
                                </div>
                            @else
                                <!-- Placeholder jika tidak ada kuis -->
                                <div class="flex flex-col items-center md:items-end w-full">
                                     <span class="text-sm italic text-gray-400">Modul ini tidak memiliki kuis.</span>
                                </div>
                            @endif
                        </div>


                        <!-- [DIRAPIKAN] PDF Reader menggunakan <embed> -->
                        <div class="w-full h-[80vh] border border-gray-300 rounded-lg overflow-hidden shadow-inner">
                            <embed src="{{ Storage::url($module->file_path) }}" type="application/pdf" width="100%" height="100%">
                                <p class="p-4 text-center">
                                    Browser Anda tidak dapat menampilkan PDF.
                                    <a href="{{ Storage::url($module->file_path) }}"
                                       class="text-green-600 underline font-medium"
                                       download>
                                        Download PDF di sini
                                    </a>.
                                </p>
                            </embed>
                        </div>
                    @else
                        <p class="text-center text-gray-500">File PDF untuk modul ini belum di-upload.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
