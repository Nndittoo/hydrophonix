<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- 4 Kartu Statistik (K-Cards) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Total Pengguna -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex items-center space-x-4">
                        <div class="flex-shrink-0 bg-green-100 rounded-full p-3">
                            <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0-6.04-1.637M6.96 7.127a9.38 9.38 0 0 1 10.08 0M19.912 12A8.967 8.967 0 0 1 12 20.917a8.967 8.967 0 0 1-7.912-8.917A8.967 8.967 0 0 1 12 3.083a8.967 8.967 0 0 1 7.912 8.917Z" /></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase">Total Pengguna</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalUsers }}</p>
                        </div>
                    </div>
                </div>
                <!-- Total Modul -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex items-center space-x-4">
                        <div class="flex-shrink-0 bg-green-100 rounded-full p-3">
                            <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18c-2.305 0-4.408.867-6 2.292m0-14.25v14.25" /></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase">Total Modul</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalModules }}</p>
                        </div>
                    </div>
                </div>
                <!-- Total Tanaman -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex items-center space-x-4">
                        <div class="flex-shrink-0 bg-green-100 rounded-full p-3">
                            <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-1.5 5.231 5.231m0 0a.563.563 0 0 1 .53 0l2.121 2.121.53.53a.563.563 0 0 1 0 .792l-2.121 2.121a.563.563 0 0 1-.792 0l-2.121-2.121a.563.563 0 0 1 0-.792l.53-.53Z" /></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase">Total Tanaman</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalPlants }}</p>
                        </div>
                    </div>
                </div>
                <!-- Misi Aktif -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex items-center space-x-4">
                        <div class="flex-shrink-0 bg-green-100 rounded-full p-3">
                            <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" /></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase">Misi Aktif</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalActiveMissions }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grid Utama (Chart & Statistik Samping) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Kolom Kiri: Chart -->
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h4 class="text-lg font-semibold mb-4">Pendaftaran User Baru (12 Bulan Terakhir)</h4>
                        <div class="h-72">
                            <canvas id="userChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Statistik Gamifikasi -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Skor Tertinggi -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h4 class="text-lg font-semibold mb-3">Skor Tertinggi</h4>
                            @if($highestScorer)
                                <div class="flex items-center space-x-3">
                                    <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($highestScorer->name) }}&background=D1FAE5&color=065F46&size=64" alt="">
                                    <div>
                                        <p class="font-semibold text-green-600">{{ $highestScorer->name }}</p>
                                        <p class="text-xl font-bold">{{ $highestScorer->total_score }} Poin</p>
                                    </div>
                                </div>
                            @else
                                <p class="text-gray-500">Belum ada skor.</p>
                            @endif
                        </div>
                    </div>
                    <!-- Statistik Lain -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h4 class="text-lg font-semibold mb-4">Statistik Konten</h4>
                            <ul class="space-y-3">
                                <li class="flex justify-between items-center">
                                    <span class="text-gray-600">Total Kuis</span>
                                    <span class="font-bold text-lg">{{ $totalQuizzes }}</span>
                                </li>
                                <li class="flex justify-between items-center">
                                    <span class="text-gray-600">Tanaman Dipanen</span>
                                    <span class="font-bold text-lg">{{ $totalCompletedMissions }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Aktivitas Terbaru -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                 <div class="p-6 text-gray-900">
                    <h4 class="text-lg font-semibold mb-4">Aktivitas Kuis Terbaru</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pengguna</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kuis</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Skor</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($recentQuizAttempts as $attempt)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $attempt->user->name ?? 'User Dihapus' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $attempt->quiz->title ?? 'Kuis Dihapus' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold {{ $attempt->score == 100 ? 'text-yellow-500' : 'text-green-600' }}">{{ $attempt->score }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $attempt->created_at->diffForHumans() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada aktivitas kuis.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                 </div>
            </div>

        </div>
    </div>

    <!-- [PERBAIKAN JAVASCRIPT] Script untuk Chart.js -->
    @push('scripts')
        <!-- 1. Load Chart.js dari CDN -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- 2. Inisialisasi Chart -->
        <script>
            const chartLabels = @json($chartLabels);
            const chartData = @json($chartData);

            var ctx = document.getElementById('userChart');

            if (ctx && typeof Chart !== 'undefined') {
                new Chart(ctx.getContext('2d'), {
                    type: 'line', // Tipe chart: line
                    data: {
                        labels: chartLabels, // Data dari Controller
                        datasets: [{
                            label: 'User Baru',
                            data: chartData, // Data dari Controller
                            fill: true,
                            backgroundColor: 'rgba(22, 163, 74, 0.1)', // Warna area (hijau muda)
                            borderColor: 'rgb(22, 163, 74)', // Warna garis (hijau)
                            tension: 0.3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    // Pastikan hanya angka bulat di sumbu Y
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            } else if (!ctx) {
                console.error("Error: Elemen canvas #userChart tidak ditemukan.");
            } else {
                console.error("Error: Library Chart.js gagal dimuat.");
            }
        </script>
    @endpush
</x-app-layout>
