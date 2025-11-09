<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🏆 {{ __('Papan Peringkat (Leaderboard)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- [TEMA BARU] Kartu Peringkat Anda Saat Ini (Hijau) -->
            <div class="bg-green-600 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-white">
                    <h3 class="text-xl font-semibold mb-4 text-green-100">Posisi Anda Saat Ini</h3>
                    <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4">

                        <!-- Peringkat -->
                        <div class="flex items-center space-x-3">
                            <svg class="h-8 w-8 text-green-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-6.75c-.621 0-1.125.504-1.125 1.125V18.75m9 0h-9" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 6.375a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm10.5 0a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-3.375 0a1.125 1.125 0 0 1-2.25 0c0-.621.504-1.125 1.125-1.125s1.125.504 1.125 1.125Z" />
                            </svg>
                            <div>
                                <span class="text-sm font-medium text-green-200">PERINGKAT</span>
                                <p class="text-3xl font-bold">#{{ $currentUserRank }}</p>
                            </div>
                        </div>

                        <!-- Skor -->
                        <div class="flex items-center space-x-3">
                            <svg class="h-8 w-8 text-green-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.31h5.518a.563.563 0 0 1 .321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.563.563 0 0 1-.84.61l-4.725-3.882a.563.563 0 0 0-.652 0L5.602 19.7a.563.563 0 0 1-.84-.61l1.285-5.386a.563.563 0 0 0-.182-.557l-4.204-3.602a.563.563 0 0 1 .321-.988H7.88a.563.563 0 0 0 .475-.31L10.48 3.5Z" />
                            </svg>
                            <div>
                                <span class="text-sm font-medium text-green-200">TOTAL SKOR</span>
                                <p class="text-3xl font-bold">{{ $currentUser->total_score }}</p>
                            </div>
                        </div>

                        <!-- Level -->
                        <div class="flex items-center space-x-3">
                             <svg class="h-8 w-8 text-green-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                            </svg>
                            <div>
                                <span class="text-sm font-medium text-green-200">LEVEL</span>
                                <p class="text-3xl font-bold">{{ $currentUser->level }}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Tabel Peringkat Teratas -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Peringkat 10 Teratas</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">
                                   
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-5/12">
                                        Nama Pengguna
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12">
                                        Level
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12">
                                        Total Skor
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($topUsers as $index => $user)
                                    <!-- [TEMA BARU] Highlight hijau untuk user saat ini -->
                                    <tr class="{{ $user->id === $currentUser->id ? 'bg-green-50' : '' }}">

                                        <!-- [TEMA BARU] Medali untuk Top 3 -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            @if($index == 0)
                                                <span class="text-lg font-bold text-yellow-500">🥇 #1</span>
                                            @elseif($index == 1)
                                                <span class="text-lg font-bold text-gray-500">🥈 #2</span>
                                            @elseif($index == 2)
                                                <span class="text-lg font-bold text-yellow-700">🥉 #3</span>
                                            @else
                                                <span class="font-medium text-gray-600">#{{ $index + 1 }}</span>
                                            @endif
                                        </td>

                                        <!-- [TEMA BARU] Menambahkan Avatar -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="shrink-0 h-8 w-8">
                                                    <img class="h-8 w-8 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=D1FAE5&color=065F46&size=32" alt="{{ $user->name }}">
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- [TEMA BARU] Menambahkan Level -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 text-sm font-medium text-green-800 bg-green-100 rounded-full">
                                                Level {{ $user->level }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                            {{ $user->total_score }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                            Belum ada data... Jadilah yang pertama!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
