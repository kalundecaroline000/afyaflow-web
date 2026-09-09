@php
    $roleName = auth()->user()->role->name ?? null;
@endphp

<aside class="w-64 bg-white border-r border-gray-100 min-h-screen hidden md:block">
    <div class="p-6">
        <a href="/" class="flex items-center gap-2">
            <x-application-logo class="h-8 w-auto text-gray-800" />
            <span class="font-bold text-gray-800">AfyaFlow</span>
        </a>
    </div>

    <nav class="px-4 space-y-1">
        @if($roleName === 'doctor')
            <a href="{{ route('doctor.dashboard') }}" class="block px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('doctor.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }}">Dashboard</a>
            <a href="{{ route('doctor.appointments.index') }}" class="block px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('doctor.appointments.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }}">My Appointments</a>
        @elseif($roleName === 'patient')
            <a href="{{ route('patient.dashboard') }}" class="block px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('patient.dashboard') ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-50' }}">Dashboard</a>
            <a href="{{ route('patient.appointments.create') }}" class="block px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('patient.appointments.*') ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-50' }}">Book Appointment</a>
            <a href="{{ route('patient.records.index') }}" class="block px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('patient.records.*') ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-50' }}">Medical History</a>
            <a href="{{ route('patient.invoices.index') }}" class="block px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('patient.invoices.*') ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-50' }}">My Bills</a>
        @elseif($roleName === 'nurse')
            <a href="{{ route('nurse.dashboard') }}" class="block px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('nurse.dashboard') ? 'bg-teal-100 text-teal-700' : 'text-gray-600 hover:bg-gray-50' }}">Dashboard</a>
            <a href="{{ route('nurse.vitals.create') }}" class="block px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('nurse.vitals.*') ? 'bg-teal-100 text-teal-700' : 'text-gray-600 hover:bg-gray-50' }}">Record Vitals</a>
        @elseif($roleName === 'billing_officer')
            <a href="{{ route('billing.dashboard') }}" class="block px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('billing.dashboard') ? 'bg-amber-100 text-amber-700' : 'text-gray-600 hover:bg-gray-50' }}">Dashboard</a>
            <a href="{{ route('billing.invoices.index') }}" class="block px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('billing.invoices.*') ? 'bg-amber-100 text-amber-700' : 'text-gray-600 hover:bg-gray-50' }}">Invoices</a>
        @elseif($roleName === 'receptionist')
            <a href="{{ route('receptionist.dashboard') }}" class="block px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('receptionist.dashboard') ? 'bg-pink-100 text-pink-700' : 'text-gray-600 hover:bg-gray-50' }}">Dashboard</a>
            <a href="{{ route('receptionist.patients.create') }}" class="block px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('receptionist.patients.*') ? 'bg-pink-100 text-pink-700' : 'text-gray-600 hover:bg-gray-50' }}">Register Patient</a>
        @elseif($roleName === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-gray-200 text-gray-800' : 'text-gray-600 hover:bg-gray-50' }}">Dashboard</a>
            <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'bg-gray-200 text-gray-800' : 'text-gray-600 hover:bg-gray-50' }}">Manage Users</a>
        @endif

        @php
            $notifications = auth()->user()->notifications()->latest()->take(5)->get();
            $unreadCount = auth()->user()->notifications()->where('is_read', false)->count();
        @endphp

        <div class="pt-4 mt-4 border-t border-gray-100">
            <div class="flex items-center justify-between px-4 mb-2">
                <p class="text-xs font-semibold text-gray-400 uppercase">
                    Notifications @if($unreadCount > 0) <span class="ml-1 px-2 py-0.5 bg-red-500 text-white rounded-full text-xs">{{ $unreadCount }}</span> @endif
                </p>
                @if($unreadCount > 0)
                    <form method="POST" action="{{ route('notifications.readAll') }}">
                        @csrf
                        <button type="submit" class="text-xs text-blue-600 hover:underline">Mark all read</button>
                    </form>
                @endif
            </div>

            @forelse($notifications as $note)
                <form method="POST" action="{{ route('notifications.read', $note->id) }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-xs {{ $note->is_read ? 'text-gray-400' : 'text-gray-700 font-medium hover:bg-gray-50' }} rounded-md">
                        {{ $note->message }}
                    </button>
                </form>
            @empty
                <p class="px-4 text-xs text-gray-400">No notifications yet.</p>
            @endforelse
        </div>

        <div class="pt-4 mt-4 border-t border-gray-100">
            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 rounded-md text-sm font-medium text-gray-600 hover:bg-gray-50">Profile</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left block px-4 py-2 rounded-md text-sm font-medium text-red-600 hover:bg-red-50">Log Out</button>
            </form>
        </div>
    </nav>
</aside>