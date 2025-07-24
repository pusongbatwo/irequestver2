<?php

namespace App\Http\Controllers;

use App\Models\DocumentRequest;
use App\Models\PersonalInformation;
use App\Models\ContactInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentConfirmationMail;

class DocumentTrackingController extends Controller
{
    public function trackDocument(Request $request)
    {
        $request->validate([
            'reference_number' => 'required|string'
        ]);

        // Get document directly from document_requests table
        $document = DocumentRequest::where('reference_number', $request->reference_number)
            ->first();

        if (!$document) {
            return back()->with('error', 'No document found with that reference number');
        }

        return redirect()->route('requester.dashboard', $document->reference_number);
    }

    public function showRequesterDashboard($reference_number)
    {
        $document = DocumentRequest::where('reference_number', $reference_number)
            ->firstOrFail();

        return view('requester.dashboard', compact('document'));
    }

    public function processPayment(Request $request)
    {
        $validated = $request->validate([
            'reference_number' => 'required|string',
            'amount_received' => 'required|numeric|min:0',
        ]);

        $documentRequest = DocumentRequest::where('reference_number', $validated['reference_number'])->first();

        if (!$documentRequest) {
            return response()->json(['success' => false, 'message' => 'Document request not found.'], 404);
        }

        // Update payment status
        $documentRequest->payment_status = 'paid';
        $documentRequest->save();

        // Send payment confirmation email
        Mail::to($documentRequest->email)->send(new PaymentConfirmationMail($documentRequest->reference_number));

        return response()->json(['success' => true, 'message' => 'Payment processed and email sent.']);
    }
}