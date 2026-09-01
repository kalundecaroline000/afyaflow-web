<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Patient;
use App\Services\MpesaService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function pay(Request $request, $invoiceId, MpesaService $mpesa)
    {
        $request->validate([
            'phone' => ['required', 'string'],
        ]);

        $patient = Patient::where('user_id', auth()->id())->first();
        $invoice = Invoice::where('patient_id', $patient->id)->findOrFail($invoiceId);

        $phone = preg_replace('/^0/', '254', $request->phone);

        $result = $mpesa->stkPush(
            $phone,
            $invoice->amount,
            'INV' . $invoice->id,
            'AfyaFlow Invoice Payment'
        );

        if (isset($result['ResponseCode']) && $result['ResponseCode'] === '0') {
            return back()->with('success', 'Payment prompt sent to your phone. Enter your M-Pesa PIN to complete.');
        }

        return back()->with('error', $result['errorMessage'] ?? 'Payment request failed. Please try again.');
    }

    public function callback(Request $request)
    {
        $data = $request->all();

        $resultCode = $data['Body']['stkCallback']['ResultCode'] ?? null;
        $accountRef = null;
        $amount = null;

        if ($resultCode === 0) {
            $items = $data['Body']['stkCallback']['CallbackMetadata']['Item'] ?? [];
            foreach ($items as $item) {
                if ($item['Name'] === 'Amount') $amount = $item['Value'];
            }

            // Match by amount + most recent unpaid invoice as a simple approach for sandbox testing
            $invoice = Invoice::where('status', 'unpaid')->where('amount', $amount)->latest()->first();

            if ($invoice) {
                $invoice->status = 'paid';
                $invoice->save();

                \App\Models\Payment::create([
                    'invoice_id' => $invoice->id,
                    'amount_paid' => $amount,
                    'method' => 'mpesa',
                    'payment_date' => now()->toDateString(),
                ]);

                \App\Models\Notification::create([
                    'user_id' => $invoice->patient->user_id,
                    'message' => 'Your M-Pesa payment of KES ' . number_format($amount, 2) . ' was received successfully.',
                ]);
            }
        }

        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Accepted']);
    }
}