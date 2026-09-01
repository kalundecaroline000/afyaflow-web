<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                My Dashboard
            </h2>
            <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-semibold rounded-full">
                {{ auth()->user()->name }}
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Welcome banner -->
            <div class="bg-gradient-to-r from-purple-600 to-purple-800 rounded-xl shadow-lg p-6 text-white">
                <h3 class="text-xl font-bold">Welcome back, {{ explode(' ', auth()->user()->name)[0] }}</h3>
                <p class="text-purple-100 text-sm mt-1">{{ now()->format('l, F j, Y') }} — here's your health summary.</p>
            </div>
<div>
    <a href="{{ route('patient.appointments.create') }}" class="inline-block bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md text-sm font-medium">
        + Book New Appointment
    </a>
</div>

            @php
                $patient = \App\Models\Patient::where('user_id', auth()->id())->first();
            @endphp

            @if(!$patient)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
                    <p class="text-gray-500">Your patient profile hasn't been set up yet. Please contact reception.</p>
                </div>
            @else
                <!-- Stat cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Upcoming Appointments</p>
                            <p class="text-3xl font-bold text-gray-800 mt-1">
                                {{ \App\Models\Appointment::where('patient_id', $patient->id)->where('appointment_date', '>=', today())->count() }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Medical Records</p>
                            <p class="text-3xl font-bold text-gray-800 mt-1">
                                {{ \App\Models\MedicalRecord::where('patient_id', $patient->id)->count() }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Unpaid Bills</p>
                            <p class="text-3xl font-bold text-gray-800 mt-1">
                                {{ \App\Models\Invoice::where('patient_id', $patient->id)->where('status', '!=', 'paid')->count() }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Upcoming appointments table -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">My Appointments</h3>
                    @php
                        $appointments = \App\Models\Appointment::where('patient_id', $patient->id)->latest()->take(5)->get();
                    @endphp

                    @if($appointments->isEmpty())
                        <p class="text-gray-400 text-sm py-8 text-center">No appointments booked yet.</p>
                    @else
                        <table class="w-full text-sm text-left">
                            <thead class="text-gray-500 border-b">
                                <tr>
                                    <th class="pb-2">Doctor</th>
                                    <th class="pb-2">Date</th>
                                    <th class="pb-2">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointments as $appt)
                                    <tr class="border-b last:border-0">
                                        <td class="py-3">Dr. {{ $appt->doctor->name ?? 'N/A' }}</td>
                                        <td class="py-3">{{ $appt->appointment_date }}</td>
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
            @endif

        </div>
    </div>
</x-app-layout>