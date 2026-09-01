<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function create()
    {
        $doctorRole = Role::where('name', 'doctor')->first();
        $doctors = User::where('role_id', $doctorRole->id)->get();

        return view('patient.appointments.create', ['doctors' => $doctors]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => ['required', 'exists:users,id'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => ['required'],
            'reason' => ['nullable', 'string'],
        ]);

        $patient = Patient::where('user_id', auth()->id())->first();

        if (!$patient) {
            return back()->with('error', 'Your patient profile is not set up yet. Please contact reception.');
        }

        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => 'pending',
            'reason' => $request->reason,
        ]);

        return redirect()->route('patient.dashboard')->with('success', 'Appointment booked successfully! Awaiting confirmation.');
    }
}