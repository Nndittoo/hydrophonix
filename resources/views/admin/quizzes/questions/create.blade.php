<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Kuis - Langkah 2 dari 3') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <!-- Notifikasi sukses dari langkah 1 -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif <!-- <-- @endif yang hilang sudah ada di sini -->

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Header Kartu -->
                    <div class="border-b border-gray-200 pb-4 mb-6">
                        <h3 class="text-xl font-semibold text-gray-900">Tambah Pertanyaan untuk: {{ $quiz->title }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Tambahkan satu atau beberapa pertanyaan. Anda bisa mengedit pilihan jawaban nanti di Langkah 3.</p>
                    </div>

                    <!--
                      Formulir dengan Alpine.js
                      x-data: Kita mulai dengan satu pertanyaan kosong.
                    -->
                    <form method="POST" action="{{ route('admin.quizzes.questions.store', $quiz) }}"
                          x-data="{ questions: [{ question_text: '' }] }">
                        @csrf

                        <!-- Wrapper untuk daftar pertanyaan dinamis -->
                        <div class="space-y-4">
                            <!-- Loop melalui array 'questions' di Alpine.js -->
                            <template x-for="(question, index) in questions" :key="index">
                                <div class="flex items-start space-x-3">
                                    <!-- Input Pertanyaan -->
                                    <div class="flex-1">

                                        <!-- [PERBAIKAN] Menggunakan <label> HTML biasa dengan x-text -->
                                        <label class="block font-medium text-sm text-gray-700"
                                               x-text="'Pertanyaan ' + (index + 1)">
                                            <!-- Teks ini akan diganti oleh x-text -->
                                        </label>

                                        <x-text-input
                                            class="block mt-1 w-full"
                                            type="text"
                                            :name="`questions[${index}][question_text]`"
                                            x-model="question.question_text"
                                            required
                                            placeholder="Tulis teks pertanyaan di sini..." />
                                    </div>
                                    <!-- Tombol Hapus (hanya jika > 1) -->
                                    <div class="pt-7">
                                        <button type="button" @click="questions.splice(index, 1)" x-show="questions.length > 1"
                                                class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-100">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12.578 0c-.27.004-.537.01-.804.018c-2.25.028-4.12.2-5.744.408M15 5.79V4.5A2.25 2.25 0 0 0 12.75 2.25h-1.5A2.25 2.25 0 0 0 9 4.5v1.29m0 0c-.653.115-1.27.27-1.844.452m1.844-.452L10.5 8.25m.389 3.468-3.631 13.143a.656.656 0 0 0 .287.733l.287.15a.656.656 0 0 0 .733-.287l3.631-13.143m0 0l-3.631 13.143" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Tombol "Tambah Pertanyaan Lain" -->
                        <div class="mt-4">
                            <button type="button" @click="questions.push({ question_text: '' })"
                                    class="text-sm font-medium text-green-600 hover:text-green-800">
                                + Tambah Pertanyaan Lain
                            </button>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="flex items-center justify-end mt-6 pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.quizzes.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Batal
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-800 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Simpan Pertanyaan & Lanjut (Langkah 3)
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
