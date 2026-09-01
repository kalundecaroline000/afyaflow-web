<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Nurse Dashboard
            </h2>
            <span class="px-3 py-1 bg-teal-100 text-teal-700 text-xs font-semibold rounded-full">
                {{ auth()->user()->name }}
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Welcome banner -->
            <div class="bg-gradient-to-r from-teal-600 to-teal-800 rounded-xl shadow-lg p-6 text-white">
                <h3 class="text-xl font-bold">Welcome back, {{ explode(' ', auth()->user()->name)[0] }}</h3>
                <p class="text-teal-100 text-sm mt-1">{{ now()->format('l, F j, Y') }} — here's today's ward overview.</p>
<a href="{{ route('nurse.vitals.create') }}" class="inline-block mt-3 bg-white text-teal-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-teal-50">
    Record Vitals
</a>
            </div>

            <!-- Stat cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Vitals Recorded Today</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">
                            {{ \App\Models\Vital::where('nurse_id', auth()->id())->whereDate('recorded_at', today())->count() }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-teal-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h4l3 8 4-16 3 8h4" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Ward Beds</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">
                            {{ \App\Models\Ward::sum('total_beds') }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Occupied Beds</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">
                            {{ \App\Models\Ward::sum('occupied_beds') }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Recent vitals table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recently Recorded Vitals</h3>
                @php
                    $vitals = \App\Models\Vital::where('nurse_id', auth()->id())->latest()->take(5)->get();
                @endphp

                @if($vitals->isEmpty())
                    <p class="text-gray-400 text-sm py-8 text-center">No vitals recorded yet.</p>
                @else
                    <table class="w-full text-sm text-left">
                        <thead class="text-gray-500 border-b">
                            <tr>
                                <th class="pb-2">Patient</th>
                                <th class="pb-2">BP</th>
                                <th class="pb-2">Temp</th>
                                <th class="pb-2">Pulse</th>
                                <th class="pb-2">Recorded</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vitals as $vital)
                                <tr class="border-b last:border-0">
                                    <td class="py-3">{{ $vital->patient->user->name ?? 'N/A' }}</td>
                                    <td class="py-3">{{ $vital->blood_pressure ?? '-' }}</td>
                                    <td class="py-3">{{ $vital->temperature ?? '-' }}°C</td>
                                    <td class="py-3">{{ $vital->pulse ?? '-' }}</td>
                                    <td class="py-3">{{ $vital->recorded_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>