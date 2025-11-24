<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📋 Misi Tanaman: {{ $plant->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-4">
                <a href="{{ route('admin.plants.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center">
                    &larr; Kembali ke Tanaman
                </a>
                <a href="{{ route('admin.plants.missions.create', $plant) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                    + Tambah Misi Baru
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($missions->isEmpty())
                        <p class="text-center text-gray-500 py-10">Belum ada misi untuk tanaman ini. Mulai tambahkan!</p>
                    @else
                        <div class="space-y-4">
                            @foreach($missions as $mission)
                                <div class="border rounded-lg p-4 flex justify-between items-start hover:bg-gray-50">
                                    <div>
                                        <div class="flex items-center space-x-2">
                                            <span class="bg-gray-200 text-gray-700 text-xs font-bold px-2 py-1 rounded">
                                                Tahap {{ $mission->step_number }}
                                            </span>
                                            <h3 class="text-lg font-bold text-gray-800">{{ $mission->title }}</h3>
                                        </div>
                                        <p class="text-gray-600 mt-2 text-sm">{{ $mission->description }}</p>
                                        <p class="text-xs text-green-600 mt-2 font-medium">
                                            ⏱️ Durasi: {{ $mission->duration_days }} Hari
                                        </p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.plants.missions.edit', [$plant, $mission]) }}" class="text-yellow-600 hover:text-yellow-800 text-sm">Edit</a>
                                        <form action="{{ route('admin.plants.missions.destroy', [$plant, $mission]) }}" method="POST" onsubmit="return confirm('Hapus misi ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
