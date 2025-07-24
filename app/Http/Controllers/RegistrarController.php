<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\DocumentRequest;
use Illuminate\Support\Facades\DB;
use App\Models\DepartmentLogo;

use App\Mail\RequestApprovedMail;


class RegistrarController extends Controller
{
    public function storeStudent(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|string|unique:students,student_id',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'program' => 'required|string|max:255',
            'year_level' => 'required|string|max:50',
            'status' => 'required|string|max:50',
        ]);

        \App\Models\Student::create($validated);

        return redirect()->back()->with('student_added', 'Student record added successfully!');
    }

    public function registrarDashboard(Request $request)
    {
        // Dashboard summary: top 5, not paginated
        $dashboardRequests = DocumentRequest::with('requestedDocuments')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Management section: paginated
        $requests = DocumentRequest::with('requestedDocuments')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $analytics = DocumentRequest::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $defaultAnalytics = [
            'pending' => 0,
            'approved' => 0,
            'completed' => 0,
            'rejected' => 0
        ];
        $analytics = array_merge($defaultAnalytics, $analytics);

        // Load department logos from DB
        $departmentLogos = \App\Models\DepartmentLogo::all()->pluck('logo_path', 'department_name')->map(function($path) {
            return $path ? asset('storage/' . $path) : null;
        })->toArray();

        // Load students from students table, grouped by program and year_level
        $students = \App\Models\Student::all()->groupBy(['program', 'year_level']);

        return view('registrar.dashboard', compact('dashboardRequests', 'requests', 'analytics', 'departmentLogos', 'students'));
    }

    public function approve($id)
    {
        $request = DocumentRequest::findOrFail($id);

        // Example: Check if student info exists (customize as needed)
        // $studentExists = Student::where('student_id', $request->student_id)->exists();
        // if (!$studentExists) {
        //     return back()->with('error', 'Student info not found.');
        // }

        $request->status = 'approved';
        $request->save();

        // Send email
        Mail::to($request->email)->send(new RequestApprovedMail($request));

        return back()->with('success', 'Request approved and email sent.');
    }

    public function reject($id)
    {
        $request = DocumentRequest::findOrFail($id);
        $request->status = 'rejected';
        $request->save();
        return back()->with('success', 'Request rejected.');
    }

    public function pendingCount()
    {
        $pending = \App\Models\DocumentRequest::where('status', 'pending')->count();
        return response()->json(['pending' => $pending]);
    }

    // Department logo upload/update
    public function updateLogo(Request $request)
    {
        $request->validate([
            'department' => 'required|string',
            'logo' => 'required|image|max:2048',
        ]);

        $department = $request->input('department');
        $file = $request->file('logo');
        $path = $file->store('department_logos', 'public');

        $logo = DepartmentLogo::updateOrCreate(
            ['department_name' => $department],
            ['logo_path' => $path]
        );

        return response()->json([
            'success' => true,
            'logo_url' => asset('storage/' . $path),
        ]);
    }
}
