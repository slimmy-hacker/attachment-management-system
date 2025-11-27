<?php

namespace App\Http\Controllers;

use App\Imports\AttachmentLecturersImport;
use Illuminate\Http\Request;
use App\Models\AttachmentLecturer;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class AttachmentLecturerController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AttachmentLecturer::with(['attachment', 'lecturer.user','department'])->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn() // adds DT_RowIndex
                ->addColumn('name', fn ($row) => $row->lecturer->user->name ?? '-')// adds DT_RowIndex
                ->addColumn('staff_no', fn ($row) => $row->lecturer->staff_number ?? '-')
                ->addColumn('attachment', fn ($row) => $row->attachment->name ?? '-')
                ->addColumn('department', fn ($row) => $row->department->slug ?? '-')
                ->addColumn('students', fn ($row) => $row->department->slug ?? 0)
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-sm btn-danger delete" data-id="'.$row->id.'">Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.attachment_lecturers');
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

}
