<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Imports\LocationsImport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class LocationController extends Controller
{
    // Show all locations
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Location::orderBy('level', 'asc')
                            -> orderBy('name', 'asc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('parent_name', function ($row) {
                    return $row->parent->name ?? '—-';
                })
                ->addColumn('level_name', function ($row) {
                    $names = [
                        1 => 'County',
                        2 => 'Subcounty',
                        3 => 'Ward',
                    ];

                    return $names[$row->level] ?? 'Unknown';
                })

                ->filterColumn('level_name', function ($query, $keyword) {
                    $map = [
                        'county'     => 1,
                        'sub county' => 2,
                        'ward'       => 3,
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

        return view('admin.locations');
    }

    // Upload Excel file
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            $import = new LocationsImport;
            Excel::import($import, $request->file('file'));
            if ($import->failures()->isNotEmpty()) {
                return response()->json([
                    'errors_import' => $import->failures()
                ]);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Locations uploaded successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error uploading file: ' . $e->getMessage(),
            ], 500);
        }
    }
}
