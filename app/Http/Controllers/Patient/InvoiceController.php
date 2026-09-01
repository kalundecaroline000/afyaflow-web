<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Patient;

class InvoiceController extends Controller
{
    public function index()
    {
        $patient = Patient::where('user_id', auth()->id())->first();

        $invoices = $patient
            ? Invoice::where('patient_id', $patient->id)->latest()->get()
            : collect();

        return view('patient.invoices.index', ['invoices' => $invoices]);
    }
}