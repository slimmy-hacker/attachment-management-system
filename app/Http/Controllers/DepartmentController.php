<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Department;
use App\Models\School;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
   public function index(Request $request)
{
    if ($request->ajax()) {

        $query = \App\Models\Department::with('school')->select('departments.*');

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('school_code', function ($row) {
                return $row->school->code ?? '-';
            })
            ->addColumn('school_name', function ($row) {
                return $row->school->name ?? '-';
            })
            ->addColumn('action', function($row){
                return '<button class="text-blue-600">Edit</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    return view('admin.departments');
}


    public function create()
    {
        $schools = School::all();
        return view('admin.departments.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'school_code' => 'required|exists:schools,code',
        ]);

        Department::create([
            'name' => $request->name,
            'school_code' => $request->school_code,
        ]);

        return redirect()->route('admin.departments')
                         ->with('success', 'Department uploaded successfully');
    }
    public function upload(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv'
    ]);

    Excel::import(new DepartmentsImport, $request->file('file'));

    return response()->json([
        'status' => 'success',
        'message' => 'Departments uploaded successfully'
    ]);
}

}
