<?php

namespace App\Http\Controllers;

use App\Imports\LecturersImport;
use App\Models\Lecturer;
use App\Models\Attachment;
use App\Models\AttachmentStudent;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\AttachmentAssessment;
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
         $attachment_lecturer_id = $request->session()->get('attachment_lecturer_id');
         $attachment_id= $request->session()->get('attachment_id');
            $data = AttachmentStudent::with(['attachment', 'student', 'student.user', 'industrialSupervisor.user', 'company',])
                                    ->where('lecturer_id', $attachment_lecturer_id );

            return DataTables::of($data)
                ->addIndexColumn() // adds DT_RowIndex
                ->addColumn('name', function ($row) {
                    return $row->student && $row->student->user
                        ? $row->student->user->name
                        : '-';
                })
                ->addColumn('reg_no', fn ($row) =>  $row->student->reg_no ?? '-')

                ->addColumn('department', fn ($row) => $row->department->name ?? '-')
                ->addColumn('status', fn ($row) => $row->attachment->status ?? '-')
                ->addColumn('company', fn ($row) => $row->company->name ?? '-')
                ->addColumn('industrial_supervisor', fn ($row) => $row->industrialSupervisor->user->name ?? '-')
                ->addColumn('industrial_supervisor_phone', fn ($row) => $row->industrialSupervisor->user->phone_number ?? '-')

                ->rawColumns(['action'])

                ->addColumn('action', function ($row){
               $assessment = AttachmentAssessment::where('attachment_student_id', $row->id)->first();

if ($assessment && $assessment->punctuality_marks !== null) {
    return '<button type="button" disabled class="bg-green-600 text-white font-semibold px-3 py-1 rounded cursor-not-allowed opacity-70">
                Already Assessed
            </button>';


}

            
                 
                     $name = $row->student->reg_no . ' - ' . $row->student->user->name;
                     
                    return '


                    <button
                            class="assessBtn bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700"
                            data-id="'.$row->id.'"
                            data-name="'. $name .'">
                            Assess
                        </button>
                        <a href="' . route('logbook', [$row->id]) . '"
                   class="w-auto text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center justify-center rounded-lg text-xs px-2 py-1 text-center">
                    Logbook
                </a>

                <a href="javascript:void(0)"  data-id="' . $row->id . '"
                   class="w-auto text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center justify-center rounded-lg text-xs px-2 py-1 text-center open-student_attachment_details_modal-btn">
                    Profile
                </a>
                        ';

                })
                ->rawColumns(['action'])
                ->make(true);
        }
    $attachments = Attachment::all();

    return view('lecturer.my-students', compact('attachments'));
}
}
