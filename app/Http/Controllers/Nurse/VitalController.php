<?php

namespace App\Http\Controllers\Nurse;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Vital;
use Illuminate\Http\Request;

class VitalController extends Controller
{
    public function create()
    {
        $patients = Patient::with('user')->get();
        return view('nurse.vitals.create', ['patients' => $patients]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'blood_pressure' => ['nullable', 'string'],
            'temperature' => ['nullable', 'numeric'],
            'pulse' => ['nullable', 'integer'],
            'weight' => ['nullable', 'numeric'],
        ]);

        Vital::create([
            'patient_id' => $request->patient_id,
            'nurse_id' => auth()->id(),
            'blood_pressure' => $request->blood_pressure,
            'temperature' => $request->temperature,
            'pulse' => $request->pulse,
            'weight' => $request->weight,
            'recorded_at' => now(),
        ]);

        return redirect()->route('nurse.dashboard')->with('success', 'Vitals recorded successfully.');
    }
}