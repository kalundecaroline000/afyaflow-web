<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Models\Patient;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $patient = Patient::where('user_id', auth()->id())->first();

        if (!$patient) {
            return view('patient.records.index', ['records' => collect()]);
        }

        $records = MedicalRecord::where('patient_id', $patient->id)
            ->with(['doctor', 'prescriptions'])
            ->latest('record_date')
            ->get();

        return view('patient.records.index', ['records' => $records]);
    }
}