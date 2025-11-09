<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kuis (Quiz Builder)') }}
        </h2>
    </x-slot>

    <!-- [PERUBAHAN BESAR] Menggunakan Alpine.js untuk data interaktif -->
    <!-- Kita memuat data PHP ($quiz) ke dalam variabel JavaScript 'quizData' -->
    <div class.py-12" x-data="{
        quizData: {{ $quiz->toJson() }},
        newQuestionText: '',
        showNotification: false,
        notificationMessage: '',
        notificationType: 'success',

        // Fungsi untuk menampilkan notifikasi
        notify(message, type = 'success') {
            this.notificationMessage = message;
            this.notificationType = type;
            this.showNotification = true;
            setTimeout(() => { this.showNotification = false }, 3000);
        },

        // [AJAX 1] Tambah Pertanyaan Baru
        addQuestion() {
            if (this.newQuestionText.trim() === '') {
                this.notify('Teks pertanyaan tidak boleh kosong.', 'error');
                return;
            }

            fetch(`{{ route('admin.quizzes.questions.store', $quiz) }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    question_text: this.newQuestionText
                })
            })
            .then(res => res.json())
            .then(newQuestionData => {
                this.quizData.questions.push(newQuestionData); // Tambahkan pertanyaan baru ke daftar
                this.newQuestionText = ''; // Kosongkan input
                this.notify('Pertanyaan baru berhasil ditambahkan.');
            })
            .catch(err => this.notify('Gagal menambahkan pertanyaan.', 'error'));
        },

        // [AJAX 2] Hapus Pertanyaan
        deleteQuestion(questionId, index) {
            if (!confirm('Yakin ingin menghapus pertanyaan ini?')) return;

            fetch(`/admin/questions/${questionId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                this.quizData.questions.splice(index, 1); // Hapus pertanyaan dari daftar
                this.notify(data.message || 'Pertanyaan berhasil dihapus.');
            })
            .catch(err => this.notify('Gagal menghapus pertanyaan.', 'error'));
        },

        // [AJAX 3] Tambah Pilihan Jawaban Baru
        addOption(question) {
            fetch(`/admin/questions/${question.id}/options`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(newOptionData => {
                question.options.push(newOptionData); // Tambahkan opsi baru ke pertanyaan
                this.notify('Pilihan baru berhasil ditambahkan.');
            })
            .catch(err => this.notify('Gagal menambah pilihan.', 'error'));
        },

        // [AJAX 4] Hapus Pilihan Jawaban
        deleteOption(optionId, question, optionIndex) {
            if (!confirm('Yakin ingin menghapus pilihan ini?')) return;

            fetch(`/admin/options/${optionId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (!res.ok) {
                    return res.json().then(err => { throw new Error(err.message) });
                }
                return res.json();
            })
            .then(data => {
                question.options.splice(optionIndex, 1); // Hapus opsi dari daftar
                this.notify(data.message || 'Pilihan berhasil dihapus.');
            })
            .catch(err => this.notify(err.message || 'Gagal menghapus pilihan.', 'error'));
        },

        // [AJAX 5] Atur Jawaban Benar
        setCorrectOption(question, option) {
            fetch(`/admin/questions/${question.id}/options/${option.id}/set-correct`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                // Set semua opsi lain ke false
                question.options.forEach(opt => {
                    opt.is_correct = false;
                });
                // Set opsi yang diklik ke true
                option.is_correct = true;
                this.notify(data.message || 'Jawaban benar berhasil diatur.');
            })
            .catch(err => this.notify('Gagal mengatur jawaban benar.', 'error'));
        },

        // [AJAX 6] Edit Teks Pilihan Jawaban
        updateOptionText(event, option) {
            let newText = event.target.value;
            fetch(`/admin/options/${option.id}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    option_text: newText
                })
            })
            .then(res => res.json())
            .then(updatedOption => {
                option.option_text = updatedOption.option_text; // Update teks di data Alpine
                event.target.blur(); // Lepas fokus dari input
                this.notify('Pilihan berhasil disimpan.');
            })
            .catch(err => this.notify('Gagal menyimpan pilihan.', 'error'));
        }

    }">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <!-- [BARU] Notifikasi Global (dikelola Alpine.js) -->
            <div x-show="showNotification"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform translate-y-2"
                 :class="{ 'bg-green-100 border-green-400 text-green-700': notificationType === 'success', 'bg-red-100 border-red-400 text-red-700': notificationType === 'error' }"
                 class="mb-4 border px-4 py-3 rounded relative"
                 role="alert"
                 style="display: none;">
                <span class="block sm:inline" x-text="notificationMessage"></span>
            </div>

            <!-- Formulir Edit Judul Kuis -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-semibold text-gray-900">Edit Judul Kuis</h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Kuis ini terhubung ke modul: <span class="font-medium text-green-600" x-text="quizData.module.title"></span>
                    </p>

                    <form method="POST" :action="`/admin/quizzes/${quizData.id}`" class="mt-4">
                        @csrf
                        @method('PUT')
                        <div class="flex items-center space-x-3">
                            <div class="flex-1">
                                <x-input-label for="title" value="Judul Kuis" class="sr-only" />
                                <x-text-input id="title" class="block w-full" type="text" name="title" x-model="quizData.title" required />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                Update Judul
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- [BARU] Formulir "Tambah Pertanyaan Baru" (AJAX) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-semibold text-gray-900">Tambah Pertanyaan Baru</h3>
                    <form @submit.prevent="addQuestion" class="mt-4">
                        <div class="flex items-start space-x-3">
                            <div class="flex-1">
                                <x-input-label for="new_question_text" value="Teks Pertanyaan" class="sr-only" />
                                <x-text-input id="new_question_text" class="block w-full" type="text" x-model="newQuestionText" placeholder="Tulis pertanyaan baru di sini..." />
                            </div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                + Tambah
                            </button>
                        </div>
                    </form>
                </div>
            </div>


            <!-- [DIPERBARUI] Daftar Pertanyaan (dikelola Alpine.js) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-gray-900">Kelola Pertanyaan & Jawaban</h3>
                    </div>

                    <div class="space-y-6">
                        <!-- Loop dari 'quizData' Alpine.js, bukan dari $quiz PHP -->
                        <template x-for="(question, index) in quizData.questions" :key="question.id">
                            <div class="p-4 border rounded-lg shadow-sm" x-data="{ editOptionId: null }">
                                <!-- Tampilan Pertanyaan -->
                                <div class="flex justify-between items-center">
                                    <h4 class="text-lg font-semibold" x-text="`${index + 1}. ${question.question_text}`"></h4>

                                    <!-- Tombol Hapus Pertanyaan (AJAX) -->
                                    <button type="button" @click="deleteQuestion(question.id, index)" class="text-gray-400 hover:text-red-600" title="Hapus Pertanyaan">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12.578 0c-.27.004-.537.01-.804.018c-2.25.028-4.12.2-5.744.408M15 5.79V4.5A2.25 2.25 0 0 0 12.75 2.25h-1.5A2.25 2.25 0 0 0 9 4.5v1.29m0 0c-.653.115-1.27.27-1.844.452m1.844-.452L10.5 8.25m.389 3.468-3.631 13.143a.656.656 0 0 0 .287.733l.287.15a.656.656 0 0 0 .733-.287l3.631-13.143m0 0l-3.631 13.143" /></svg>
                                    </button>
                                </div>

                                <!-- Daftar Pilihan Jawaban (Loop Alpine) -->
                                <div class="mt-4 space-y-3 ps-4 border-l-2 border-gray-100">
                                    <template x-for="(option, optionIndex) in question.options" :key="option.id">
                                        <div class="flex items-center justify-between group">
                                            <div class="flex items-center space-x-3">
                                                <!-- Tombol "Jadikan Benar" (AJAX) -->
                                                <button type="button" @click="setCorrectOption(question, option)"
                                                        title="Tandai sebagai jawaban benar"
                                                        class="w-5 h-5 rounded-full flex items-center justify-center border-2
                                                               :class="{ 'bg-green-500 border-green-500 text-white': option.is_correct, 'bg-gray-200 border-gray-200 text-gray-400': !option.is_correct }"
                                                               hover:border-green-500 hover:text-green-500">
                                                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                                                </button>

                                                <!-- Teks Pilihan Jawaban -->
                                                <div x-show="editOptionId !== option.id">
                                                    <span class="text-sm" :class="{ 'font-semibold text-green-700': option.is_correct, 'text-gray-700': !option.is_correct }" x-text="option.option_text"></span>
                                                    <button @click="editOptionId = option.id" class="text-xs text-gray-400 hover:text-blue-600 opacity-0 group-hover:opacity-100 transition-opacity">(edit)</button>
                                                </div>

                                                <!-- Form Edit Inline (AJAX) -->
                                                <div x-show="editOptionId === option.id" style="display: none;">
                                                    <input type="text" :value="option.option_text"
                                                           class="text-sm p-1 border border-green-500 rounded-md"
                                                           @keydown.enter.prevent="updateOptionText($event, option)"
                                                           @blur="editOptionId = null">
                                                </div>
                                            </div>

                                            <!-- Tombol Hapus Pilihan (AJAX) -->
                                            <button type="button" @click="deleteOption(option.id, question, optionIndex)" class="text-gray-300 hover:text-red-600 opacity-0 group-hover:opacity-100 transition-opacity" title="Hapus Pilihan">
                                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                                            </button>
                                        </div>
                                    </template>

                                    <!-- Tombol Tambah Pilihan Baru (AJAX) -->
                                    <div class="pt-2">
                                        <button type="button" @click="addOption(question)" class="text-xs font-medium text-green-600 hover:text-green-800">
                                            + Tambah Pilihan Baru
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- Tampilan jika tidak ada pertanyaan -->
                        <div x-show="quizData.questions.length === 0" class="text-center text-gray-500 p-4">
                            <p>Belum ada pertanyaan untuk kuis ini. Mulai tambahkan di atas.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Selesai -->
            <div class="flex justify-end mt-6">
                <a href="{{ route('admin.quizzes.index') }}" class="inline-flex items-center px-6 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-green-700">
                    Selesai & Kembali ke Daftar Kuis
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
