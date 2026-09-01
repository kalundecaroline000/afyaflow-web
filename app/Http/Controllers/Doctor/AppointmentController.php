<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Prescription;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::where('doctor_id', auth()->id())
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('doctor.appointments.index', ['appointments' => $appointments]);
    }

    public function confirm($id)
    {
        $appointment = Appointment::where('doctor_id', auth()->id())->findOrFail($id);
        $appointment->status = 'confirmed';
        $appointment->save();

        \App\Models\Notification::create([
            'user_id' => $appointment->patient->user_id,
            'message' => 'Your appointment on ' . $appointment->appointment_date . ' has been confirmed by Dr. ' . auth()->user()->name . '.',
        ]);

        return back()->with('success', 'Appointment confirmed.');
    }

    public function showDiagnosisForm($id)
    {
        $appointment = Appointment::where('doctor_id', auth()->id())->findOrFail($id);
        return view('doctor.appointments.diagnose', ['appointment' => $appointment]);
    }

    public function storeDiagnosis(Request $request, $id)
    {
        $appointment = Appointment::where('doctor_id', auth()->id())->findOrFail($id);

        $request->validate([
            'diagnosis' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
            'medication' => ['nullable', 'string'],
            'dosage' => ['nullable', 'string'],
            'frequency' => ['nullable', 'string'],
            'duration_days' => ['nullable', 'integer'],
        ]);

        $record = MedicalRecord::create([
            'patient_id' => $appointment->patient_id,
            'doctor_id' => auth()->id(),
            'diagnosis' => $request->diagnosis,
            'notes' => $request->notes,
            'record_date' => now()->toDateString(),
        ]);

        if ($request->medication) {
            Prescription::create([
                'medical_record_id' => $record->id,
                'medication' => $request->medication,
                'dosage' => $request->dosage,
                'frequency' => $request->frequency,
                'duration_days' => $request->duration_days,
            ]);
        }

        $appointment->status = 'completed';
        $appointment->save();

        \App\Models\Notification::create([
            'user_id' => $appointment->patient->user_id,
            'message' => 'Dr. ' . auth()->user()->name . ' has added a diagnosis for your recent visit.',
        ]);

        return redirect()->route('doctor.appointments.index')->with('success', 'Diagnosis and prescription saved.');
    }
}