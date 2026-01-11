<?php

namespace App\Http\Controllers;

use App\Imports\LecturersImport;
use Illuminate\Support\Facades\Auth;
use App\Models\WeeklyReport;
use App\Models\FinalReport;
use App\Models\AttachmentLecturer;
use App\Models\AttachmentStudent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Company;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;



class StudentController extends Controller
{
public function index(Request $request){

    if ($request->ajax()) {
        $data = Student::with('user', 'program', 'program.parent')
            ->whereHas('user')
            ->orderBy(User::select('name')->whereColumn('users.id', 'students.user_id'))
            ->get();

        return DataTables::of($data)
            ->addIndexColumn() // adds DT_RowIndex
            ->addColumn('name', fn ($row) => $row->user->name ?? '-')
            ->addColumn('email', fn ($row) => $row->user->email ?? '-')
            ->addColumn('department', fn ($row) => $row->program->parent->name ??  '-')
            ->addColumn('program', fn ($row) => $row->program->name ?? '-')
           // ->addColumn('pro', fn ($row) => $row->department->slug ?? 0)

            ->addColumn('action', function ($row) {
                return '<button class="btn btn-sm btn-danger delete" data-id="'.$row->id.'">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    return view( 'admin.students');
}

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            $import = new StudentsImport();
            Excel::import($import, $request->file('file'));

            return response()->json([
                'status'        => 'success',
                'message'        => 'Upload completed',
                'success_count'  => $import->successCount,
                'fail_count'     => count($import->failedRecords),
                'failed_records' => $import->failedRecords
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function portal() {
        return view('student.portal');
    }




public function storeWeeklyReport(Request $request)
{
    $request->validate([
        'week_id' => 'required|integer|min:1|max:12',
        'weekly_report' => 'required|string',
        'week_start_date' => 'required|date',
         'week_end_date' => 'required|date|after_or_equal:week_start_date',
    ]);

    $student = Auth::user()->student;
    $attachmentStudent = $student?->attachmentStudent;

    if (!$attachmentStudent) {
        return back()->withErrors('Attachment record not found.');
    }

    // prevent duplicate week submission
    if (WeeklyReport::where([
        'attachment_student_id' => $attachmentStudent->id,
        'week_id' => $request->week_id,
    ])->exists()) {
        return back()->withErrors('This week report is already submitted.');
    }

    $filePath = $request->hasFile('report_file')
        ? $request->file('report_file')->store('reports/weekly')
        : null;

    WeeklyReport::create([
        'attachment_student_id' => $attachmentStudent->id,
        'week_id' => $request->week_id,
        'week_start_date' => $request->week_start_date,
        'week_end_date' => $request->week_end_date,
        'weekly_report' => $request->weekly_report,
                'industrial_supervisor_comment' => null, // initially null
        'lecturer_comment' => null, // initially null
        'is_approved' => false, // or 0, means not approved yet by industrial supervisor
    ]);

      
    

    return back()->with('success', 'Weekly report submitted successfully.');
}
public function weeklyReports()
{
    $user = auth()->user();

    // Determine user role however you store it (example)
    // Replace this logic with your actual role detection
  

if ($user->isStudent()) {
    $user_role = 'student';
} elseif ($user->isIndustry()) {
    $user_role = 'industry';
} elseif ($user->isUniversity()) {
    $user_role = 'university';
} elseif ($user->isAdmin()) {
    $user_role = 'admin';
} else {
    $user_role = 'guest';
}
    $student = $user->student;
    $attachmentStudent = $student ? $student->attachmentStudent : null;

    $weeklyReports = $attachmentStudent
        ? $attachmentStudent->weeklyReports()->orderBy('week_id')->get()
        : collect();

    return view('student.weekly-reports', compact('weeklyReports', 'user_role'));
}

public function storeFinalReport(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'final_report_file' => 'required|file|mimes:pdf,doc,docx|max:10240',
    ]);

    $student = Auth::user()->student;

    if (!$student) {
        return back()->withErrors('Student profile not found.');
    }

    $attachmentStudent = $student->attachmentStudent;

    if (!$attachmentStudent) {
        return back()->withErrors('Attachment record not found.');
    }
if (FinalReport::where([
    'attachment_student_id' => $attachmentStudent->id,
    
])->exists()) {
    return back()->withErrors('Final report with the same content already submitted by you.');
}
    $path = $request->file('final_report_file')->store('reports/final');

    FinalReport::create([
        'attachment_student_id' => $attachmentStudent->id,
        'title' => $request->title,
        'content' => $request->content,
        'file_path' => $path,
        'is_submitted' => true,
    ]);

    return redirect()->back()->with('success', 'Final report submitted successfully.');
}


    // ===============================
    // SHOW FINAL REPORT PAGE (GET)
    // ===============================
    public function finalReport()
{
    $user = Auth::user();

    // 1️⃣ Get student linked to user
    $student = $user->student;

    if (!$student) {
        return redirect()->route('student.dashboard')
            ->withErrors('Student profile not found.');
    }

    // 2️⃣ Get attachment using student_id
    $attachmentStudent = $student->attachmentStudent;

    if (!$attachmentStudent) {
        return redirect()->route('student.dashboard')
            ->withErrors('Please complete attachment registration first.');
    }

    // 3️⃣ Get final report
    $finalReport = FinalReport::where(
        'attachment_student_id',
        $attachmentStudent->id
    )->first();

    return view('student.final-report', compact('finalReport'));
}
}