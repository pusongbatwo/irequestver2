<?php

namespace App\Http\Controllers;

use App\Models\DocumentRequest;
use App\Models\PersonalInformation;
use App\Models\ContactInformation;
use Illuminate\Http\Request;

class DocumentTrackingController extends Controller
{
    public function trackDocument(Request $request)
    {
        $request->validate([
            'reference_number' => 'required|string'
        ]);

        // Get document with related personal and contact information
        $document = DocumentRequest::with([
                'personalInformation',
                'personalInformation.contact'  // Changed from contactInformation to contact
            ])
            ->where('reference_number', $request->reference_number)
            ->first();

        if (!$document) {
            return back()->with('error', 'No document found with that reference number');
        }

        return redirect()->route('requester.dashboard', $document->reference_number);
    }

    public function showRequesterDashboard($reference_number)
    {
        $document = DocumentRequest::with([
                'personalInformation',
                'personalInformation.contact'  // Changed from contactInformation to contact
            ])
            ->where('reference_number', $reference_number)
            ->firstOrFail();

        return view('requester.dashboard', compact('document'));
    }
}