<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hasil Kuis: {{ $attempt->quiz->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8"> {{-- Lebar diubah agar lebih fokus --}}

            <!-- Notifikasi Naik Level (Tidak Berubah) -->
            @if (session('level_up'))
                <div class="mb-6 bg-green-600 overflow-hidden shadow-sm sm:rounded-lg text-white">
                    <div class="p-6 flex items-center space-x-4">
                        <svg class="h-16 w-16 text-white flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                        </svg>
                        <div>
                            <h3 class="text-2xl font-bold">{{ session('level_up') }}</h3>
                            <p class="text-green-100 mt-1">
                                Poin Anda telah ditambahkan ke Total Skor. Teruslah belajar!
                            </p>
                        </div>
                    </div>
                </div>
            @endif


            <!-- Kartu Hasil Kuis yang Dinamis (Tidak Berubah) -->
            @php
                $score = $attempt->score;
                if ($score == 100) {
                    $theme = 'yellow';
                    $icon = '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />';
                    $title = 'SEMPURNA!';
                    $message = 'Luar biasa! Anda menguasai modul ini. Skor 100 telah dicatat.';
                    $bgColor = 'bg-yellow-500';
                    $textColor = 'text-yellow-100';
                    $iconColor = 'text-yellow-300';
                } elseif ($score >= 80) {
                    $theme = 'green';
                    $icon = '<path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.68.39-.834.623-1.728.623-2.652v-1.12c0-1.32.94-2.505 2.203-2.812a2.498 2.498 0 0 1 2.26 1.402 2.498 2.498 0 0 1-.342 2.686A5.996 5.996 0 0 1 18 9.75v1.5a2.25 2.25 0 0 1-2.25 2.25H15M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.68.39-.834.623-1.728.623-2.652v-1.12c0-1.32.94-2.505 2.203-2.812a2.498 2.498 0 0 1 2.26 1.402 2.498 2.498 0 0 1-.342 2.686A5.996 5.996 0 0 1 18 9.75v1.5a2.25 2.25 0 0 1-2.25 2.25H15m-8.367 0a2.25 2.25 0 0 1-2.25-2.25v-1.5c0-1.385.446-2.677 1.209-3.642A8.96 8.96 0 0 1 8.01 3.25c1.12 0 2.193.304 3.091.868m-8.367 7.5v-1.5c0-1.385.446-2.677 1.209-3.642A8.96 8.96 0 0 1 8.01 3.25c1.12 0 2.193.304 3.091.868m0 0a5.23 5.23 0 0 1 3.089 1.636m0 0A5.23 5.23 0 0 1 15.25 3.25c1.12 0 2.193.304 3.091.868m0 0a5.23 5.23 0 0 1 3.089 1.636m0 0A5.23 5.23 0 0 1 21.99 3.25c.489 0 .964.068 1.41.196m-8.367 7.5v-1.5c0-1.385.446-2.677 1.209-3.642A8.96 8.96 0 0 1 8.01 3.25c1.12 0 2.193.304 3.091.868" />';
                    $title = 'Kerja Bagus!';
                    $message = 'Skor Anda sangat tinggi. Ini akan sangat membantu menaikkan peringkat Anda!';
                    $bgColor = 'bg-green-600';
                    $textColor = 'text-green-100';
                    $iconColor = 'text-green-300';
                } elseif ($score >= 60) {
                    $theme = 'blue';
                    $icon = '<path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.31h5.518a.563.563 0 0 1 .321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.563.563 0 0 1-.84.61l-4.725-3.882a.563.563 0 0 0-.652 0L5.602 19.7a.563.563 0 0 1-.84-.61l1.285-5.386a.563.563 0 0 0-.182-.557l-4.204-3.602a.563.563 0 0 1 .321-.988H7.88a.563.563 0 0 0 .475-.31L10.48 3.5Z" />';
                    $title = 'Tidak Buruk!';
                    $message = 'Anda berhasil lulus. Jika Anda merasa bisa lebih baik, Anda bisa ulangi kuis ini kapan saja.';
                    $bgColor = 'bg-blue-600';
                    $textColor = 'text-blue-100';
                    $iconColor = 'text-blue-300';
                } else {
                    $theme = 'orange';
                    $icon = '<path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.181M19.015 4.356v4.992m0 0h-4.992m4.992 0-3.181-3.181M2.985 4.356h4.992V9.35m0 0-3.181 3.181M16.023 19.644l-3.181-3.181m0 0-3.181 3.181m3.181-3.181 3.181 3.181" />';
                    $title = 'Coba Lagi, ya!';
                    $message = 'Jangan khawatir! Pelajari ulang modulnya dan coba lagi. Anda pasti bisa!';
                    $bgColor = 'bg-yellow-600';
                    $textColor = 'text-yellow-100';
                    $iconColor = 'text-yellow-300';
                }
            @endphp

            <div class="{{ $bgColor }} overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-white text-center">

                    <svg class="h-20 w-20 {{ $iconColor }} mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        {!! $icon !!}
                    </svg>

                    <h3 class="text-3xl font-bold mt-4">{{ $title }}</h3>

                    <div class="text-8xl font-bold text-white my-4">
                        {{ $attempt->score }}
                    </div>

                    <p class="{{ $textColor }} max-w-md mx-auto">
                        {{ $message }}
                    </p>

                    <div class="mt-8 space-y-3 sm:space-y-0 sm:space-x-4">
                        @if($score < 100)
                            <a href="{{ route('quiz.show', $attempt->quiz_id) }}"
                               class="inline-block px-5 py-2 bg-white bg-opacity-20 text-white rounded-md font-semibold hover:bg-opacity-30">
                                Ulangi Kuis
                            </a>
                        @endif

                        <a href="{{ route('modules.show', $attempt->quiz->module->slug) }}"
                           class="inline-block px-5 py-2 bg-white bg-opacity-20 text-white rounded-md font-semibold hover:bg-opacity-30">
                            Lihat Modul
                        </a>
                    </div>

                </div>
            </div>

            <!-- [BAGIAN DIPERBARUI] Tinjau Jawaban dengan Alpine.js -->
            <!-- 1. Tambahkan x-data="{ showAnswers: false }" -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg" x-data="{ showAnswers: false }">
                <div class="p-6 sm:p-8 text-gray-900">

                    <!-- 2. Ubah header menjadi flex untuk menampung tombol -->
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 border-b pb-4">
                        <h3 class="text-2xl font-semibold">Tinjau Jawaban Anda</h3>

                        <!-- Tombol Toggle Baru -->
                        <button type="button" @click="showAnswers = !showAnswers"
                                class="mt-2 sm:mt-0 px-4 py-2 bg-green-100 text-green-800 rounded-md text-sm font-medium hover:bg-green-200 transition-colors w-full sm:w-auto">
                            <!-- Teks tombol berubah secara dinamis -->
                            <span x-show="!showAnswers" class="flex items-center justify-center">
                                <svg class="h-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 10.224 7.29 6.3 12 6.3s8.577 3.924 9.964 5.383c.18.18.18.459 0 .639C20.577 13.776 16.71 17.7 12 17.7s-8.577-3.924-9.964-5.383Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                Tampilkan Jawaban
                            </span>
                            <span x-show="showAnswers" style="display: none;" class="flex items-center justify-center">
                                <svg class="h-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                                Sembunyikan Jawaban
                            </span>
                        </button>
                    </div>

                    <!-- 3. Tambahkan x-show="showAnswers" ke wrapper konten -->
                    <div class="space-y-6" x-show="showAnswers" style="display: none;">
                        @foreach ($attempt->quiz->questions as $index => $question)
                            @php
                                // Dapatkan ID jawaban user & ID jawaban benar dari data controller
                                $userAnswerId = $userAnswers[$question->id] ?? null;
                                $correctAnswerId = $correctOptionsMap[$question->id] ?? null;

                                $isCorrect = $userAnswerId == $correctAnswerId;

                                // Dapatkan teks dari jawaban
                                $userAnswerText = $userAnswerId ? $question->options->find($userAnswerId)->option_text : 'Tidak dijawab';
                                $correctAnswerText = $correctAnswerId ? $question->options->find($correctAnswerId)->option_text : 'Tidak ada jawaban benar';
                            @endphp

                            <div class="border-b pb-6">
                                <h4 class="text-lg font-semibold">{{ $index + 1 }}. {{ $question->question_text }}</h4>

                                <!-- Jawaban Anda -->
                                <div class="mt-4 flex items-start space-x-3">
                                    <span class="flex-shrink-0 w-6 h-6">
                                        @if ($isCorrect)
                                            <!-- Ikon Centang (Hijau) -->
                                            <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                        @else
                                            <!-- Ikon Silang (Merah) -->
                                            <svg class="h-6 w-6 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                        @endif
                                    </span>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Jawaban Anda:</span>
                                        <p class="font-medium {{ $isCorrect ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $userAnswerText }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Jawaban Benar (hanya tampil jika jawaban user salah) -->
                                @if (!$isCorrect)
                                    <div class="mt-2 flex items-start space-x-3">
                                        <span class="flex-shrink-0 w-6 h-6">
                                            <!-- Ikon Info (Biru/Hijau) -->
                                            <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                               <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                            </svg>
                                        </span>
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Jawaban Benar:</span>
                                            <p class="font-medium text-green-600">
                                                {{ $correctAnswerText }}
                                            </p>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- [AKHIR BAGIAN BARU] -->

        </div>
    </div>
</x-app-layout>
