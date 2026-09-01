<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Billing Dashboard
            </h2>
            <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-semibold rounded-full">
                {{ auth()->user()->name }}
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Welcome banner -->
            <div class="bg-gradient-to-r from-amber-600 to-amber-800 rounded-xl shadow-lg p-6 text-white">
                <h3 class="text-xl font-bold">Welcome back, {{ explode(' ', auth()->user()->name)[0] }}</h3>
                <p class="text-amber-100 text-sm mt-1">{{ now()->format('l, F j, Y') }} — here's today's billing overview.</p>
<a href="{{ route('billing.invoices.index') }}" class="inline-block mt-3 bg-white text-amber-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-amber-50">
    Manage Invoices
</a>
            </div>

            <!-- Stat cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Invoices Issued Today</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">
                            {{ \App\Models\Invoice::where('billing_officer_id', auth()->id())->whereDate('created_at', today())->count() }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Unpaid Invoices</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">
                            {{ \App\Models\Invoice::where('status', 'unpaid')->count() }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Collected</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">
                            KES {{ number_format(\App\Models\Payment::sum('amount_paid'), 2) }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Recent invoices table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Invoices</h3>
                @php
                    $invoices = \App\Models\Invoice::latest()->take(5)->get();
                @endphp

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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                                <tr class="border-b last:border-0">
                                    <td class="py-3">{{ $invoice->patient->user->name ?? 'N/A' }}</td>
                                    <td class="py-3">KES {{ number_format($invoice->amount, 2) }}</td>
                                    <td class="py-3">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium
                                            {{ $invoice->status === 'paid' ? 'bg-green-100 text-green-700' : ($invoice->status === 'partial' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                            {{ ucfirst($invoice->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3">{{ $invoice->due_date ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>