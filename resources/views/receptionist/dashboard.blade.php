<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Receptionist Dashboard
            </h2>
            <span class="px-3 py-1 bg-pink-100 text-pink-700 text-xs font-semibold rounded-full">
                {{ auth()->user()->name }}
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Welcome banner -->
            <div class="bg-gradient-to-r from-pink-600 to-pink-800 rounded-xl shadow-lg p-6 text-white">
                <h3 class="text-xl font-bold">Welcome back, {{ explode(' ', auth()->user()->name)[0] }}</h3>
                <p class="text-pink-100 text-sm mt-1">{{ now()->format('l, F j, Y') }} — here's today's front desk overview.</p>
            </div>

            <!-- Stat cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Appointments Today</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">
                            {{ \App\Models\Appointment::whereDate('appointment_date', today())->count() }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Registered Patients</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">
                            {{ \App\Models\Patient::count() }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Pending Appointments</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">
                            {{ \App\Models\Appointment::where('status', 'pending')->count() }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Today's appointments table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Today's Appointments</h3>
                @php
                    $appointments = \App\Models\Appointment::whereDate('appointment_date', today())->latest()->take(5)->get();
                @endphp

                @if($appointments->isEmpty())
                    <p class="text-gray-400 text-sm py-8 text-center">No appointments scheduled for today.</p>
                @else
                    <table class="w-full text-sm text-left">
                        <thead class="text-gray-500 border-b">
                            <tr>
                                <th class="pb-2">Patient</th>
                                <th class="pb-2">Doctor</th>
                                <th class="pb-2">Time</th>
                                <th class="pb-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $appt)
                                <tr class="border-b last:border-0">
                                    <td class="py-3">{{ $appt->patient->user->name ?? 'N/A' }}</td>
                                    <td class="py-3">Dr. {{ $appt->doctor->name ?? 'N/A' }}</td>
                                    <td class="py-3">{{ $appt->appointment_time }}</td>
                                    <td class="py-3">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium
                                            {{ $appt->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                            {{ ucfirst($appt->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>