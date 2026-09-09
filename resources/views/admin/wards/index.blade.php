<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Manage Wards</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-green-100 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-4">Add New Ward</h3>
                <form method="POST" action="{{ route('admin.wards.store') }}" class="flex gap-3">
                    @csrf
                    <input type="text" name="name" placeholder="Ward name e.g. General Ward" class="flex-1 border-gray-300 rounded-md shadow-sm text-sm" required>
                    <input type="number" name="total_beds" placeholder="Total beds" class="w-32 border-gray-300 rounded-md shadow-sm text-sm" required min="1">
                    <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-md text-sm font-medium">Add Ward</button>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <table class="w-full text-sm text-left">
                    <thead class="text-gray-500 border-b">
                        <tr>
                            <th class="pb-2">Ward Name</th>
                            <th class="pb-2">Total Beds</th>
                            <th class="pb-2">Occupied</th>
                            <th class="pb-2">Available</th>
                            <th class="pb-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($wards as $ward)
                            <tr class="border-b last:border-0">
                                <td class="py-3">{{ $ward->name }}</td>
                                <td class="py-3">{{ $ward->total_beds }}</td>
                                <td class="py-3">{{ $ward->occupied_beds }}</td>
                                <td class="py-3">{{ $ward->total_beds - $ward->occupied_beds }}</td>
                                <td class="py-3">
                                    <form method="POST" action="{{ route('admin.wards.destroy', $ward->id) }}" onsubmit="return confirm('Delete this ward?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline text-xs font-medium">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-8 text-center text-gray-400">No wards yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>