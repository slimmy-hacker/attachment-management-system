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
            $data = Location::latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
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
            Excel::import(new LocationsImport, $request->file('file'));

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
