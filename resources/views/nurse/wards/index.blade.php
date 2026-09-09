<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Ward Management</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if(session('success'))
                <div class="p-4 bg-green-100 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="p-4 bg-red-100 text-red-700 rounded-lg text-sm">{{ session('error') }}</div>
            @endif

            @forelse($wards as $ward)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-800">{{ $ward->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $ward->occupied_beds }} / {{ $ward->total_beds }} beds occupied</p>
                    </div>
                    <div class="flex gap-2">
                        <form method="POST" action="{{ route('nurse.wards.admit', $ward->id) }}">
                            @csrf
                            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-md text-sm font-medium">Admit</button>
                        </form>
                        <form method="POST" action="{{ route('nurse.wards.discharge', $ward->id) }}">
                            @csrf
                            <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-medium">Discharge</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center text-gray-400">
                    No wards set up yet. Contact admin.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>