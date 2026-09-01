<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">My Bills</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if(session('success'))
                <div class="p-4 bg-green-100 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="p-4 bg-red-100 text-red-700 rounded-lg text-sm">{{ session('error') }}</div>
            @endif

            @if($invoices->isEmpty())
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
                    <p class="text-gray-400 text-sm">No bills yet.</p>
                </div>
            @else
                @foreach($invoices as $invoice)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <p class="font-semibold text-gray-800">KES {{ number_format($invoice->amount, 2) }}</p>
                                <p class="text-xs text-gray-500">Due: {{ $invoice->due_date ?? 'N/A' }}</p>
                            </div>
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $invoice->status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </div>

                        @if($invoice->status !== 'paid')
                            <form method="POST" action="{{ route('patient.invoices.pay', $invoice->id) }}" class="flex gap-2 mt-3">
                                @csrf
                                <input type="text" name="phone" placeholder="e.g. 0708374149" class="flex-1 border-gray-300 rounded-md shadow-sm text-sm" required>
                                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                    Pay with M-Pesa
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            @endif

        </div>
    </div>
</x-app-layout>