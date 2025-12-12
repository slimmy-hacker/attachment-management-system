<?php

namespace App\Http\Controllers;

use App\Imports\LecturersImport;
use App\Models\Lecturer;
use App\Models\Attachment; 
use App\Models\AttachmentStudent;
use Illuminate\Http\Request;
use App\Models\Student;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class LecturerController extends Controller
{
    /**
     * Display a list of students assigned to the logged-in lecturer.
     */
    public function index(Request $request){

        if ($request->ajax()) {
            $data = Lecturer::with(['user','department'])->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn() // adds DT_RowIndex
                ->addColumn('name', fn ($row) => $row->user->name ?? '-')
                ->addColumn('email', fn ($row) => $row->user->email ?? '-')
                ->addColumn('department', fn ($row) =>  $row->department->name ?? '-')
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-sm btn-danger delete" data-id="'.$row->id.'">Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.lecturers');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            $import = new LecturersImport();
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

   public function studentsAssigned()
{
    $students = Student::with('user')->get();

    // Load attachments for the filter dropdown
    $attachments = Attachment::all();

    return view('lecturer.my-students', compact('students', 'attachments'));
}



    /**
     * Show a single student's profile.
     */
    public function showStudent($id)
    {
        $student = Student::with('company')->findOrFail($id);

        return view('lecturer.student.show', compact('student'));
    }

    /**
     * Show reports for a specific student.
     */
    public function studentReports($id)
    {
        $student = Student::with('reports')->findOrFail($id);

        return view('lecturer.student.reports', compact('student'));
    }

    /**
     * Provide feedback for a student.
     */
    public function studentFeedback($id)
    {
        $student = Student::findOrFail($id);

        return view('lecturer.student.feedback', compact('student'));
    }

    /**
     * Show lecturer's own reports page (general, not student-specific).
     */
    public function reports()
    {
        return view('lecturer.reports');
    }

    /**
     * Show lecturer's logbook page.
     */
    public function logbook()
    {
        return view('lecturer.logbook');
    }

    /**
     * Show lecturer's evaluate page.
     */
    public function evaluate()
    {
        return view('lecturer.evaluate');
    }
   public function myStudents(Request $request)
{
     if ($request->ajax()) {
            
            $data = AttachmentStudent::with(['attachment', 'student', 'student.user']);
                if (!empty($request->attachment_id)) {
                    $data->where('attachment_id', $request->attachment_id);
                }

            return DataTables::of($data)
                ->addIndexColumn() // adds DT_RowIndex
                ->addColumn('name', function ($row) {
                    return $row->student && $row->student->user
                        ? $row->student->user->name
                        : '-';
                })
                ->addColumn('reg_no', fn ($row) =>  $row->student->reg_no ?? '-')
                ->addColumn('attachment', fn ($row) => $row->attachment->name ?? '-')
                ->addColumn('department', fn ($row) => $row->department->name ?? '-')
                ->addColumn('lecturer', fn ($row) => $row->lecturer->user->name ?? '-')
                ->addColumn('status', fn ($row) => $row->attachment->status ?? '-')
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-sm btn-danger delete" data-id="'.$row->id.'">Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    $attachments = Attachment::all();  

    return view('lecturer.my-students', compact('attachments'));
}
}
