<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdministrativeUnit;
use App\Imports\AdministrativeUnitsImport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class AdministrativeUnitController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AdministrativeUnit::orderBy('level', 'asc')
                            -> orderBy('name', 'asc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('parent_name', function ($row) {
                    return $row->parent->name ?? '—-';
                })
                ->addColumn('level_name', function ($row) {
                    $names = [
                        1 =>'School',
                        2=> 'Department',
                        3 => 'course',
                    ];

                    return $names[$row->level] ?? 'Unknown';
                })

                ->filterColumn('level_name', function ($query, $keyword) {
                    $map = [
                        1 =>'School',
                        2=> 'Department',
                        3 => 'course',
                    ];

                    $keyword = strtolower($keyword);

                    // If keyword matches name → convert to level number
                    if (isset($map[$keyword])) {
                        $query->where('level', $map[$keyword]);
                    } else {
                        // If user types a number (1,2,3)
                        if (is_numeric($keyword)) {
                            $query->where('level', intval($keyword));
                        }
                    }
                })

                ->addColumn('action', function ($row) {
                    return '<button class="text-blue-600 hover:underline">View</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $admin_units=AdministrativeUnit::orderBy('name')->get();


        return view('admin.administrative-units',compact('admin_units'));
    }

    // Upload Excel file
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            $import = new AdministrativeUnitsImport;
            Excel::import($import, $request->file('file'));
            if ($import->failures()->isNotEmpty()) {
                return response()->json([
                    'errors_import' => $import->failures()
                ]);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Administrative units uploaded successfully!',
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
    $request->validate([
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:50|unique:administrative_units,code',
       'parent_code' => [
            'string',
            'exists:administrative_units,code',
            'nullable',
            'required_if:level,!=,1'
        ],
        'level' => 'required|integer|min:1',
    ]);

    AdministrativeUnit::create([
        'name' => $request->name,
        'code' => $request->code,
        'parent_code' => $request->parent_code,
        'level' => $request->level,
    ]);
  

    return response()->json([
        'status' => 'success',
        'message' => 'Administrative unit added successfully.',
    ]);
}


}
