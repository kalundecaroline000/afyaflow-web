<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            My Medical History
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if($records->isEmpty())
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
                    <p class="text-gray-400 text-sm">No medical records yet.</p>
                </div>
            @else
                @foreach($records as $record)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-semibold text-gray-800">{{ $record->record_date }}</h3>
                            <span class="text-xs text-gray-500">Dr. {{ $record->doctor->name ?? 'Unknown' }}</span>
                        </div>

                        <p class="text-sm text-gray-700 mb-2"><span class="font-medium">Diagnosis:</span> {{ $record->diagnosis }}</p>

                        @if($record->notes)
                            <p class="text-sm text-gray-600 mb-2"><span class="font-medium">Notes:</span> {{ $record->notes }}</p>
                        @endif

                        @if($record->prescriptions->isNotEmpty())
                            <div class="mt-3 pt-3 border-t border-gray-100">
                                <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Prescriptions</p>
                                @foreach($record->prescriptions as $rx)
                                    <div class="text-sm text-gray-700 py-1">
                                        {{ $rx->medication }} — {{ $rx->dosage }}
                                        @if($rx->frequency) ({{ $rx->frequency }}) @endif
                                        @if($rx->duration_days) for {{ $rx->duration_days }} days @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            @endif

        </div>
    </div>
</x-app-layout>