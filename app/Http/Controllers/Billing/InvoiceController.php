<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Patient;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::latest()->get();
        return view('billing.invoices.index', ['invoices' => $invoices]);
    }

    public function create()
    {
        $patients = Patient::with('user')->get();
        return view('billing.invoices.create', ['patients' => $patients]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'due_date' => ['nullable', 'date'],
        ]);

        Invoice::create([
            'patient_id' => $request->patient_id,
            'billing_officer_id' => auth()->id(),
            'amount' => $request->amount,
            'status' => 'unpaid',
            'due_date' => $request->due_date,
        ]);
\App\Models\Notification::create([
    'user_id' => \App\Models\Patient::find($request->patient_id)->user_id,
    'message' => 'A new invoice of KES ' . number_format($request->amount, 2) . ' has been issued to your account.',
]);

        return redirect()->route('billing.invoices.index')->with('success', 'Invoice created successfully.');
    }

    public function markPaid($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->status = 'paid';
        $invoice->save();

        \App\Models\Payment::create([
            'invoice_id' => $invoice->id,
            'amount_paid' => $invoice->amount,
            'method' => 'cash',
            'payment_date' => now()->toDateString(),
        ]);

        return back()->with('success', 'Invoice marked as paid.');
    }
}