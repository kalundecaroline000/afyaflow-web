<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Add Diagnosis — {{ $appointment->patient->user->name ?? 'Patient' }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <form method="POST" action="{{ route('doctor.appointments.diagnose.store', $appointment->id) }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Diagnosis</label>
                        <textarea name="diagnosis" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="3" required></textarea>
                        @error('diagnosis') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea name="notes" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="2"></textarea>
                    </div>

                    <hr class="my-4">
                    <h3 class="text-sm font-semibold text-gray-700">Prescription (optional)</h3>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Medication</label>
                        <input type="text" name="medication" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Dosage</label>
                            <input type="text" name="dosage" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="e.g. 500mg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Frequency</label>
                            <input type="text" name="frequency" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="e.g. 2x daily">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Duration (days)</label>
                            <input type="number" name="duration_days" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium">
                        Save & Complete Appointment
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>