<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function create()
    {
        return view('receptionist.patients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'dob' => ['required', 'date'],
            'gender' => ['required', 'in:male,female,other'],
            'national_id' => ['required', 'string', 'unique:patients'],
            'phone' => ['required', 'string'],
            'address' => ['nullable', 'string'],
            'next_of_kin' => ['nullable', 'string'],
            'next_of_kin_phone' => ['nullable', 'string'],
        ]);

        $patientRole = Role::where('name', 'patient')->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password123'),
            'role_id' => $patientRole->id,
        ]);

        Patient::create([
            'user_id' => $user->id,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'national_id' => $request->national_id,
            'phone' => $request->phone,
            'address' => $request->address,
            'next_of_kin' => $request->next_of_kin,
            'next_of_kin_phone' => $request->next_of_kin_phone,
        ]);

        return redirect()->route('receptionist.dashboard')->with('success', 'Patient registered successfully. Default password: password123');
    }
}