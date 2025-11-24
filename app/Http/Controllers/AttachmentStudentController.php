<?php

namespace App\Http\Controllers;

use App\Imports\AttachmentStudentsImport;
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
            $data = AttachmentStudent::with(['attachment', 'student', 'student.user'])->latest()->get();

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

        return view('admin.attachment_students');
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

}
