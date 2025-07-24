<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentRequest;
use App\Models\RequestedDocument;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CashierController extends Controller
{
    public function dashboard()
    {
        $today = Carbon::today();
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();
        $fees = Config::get('services.document_fees', []);

        // Total approved requests
        $total_approved = DocumentRequest::where('status', 'approved')->count();

        // Pending payments (approved but unpaid)
        $pending_payments = DocumentRequest::where('status', 'approved')->where('payment_status', 'unpaid')->count();

        // Paid today
        $paid_today = DocumentRequest::where('payment_status', 'paid')
            ->whereDate('paid_at', $today)
            ->count();

        // Total collected in current month
        $paid_requests = DocumentRequest::where('payment_status', 'paid')
            ->whereBetween('paid_at', [$monthStart, $monthEnd])
            ->pluck('id');
        $total_collected_month = RequestedDocument::whereIn('request_id', $paid_requests)
            ->get()
            ->reduce(function($sum, $doc) use ($fees) {
                $price = $fees[$doc->document_type] ?? 0;
                return $sum + ($price * $doc->quantity);
            }, 0);

        // Document type counts (from requested_documents joined with document_requests, filtered by approved status)
        $document_type_counts = RequestedDocument::join('document_requests', 'requested_documents.request_id', '=', 'document_requests.id')
            ->where('document_requests.status', 'approved')
            ->select('requested_documents.document_type', DB::raw('SUM(requested_documents.quantity) as total'))
            ->groupBy('requested_documents.document_type')
            ->pluck('total', 'requested_documents.document_type')
            ->toArray();

        // Fetch all approved document requests with their requested documents
        $approved_requests = DocumentRequest::with('requestedDocuments')
            ->where('status', 'approved')
            ->orderByDesc('created_at')
            ->get();

        // Pass approved requests as document_requests for the management section
        $document_requests = $approved_requests;

        return view('cashier.dashboard', compact(
            'total_approved',
            'pending_payments',
            'paid_today',
            'total_collected_month',
            'document_type_counts',
            'approved_requests',
            'document_requests'
        ));
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'reference_number' => 'required|string',
            'amount_received' => 'required|numeric|min:0',
        ]);
        $docRequest = DocumentRequest::where('reference_number', $request->reference_number)->first();
        if (!$docRequest) {
            return response()->json(['success' => false, 'message' => 'Request not found.'], 404);
        }
        $docRequest->payment_status = 'paid';
        $docRequest->status = 'completed';
        $docRequest->paid_at = now();
        $docRequest->save();
        return response()->json(['success' => true]);
    }
}
