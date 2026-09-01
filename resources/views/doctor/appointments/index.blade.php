<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            My Appointments
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if($appointments->isEmpty())
                    <p class="text-gray-400 text-sm py-8 text-center">No appointments yet.</p>
                @else
                    <table class="w-full text-sm text-left">
                        <thead class="text-gray-500 border-b">
                            <tr>
                                <th class="pb-2">Patient</th>
                                <th class="pb-2">Date</th>
                                <th class="pb-2">Time</th>
                                <th class="pb-2">Status</th>
                                <th class="pb-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $appt)
                                <tr class="border-b last:border-0">
                                    <td class="py-3">{{ $appt->patient->user->name ?? 'N/A' }}</td>
                                    <td class="py-3">{{ $appt->appointment_date }}</td>
                                    <td class="py-3">{{ $appt->appointment_time }}</td>
                                    <td class="py-3">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium
                                            {{ $appt->status === 'completed' ? 'bg-green-100 text-green-700' : ($appt->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700') }}">
                                            {{ ucfirst($appt->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3 space-x-2">
                                        @if($appt->status === 'pending')
                                            <form method="POST" action="{{ route('doctor.appointments.confirm', $appt->id) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-blue-600 hover:underline text-xs font-medium">Confirm</button>
                                            </form>
                                        @endif
                                        @if($appt->status === 'confirmed')
                                            <a href="{{ route('doctor.appointments.diagnose', $appt->id) }}" class="text-green-600 hover:underline text-xs font-medium">Add Diagnosis</a>
                                        @endif
                                        @if($appt->status === 'completed')
                                            <span class="text-gray-400 text-xs">Done</span>
                                        @endif
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