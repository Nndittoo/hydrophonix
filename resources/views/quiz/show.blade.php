<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kuis: {{ $quiz->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <!-- Kartu Hero Sesuai Tema (Tidak berubah) -->
            <div class="bg-green-600 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-white flex items-center space-x-4">
                    <svg class="h-12 w-12 text-green-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <div>
                        <h3 class="text-2xl font-semibold">{{ $quiz->title }}</h3>
                        <p class="text-green-100 mt-1">
                            Dari Modul: {{ $quiz->module->title }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- [PERUBAHAN BESAR] Kartu Form Kuis dengan Alpine.js -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <!--
                  x-data: Inisialisasi state Alpine.js
                  - currentStep: Menunjukkan slide pertanyaan saat ini (dimulai dari 0)
                  - totalSteps: Jumlah total pertanyaan
                -->
                <div x-data="{ currentStep: 0, totalSteps: {{ $quiz->questions->count() }} }">

                    <!-- [BARU] Progress Bar -->
                    <div class="p-4 border-b border-gray-200">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-semibold text-green-600">
                                Pertanyaan <span x-text="currentStep + 1"></span> dari <span x-text="totalSteps"></span>
                            </span>
                            <!-- Persentase Progres -->
                            <span class="text-sm font-medium text-gray-600" x-text="`${Math.round((currentStep + 1) / totalSteps * 100)}%`"></span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <!-- Bilah progres dinamis -->
                            <div class="bg-green-600 h-2.5 rounded-full"
                                 :style="`width: ${ (currentStep + 1) / totalSteps * 100 }%`"
                                 style="transition: width 0.3s ease;">
                            </div>
                        </div>
                    </div>

                    <!-- Form Kuis -->
                    <form action="{{ route('quiz.submit', $quiz->id) }}" method="POST">
                        @csrf
                        <div class="p-6 sm:p-8 text-gray-900">

                            <!-- Wrapper untuk semua pertanyaan -->
                            <div>
                                @forelse ($quiz->questions as $index => $question)
                                    <!--
                                      Setiap pertanyaan adalah satu 'slide'.
                                      x-show="currentStep === {{ $index }}" akan menampilkan slide ini HANYA JIKA
                                      currentStep sama dengan nomor index pertanyaan.
                                    -->
                                    <fieldset x-show="currentStep === {{ $index }}" style="display: none;">
                                        <legend class="text-lg font-semibold text-gray-900">
                                            {{ $question->question_text }}
                                        </legend>

                                        <!-- Pilihan Jawaban (Radio button kustom, tidak berubah) -->
                                        <div class="mt-4 space-y-3">
                                            @foreach ($question->options as $option)
                                                <label
                                                    for="option-{{ $option->id }}"
                                                    class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer
                                                           text-gray-700 transition-all duration-150
                                                           hover:bg-gray-50
                                                           has-[:checked]:border-green-600
                                                           has-[:checked]:bg-green-50
                                                           has-[:checked]:text-green-900
                                                           has-[:checked]:ring-2
                                                           has-[:checked]:ring-green-500
                                                           group">

                                                    <input
                                                        type="radio"
                                                        id="option-{{ $option->id }}"
                                                        name="answers[{{ $question->id }}]"
                                                        value="{{ $option->id }}"
                                                        class="hidden"
                                                        required>

                                                    <span class="w-5 h-5 border-2 border-gray-300 rounded-full flex items-center justify-center
                                                                 group-hover:border-gray-400
                                                                 group-has-[:checked]:border-green-600
                                                                 group-has-[:checked]:bg-green-600">
                                                        <span class="w-2 h-2 rounded-full bg-white transition-transform scale-0 group-has-[:checked]:scale-100"></span>
                                                    </span>

                                                    <span class="ml-3 font-medium">{{ $option->option_text }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </fieldset>
                                @empty
                                    <p class="text-gray-500">Kuis ini belum memiliki pertanyaan.</p>
                                @endforelse
                            </div>

                            <!-- [BARU] Navigasi Slide -->
                            <div class="mt-8 border-t pt-6 flex justify-between items-center">
                                <!-- Tombol "Sebelumnya" -->
                                <div>
                                    <button
                                        type="button"
                                        @click="currentStep--"
                                        x-show="currentStep > 0"
                                        class="px-6 py-2 bg-gray-200 text-gray-700 rounded-md text-sm font-semibold hover:bg-gray-300">
                                        Sebelumnya
                                    </button>
                                </div>

                                <div>
                                    <!-- Tombol "Selanjutnya" -->
                                    <button
                                        type="button"
                                        @click="currentStep++"
                                        x-show="currentStep < totalSteps - 1"
                                        class="px-6 py-2 bg-green-600 text-white rounded-md text-sm font-semibold hover:bg-green-700">
                                        Selanjutnya
                                    </button>

                                    <!-- Tombol "Submit" (hanya tampil di slide terakhir) -->
                                    <button
                                        type="submit"
                                        x-show="currentStep === totalSteps - 1"
                                        style="display: none;" {{-- Sembunyikan by default, Alpine akan menampilkannya --}}
                                        class="w-full px-8 py-3 bg-green-600 text-white rounded-md text-lg font-semibold hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all shadow-sm">
                                        Selesai & Lihat Skor
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
            <!-- [AKHIR PERUBAHAN BESAR] -->
        </div>
    </div>
</x-app-layout>
