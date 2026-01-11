<?php

namespace App\Http\Controllers;

use App\Imports\AttachmentLecturersImport;
use App\Models\Attachment;
use App\Models\Lecturer;
use App\Models\AdministrativeUnit;
use Illuminate\Http\Request;
use App\Models\AttachmentLecturer;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;


class AttachmentLecturerController extends Controller
{

    public function index(Request $request)
{
    if ($request->ajax()) {
        $data = AttachmentLecturer::with(['attachment', 'lecturer.user', 'department']);

        if (!empty($request->attachment_id)) {
            $data->where('attachment_id', $request->attachment_id);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('name', fn ($row) => $row->lecturer->user->name ?? '-')
            ->addColumn('staff_no', fn ($row) => $row->lecturer->staff_number ?? '-')
             ->addColumn('job_grade', fn ($row) => $row->job_grade ?? '-')
            ->addColumn('attachment', fn ($row) => $row->attachment->name ?? '-')
            ->addColumn('department', fn ($row) => $row->department->name ?? '-')
            ->addColumn('students', fn ($row) => $row->department->slug ?? 0)
            ->addColumn('action', function ($row) {
                return '<button class="btn btn-sm btn-danger delete" data-id="'.$row->id.'">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // 💡 FIX: load required data
    $attachments = Attachment::orderBy('start_date', 'desc')->get();
    $lecturers   = Lecturer::with('user')->orderBy('staff_number')->get();
    $departments = AdministrativeUnit::where('level', 2)->orderBy('name')->get();

    return view('admin.attachment_lecturers', compact('attachments', 'lecturers', 'departments'));
}

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);
        try {
            $import = new AttachmentLecturersImport();
            Excel::import($import, $request->file('file'));

            return response()->json([
                'status' => 'success',
                'message' => 'File processed',
                'stats' => [
                    'success_count' => $import->successCount,
                    'fail_count' => count($import->failedRecords),
                    'failed_records' => $import->failedRecords
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error uploading file: ' . $e->getMessage(),
            ], 500);
        }
    }
public function store(Request $request)
{
    $validated = $request->validate([
        'name'            => 'required|string|max:255',
        'staff_no'        => 'required|string|max:255',
        'job_grade'        => 'required|string|max:255',
        'attachment'      => 'required|string|max:255',
        'department'      => 'required|string|max:255',
        'students'        => 'required|integer',
    ]);

    $record = AttachmentLecturer::create([
        'name'            => $request->name,
        'staff_no'        => $request->staff_no,
        'job_grade'        => $request->job_grade,
        'attachment'      => $request->attachment,
        'department'      => $request->department,
        'students'        => $request->students,
    ]);

    return response()->json([
        'status'  => 'success',
        'message' => 'Record stored successfully.',
        'data'    => $record,
    ], 201);
}

    public function add(Request $request)
    {
        $validated = $request->validate([
            'lecturer_id' => 'required|exists:lecturers,id',
            'attachment_id' => 'required|exists:attachments,id',
            'department_id' => 'required|exists:administrative_units,id',
        ]);

        // Check if already exists
        $exists = AttachmentLecturer::where('lecturer_id', $validated['lecturer_id'])
            ->where('attachment_id', $validated['attachment_id'])
            ->where('department_id', $validated['department_id'])
            ->first();

        if ($exists) {
            return back()->withErrors([
                'duplicate' => 'This record already exists in the system.',
            ])->withInput();
        }

        AttachmentLecturer::create([
            'lecturer_id' => $validated['lecturer_id'],
            'attachment_id' => $validated['attachment_id'],
            'department_id' => $validated['department_id'],
        ]);

        return response()->json([
                'status' => 'success',
                'message' => 'File processed',
    
                
            ]);
}  

}
