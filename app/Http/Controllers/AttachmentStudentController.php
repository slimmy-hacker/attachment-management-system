<?php

namespace App\Http\Controllers;

use App\Imports\AttachmentStudentsImport;
use App\Models\Attachment;
use App\Models\AttachmentStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class AttachmentStudentController extends Controller
{
    public function index(Request $request)
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
        $attachments = Attachment::select('id', 'name')
            ->orderBy('start_date', 'desc')
            ->get();
        return view('admin.attachment_students', compact('attachments'));
    }
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            $import = new AttachmentStudentsImport();
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
public function add(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'student_name' => 'required|string|max:255',
            'reg_no' => 'required|string|max:50|unique:attachment_students,reg_no',
            // add more validation rules if needed
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Create new student record
        $student = new AttachmentStudent();
        $student->name = $request->input('student_name');
        $student->reg_no = $request->input('reg_no');
        // set other fields as needed

        $student->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Student added successfully',
            'student' => $student,
        ]);
    }
    public function store(Request $request)
{
    $validated = $request->validate([
        'name'                  => 'required|string|max:255',
        'reg_no'                => 'required|string|max:255',
        'attachment_id'         => 'required|integer|exists:attachments,id',
        'department'            => 'required|string|max:255', // or department_id if FK
        'industrial_supervisor_id' => 'required|integer|exists:supervisors,id',
        'status'                => 'required|string|max:255',
    ]);

    $student = Student::where('reg_no', $validated['reg_no'])->first();

    if (!$student) {
        return response()->json([
            'status' => 'error',
            'message' => 'Student with registration number ' . $validated['reg_no'] . ' not found.',
        ], 404);
    }
AttachmentStudent::create([
    'student_id'    => $student->id,
    'name'          => $validated['name'],
    'reg_no'        => $validated['reg_no'],
    'attachment_id' => $validated['attachment_id'],
    'department_id' => $validated['department_id'],
    'status'        => $validated['status'],
    'industrial_supervisor_id' => $validated['industrial_supervisor_id'],
]);

    return response()->json([
        'status'  => 'success',
        'message' => 'Attachment student record created successfully.',
        'data'    => $attachmentStudent,
    ], 201);
}

}
