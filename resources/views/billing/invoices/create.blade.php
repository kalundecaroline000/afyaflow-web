<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">New Invoice</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <form method="POST" action="{{ route('billing.invoices.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Patient</label>
                        <select name="patient_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Select patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->user->name ?? 'Unknown' }}</option>
                            @endforeach
                        </select>
                        @error('patient_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Amount (KES)</label>
                        <input type="number" step="0.01" name="amount" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        @error('amount') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Due Date</label>
                        <input type="date" name="due_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-2 rounded-md font-medium">
                        Create Invoice
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>