<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Admin Dashboard
            </h2>
            <span class="px-3 py-1 bg-gray-800 text-white text-xs font-semibold rounded-full">
                {{ auth()->user()->name }}
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Welcome banner -->
            <div class="bg-gradient-to-r from-gray-700 to-gray-900 rounded-xl shadow-lg p-6 text-white">
                <h3 class="text-xl font-bold">Welcome back, {{ explode(' ', auth()->user()->name)[0] }}</h3>
                <p class="text-gray-300 text-sm mt-1">{{ now()->format('l, F j, Y') }} — here's the system-wide overview.</p>
            </div>

            <!-- Stat cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Users</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ \App\Models\User::count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Patients</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ \App\Models\Patient::count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Appointments Today</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">
                            {{ \App\Models\Appointment::whereDate('appointment_date', today())->count() }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">
                            KES {{ number_format(\App\Models\Payment::sum('amount_paid'), 0) }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Users by role breakdown -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Staff & Users by Role</h3>
                @php
                    $roleBreakdown = \App\Models\Role::withCount('users')->get();
                @endphp
                <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                    @foreach($roleBreakdown as $role)
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <p class="text-2xl font-bold text-gray-800">{{ $role->users_count }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Recently registered users -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recently Registered</h3>
                @php
                    $recentUsers = \App\Models\User::with('role')->latest()->take(5)->get();
                @endphp

                @if($recentUsers->isEmpty())
                    <p class="text-gray-400 text-sm py-8 text-center">No users yet.</p>
                @else
                    <table class="w-full text-sm text-left">
                        <thead class="text-gray-500 border-b">
                            <tr>
                                <th class="pb-2">Name</th>
                                <th class="pb-2">Email</th>
                                <th class="pb-2">Role</th>
                                <th class="pb-2">Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentUsers as $u)
                                <tr class="border-b last:border-0">
                                    <td class="py-3">{{ $u->name }}</td>
                                    <td class="py-3">{{ $u->email }}</td>
                                    <td class="py-3">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                            {{ $u->role ? ucfirst(str_replace('_', ' ', $u->role->name)) : 'No role' }}
                                        </span>
                                    </td>
                                    <td class="py-3">{{ $u->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>