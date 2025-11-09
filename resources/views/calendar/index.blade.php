<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🗓️ {{ __('Kalender Monitoring Tanaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Kolom Kiri: Kalender -->
            <div class="lg:col-span-2">
                <!-- Kartu Hero (Header Kalender) -->
                <div class="bg-green-600 overflow-hidden shadow-sm sm:rounded-t-lg">
                    <div class="p-6 text-white flex items-center space-x-4">
                        <svg class="h-12 w-12 text-green-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                        <div>
                            <h3 class="text-2xl font-semibold">Jadwal Misi Anda</h3>
                            <p class="text-green-100 mt-1">
                                Klik pada misi di kalender untuk melihat detailnya.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Kartu Kalender -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-b-lg">
                    <div class="p-4 sm:p-6 text-gray-900">
                        <div id="calendar" class="h-[70vh] min-h-[500px]"></div>
                    </div>
                </div>
            </div>

            <!-- [KARTU DIPERBARUI] Kolom Kanan: Misi Sedang Berjalan (dengan ID) -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- [BARU] ID ditambahkan ke wrapper ini -->
                    <div class="p-6 text-gray-900" id="sidebar-card">

                        <h4 class="text-lg font-semibold mb-4" id="sidebar-header">Misi Berjalan</h4>

                        @if ($activePlant)
                            <div>
                                <img src="{{ asset('storage/' . $activePlant->plant->image_url) }}"
                                     alt="{{ $activePlant->plant->name }}"
                                     class="w-full h-40 object-cover rounded-lg shadow-md mb-4"
                                     id="sidebar-image">

                                <h3 class="text-2xl font-bold text-green-600" id="sidebar-plant-name">
                                    {{ $activePlant->plant->name }}
                                </h3>

                                <div class="mt-4 pt-4 border-t">
                                    <span class="text-sm text-gray-500" id="sidebar-step">
                                        Tahap {{ $activePlant->currentMission->step_number }}:
                                    </span>
                                    <h5 class="text-lg font-semibold" id="sidebar-title">
                                        {{ $activePlant->currentMission->title }}
                                    </h5>
                                    <p class="text-sm text-gray-600 mt-1" id="sidebar-description">
                                        {{ $activePlant->currentMission->description }}
                                    </p>
                                </div>

                                <!-- Logika Progress Misi -->
                                <div class="mt-4" id="sidebar-status-box">
                                    @php
                                        $mission = $activePlant->currentMission;
                                        $exactSecondsRemaining = $activePlant->mission_started_at->addDays($mission->duration_days)->timestamp - now()->timestamp;
                                        $daysRemainingFloat = $exactSecondsRemaining / 86400;
                                        $daysRemaining = floor($daysRemainingFloat);
                                        $isReady = $daysRemainingFloat <= 0;
                                    @endphp
                                    @if ($isReady)
                                        <p class="text-green-600 font-semibold">
                                            🎉 Misi siap diselesaikan!
                                        </p>
                                    @else
                                        <p class="text-sm text-gray-500">Sisa waktu misi ini:</p>
                                        <p class="text-2xl font-bold text-yellow-600">{{ $daysRemaining }} hari lagi</p>
                                    @endif
                                </div>

                                <a href="{{ route('user-plants.index') }}"
                                   class="inline-block text-center w-full mt-4 px-6 py-2 bg-green-600 text-white rounded-md text-sm font-semibold hover:bg-green-700 shadow-sm"
                                   id="sidebar-action-button">
                                    Lihat Detail Misi
                                </a>
                            </div>
                        @else
                            <!-- Tampilan jika tidak ada tanaman aktif -->
                            <div class="text-center p-4 border-2 border-dashed rounded-lg">
                                <p class="text-gray-500 mb-3">Tidak ada misi yang sedang berjalan.</p>
                                <a href="{{ route('plants.index') }}" class="inline-block px-5 py-2 bg-green-600 text-white rounded-md text-sm font-semibold hover:bg-green-700 shadow-sm">
                                    Mulai Tanam
                                </a>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- [SCRIPT DIPERBARUI] dengan eventClick -->
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.11/main.global.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.11/main.global.min.js"></script>

        <script>
        var calendarEl = document.getElementById('calendar');

        if (calendarEl) {
            if (typeof FullCalendar !== 'undefined') {
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    plugins: [ 'dayGrid' ],
                    initialView: 'dayGridMonth',
                    height: '100%',

                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: ''
                    },

                    events: '{{ route("calendar.events") }}',

                    // Warna default (untuk misi mendatang)
                    eventColor: '#16A34A',
                    eventBackgroundColor: '#16A34A',
                    eventBorderColor: '#16A34A',

                    // [BARU] Fungsi klik event
                    eventClick: function(info) {
                        info.jsEvent.preventDefault(); // Mencegah browser mengikuti URL (jika ada)

                        // Ambil data kustom yang kita kirim dari controller
                        let data = info.event.extendedProps;
                        let title = info.event.title;
                        let start = info.event.start;

                        // Target elemen-elemen di sidebar
                        let card = document.getElementById('sidebar-card');
                        if (!card) return; // Keluar jika sidebar tidak ada

                        // Update konten sidebar
                        document.getElementById('sidebar-image').src = data.image_url;
                        document.getElementById('sidebar-plant-name').innerHTML = data.plant_name;
                        document.getElementById('sidebar-step').innerHTML = `Tahap ${data.step_number}:`;
                        document.getElementById('sidebar-title').innerHTML = title;
                        document.getElementById('sidebar-description').innerHTML = data.description;

                        // Target tombol dan status box
                        let statusBox = document.getElementById('sidebar-status-box');
                        let actionButton = document.getElementById('sidebar-action-button');
                        let header = document.getElementById('sidebar-header');

                        if (data.is_active) {
                            // Jika misi yang diklik adalah misi aktif
                            header.innerHTML = 'Misi Sedang Berjalan';

                            // Ambil timer dari PHP (karena kita tidak bisa hitung ulang di JS tanpa data asli)
                            // Solusi mudah: Tampilkan pesan "Aktif"
                            statusBox.innerHTML = `
                                <p class="text-sm text-gray-500">Status Misi:</p>
                                <p class="text-2xl font-bold text-green-600">Sedang Berjalan</p>
                            `;

                            // Atur tombol
                            actionButton.innerHTML = 'Lihat Detail Misi';
                            actionButton.href = '{{ route("user-plants.index") }}';
                            actionButton.classList.remove('bg-gray-400', 'cursor-not-allowed', 'hover:bg-gray-400');
                            actionButton.classList.add('bg-green-600', 'hover:bg-green-700');

                        } else {
                            // Jika misi yang diklik adalah misi mendatang
                            header.innerHTML = 'Detail Misi Mendatang';

                            // Tampilkan tanggal mulai
                            statusBox.innerHTML = `
                                <p class="text-sm text-gray-500">Akan dimulai pada:</p>
                                <p class="text-2xl font-bold text-gray-700">
                                    ${start.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}
                                </p>
                            `;

                            // Nonaktifkan tombol
                            actionButton.innerHTML = 'Misi Mendatang';
                            actionButton.href = '#';
                            actionButton.classList.remove('bg-green-600', 'hover:bg-green-700');
                            actionButton.classList.add('bg-gray-400', 'cursor-not-allowed', 'hover:bg-gray-400');
                        }
                    }
                });

                calendar.render();
            } else {
                console.error("Error: Library FullCalendar gagal dimuat.");
                calendarEl.innerHTML = '<p class="text-center text-red-500">Gagal memuat kalender. Periksa konsol (F12) untuk detail error.</p>';
            }
        } else {
            console.error("Error: Elemen dengan ID 'calendar' tidak ditemukan.");
        }
        </script>
    @endpush
</x-app-layout>
