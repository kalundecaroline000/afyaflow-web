<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Book an Appointment
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('patient.appointments.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Select Doctor</label>
                        <select name="doctor_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Choose a doctor</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">Dr. {{ $doctor->name }}</option>
                            @endforeach
                        </select>
                        @error('doctor_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" name="appointment_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            @error('appointment_date') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Time</label>
                            <input type="time" name="appointment_time" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            @error('appointment_time') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Reason for Visit</label>
                        <textarea name="reason" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="3"></textarea>
                    </div>

                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-md font-medium">
                        Book Appointment
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>