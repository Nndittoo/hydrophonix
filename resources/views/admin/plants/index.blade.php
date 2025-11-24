<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🌿 {{ __('Kelola Tanaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-end mb-4">
                <a href="{{ route('admin.plants.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                    + Tambah Tanaman Baru
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanaman</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Misi</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($plants as $plant)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap flex items-center">
                                            <img src="{{ Storage::url($plant->image_url) }}" class="w-12 h-12 rounded object-cover mr-3" alt="">
                                            <div>
                                                <div class="text-sm font-bold text-gray-900">{{ $plant->name }}</div>
                                                <div class="text-xs text-gray-500">{{ Str::limit($plant->description, 50) }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">
                                                {{ $plant->missions_count }} Tahap
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                            <!-- Tombol Kelola Misi -->
                                            <a href="{{ route('admin.plants.missions.index', $plant) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-3 py-1 rounded-md">
                                                📋 Kelola Misi
                                            </a>
                                            <a href="{{ route('admin.plants.edit', $plant) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>

                                            <form action="{{ route('admin.plants.destroy', $plant) }}" method="POST" class="inline" onsubmit="return confirm('Hapus tanaman ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="px-6 py-4 text-center text-gray-500">Belum ada tanaman.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
