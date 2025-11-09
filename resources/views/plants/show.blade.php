<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail: {{ $plant->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 md:flex md:space-x-6">
                    <div class="md:w-1/3">
                        <img src="{{ asset('storage/' . $plant->image_url) }}" alt="{{ $plant->name }}" class="rounded-lg w-full object-cover shadow-md">
                        <form action="{{ route('user-plants.store', $plant->id) }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit" class="w-full px-6 py-3 bg-green-600 text-white rounded-md text-lg font-semibold hover:bg-green-700">
                                Mulai Tanam {{ $plant->name }}
                            </button>
                        </form>
                    </div>

                    <div class="md:w-2/3 mt-6 md:mt-0">
                        <h3 class="text-2xl font-bold">{{ $plant->name }}</h3>
                        <p class="text-gray-600 mt-2">{{ $plant->description }}</p>

                        <h4 class="text-xl font-semibold mt-8 mb-4 border-b pb-2">Rancangan Misi</h4>
                        <ul class="space-y-3">
                            @forelse ($plant->missions as $mission)
                                <li class="flex items-start space-x-3">
                                    <div class="flex-shrink-0 bg-blue-500 text-white rounded-full h-8 w-8 flex items-center justify-center font-bold">
                                        {{ $mission->step_number }}
                                    </div>
                                    <div>
                                        <h5 class="font-semibold">{{ $mission->title }} (Estimasi: {{ $mission->duration_days }} hari)</h5>
                                        <p class="text-sm text-gray-600">{{ $mission->description }}</p>
                                    </div>
                                </li>
                            @empty
                                <p>Misi untuk tanaman ini belum diatur.</p>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
