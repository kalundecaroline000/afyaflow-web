<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">All Invoices</h2>
            <a href="{{ route('billing.invoices.create') }}" class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                + New Invoice
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if($invoices->isEmpty())
                    <p class="text-gray-400 text-sm py-8 text-center">No invoices yet.</p>
                @else
                    <table class="w-full text-sm text-left">
                        <thead class="text-gray-500 border-b">
                            <tr>
                                <th class="pb-2">Patient</th>
                                <th class="pb-2">Amount</th>
                                <th class="pb-2">Status</th>
                                <th class="pb-2">Due Date</th>
                                <th class="pb-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                                <tr class="border-b last:border-0">
                                    <td class="py-3">{{ $invoice->patient->user->name ?? 'N/A' }}</td>
                                    <td class="py-3">KES {{ number_format($invoice->amount, 2) }}</td>
                                    <td class="py-3">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium
                                            {{ $invoice->status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ ucfirst($invoice->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3">{{ $invoice->due_date ?? '-' }}</td>
                                    <td class="py-3">
                                        @if($invoice->status !== 'paid')
                                            <form method="POST" action="{{ route('billing.invoices.markPaid', $invoice->id) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:underline text-xs font-medium">Mark Paid</button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-xs">Paid</span>
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