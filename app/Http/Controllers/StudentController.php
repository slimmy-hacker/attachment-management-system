<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Report;
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
        $data = Student::with('user')
            ->whereHas('user')
            ->orderBy(User::select('name')->whereColumn('users.id', 'students.user_id'))
            ->get();

        return DataTables::of($data)
            ->addIndexColumn() // adds DT_RowIndex
            ->addColumn('name', fn ($row) => $row->user->name ?? '-')
            ->addColumn('email', fn ($row) => $row->user->email ?? '-')
            ->addColumn('department', fn ($row) =>  '-')
            ->addColumn('program', fn ($row) =>  '-')
          //  ->addColumn('department', fn ($row) => $row->department->slug ?? '-')
           // ->addColumn('pro', fn ($row) => $row->department->slug ?? 0)

            ->addColumn('action', function ($row) {
                return '<button class="btn btn-sm btn-danger delete" data-id="'.$row->id.'">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    return view('admin.students');
}

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls|max:2048',
        ]);

        $file = $request->file('file');

        Excel::import(new StudentsImport, $file);

        return response()->json([
            'status' => 'success',
            'message' => 'Students imported successfully',
        ]);
    }

    public function portal() {
        return view('student.portal');
    }






public function reports()
{
    // Fetch all reports for the logged-in student
    $reports = Report::where('student_id', Auth::id())
                     ->orderBy('created_at', 'desc')
                     ->get();

    // Return the view with the reports variable
    return view('student.reports', compact('reports'));
}

  public function logbook()
   {

    return view ('student.logbook');
   }




}

