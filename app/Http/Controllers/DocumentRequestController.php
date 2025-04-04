<?php

namespace App\Http\Controllers;

use App\Models\DocumentRequest;
use App\Models\PersonalInformation;
use App\Models\ContactInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\DocumentRequestSubmitted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DocumentRequestController extends Controller
{
    public function index()
    {
        $requests = DocumentRequest::with(['personalInfo', 'contactInfo'])
            ->where('status', 'Pending')
            ->get();
        return view('request-form', compact('requests'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|string|max:50',
            'course' => 'required|string|max:100',
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'province' => 'required|string|max:50',
            'city' => 'required|string|max:50',
            'barangay' => 'required|string|max:50',
            'mobile' => 'nullable|string|max:20',
            'email' => 'required|email|max:50',
            'document_type' => 'required|string',
            'purpose' => 'nullable|string',
            'special_instructions' => 'nullable|string',
        ]);

        $duplicateRequest = DocumentRequest::where('student_id', $validated['student_id'])
            ->where('document_type', $validated['document_type'])
            ->where('status', 'Pending')
            ->exists();

        if ($duplicateRequest) {
            return back()->with('error', 'You already have a pending request for this document.');
        }

        DB::beginTransaction();

        try {
            $personalInfo = PersonalInformation::updateOrCreate(
                ['student_id' => $validated['student_id']],
                [
                    'first_name' => $validated['first_name'],
                    'middle_name' => $validated['middle_name'],
                    'last_name' => $validated['last_name'],
                    'course' => $validated['course'],
                ]
            );

            $contactInfo = ContactInformation::updateOrCreate(
                ['student_id' => $validated['student_id']],
                [
                    'province' => $validated['province'],
                    'city' => $validated['city'],
                    'barangay' => $validated['barangay'],
                    'mobile' => $validated['mobile'],
                    'email' => $validated['email'],
                ]
            );

            $documentRequest = DocumentRequest::create([
                'student_id' => $validated['student_id'],
                'document_type' => $validated['document_type'],
                'purpose' => $validated['purpose'],
                'special_instructions' => $validated['special_instructions'],
                'reference_number' => 'REQ-' . Str::upper(Str::random(10)),
                'status' => 'Pending',
                'payment_status' => 'Unpaid',
            ]);

            DB::commit();

            Mail::to($documentRequest->contactInfo->email)->send(
                new DocumentRequestSubmitted($documentRequest)
            );

            return view('emails/document_request_submitted', compact('documentRequest'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to submit request: ' . $e->getMessage());
        }
    }

    public function success($reference)
    {
        return view('request-success', [
            'reference' => $reference,
        ]);
    }

    public function track(Request $request)
    {
        $request->validate([
            'reference_number' => 'required|string',
        ]);

        $document = DocumentRequest::with(['personalInfo', 'contactInfo'])
            ->where('reference_number', $request->reference_number)
            ->first();

        if (!$document) {
            return back()->with('error', 'No document found with that reference number');
        }

        return view('track-result', [
            'document' => $document,
        ]);
    }

    public function dashboard()
    {
        $requests = DocumentRequest::join('personal_information', 'document_request.student_id', '=', 'personal_information.student_id')
            ->select('document_request.request_id', 'personal_information.first_name', 'personal_information.last_name', 'document_request.document_type', 'document_request.date_requested', 'document_request.status')
            ->get();

        $analytics = DocumentRequest::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $defaultAnalytics = ['pending' => 0, 'processing' => 0, 'completed' => 0, 'rejected' => 0];
        $analytics = array_merge($defaultAnalytics, $analytics);

        return view('registrar.dashboard', compact('requests', 'analytics'));
    }
}