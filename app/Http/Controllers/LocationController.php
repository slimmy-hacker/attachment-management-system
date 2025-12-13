<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Imports\LocationsImport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Http;


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
         $locations = Location::select('code', 'name', 'level')
        ->orderBy('name', 'asc')
        ->get();

    return view('admin.locations', compact('locations'));
    }
public function create()
{
    $locations = Location::select('code', 'name')->get();

    return view('locations.create', compact('locations'));
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
   public function add(Request $request)
    {
        $validated = $request->validate([
            'code'        => 'required|string|max:255|unique:locations,code',
            'name'        => 'required|string|max:255',
            'level'       => 'required|integer|in:1,2,3',

            'parent_code' => 'nullable|exists:locations,code'
        ]);

        Location::create([
    'code'        => strtolower($validated['code']),
    'name'        => $validated['name'],
    'level'       => $validated['level'],
    'parent_code' => strtolower($validated['parent_code'] ?? null),
]);


       return response()->json([
        'status' => 'success',
        'message' => 'Location added successfully.',
    ]);
}
    function fetchCoordinatesFromExternalSource($name)
    {
        $url = "https://nominatim.openstreetmap.org/search?format=json&q=" . urlencode($name);
        $response = Http::withHeaders([
            'User-Agent' => 'MyLaravelApp/1.0 (evansowinodero@gmail.com)'
        ])->get($url, [
            'format' => 'json',
            'q' => $name
        ]);

        $data = $response->json();
        if (!empty($data)) {
            return [
                'lat' => $data[0]['lat'],
                'lng' => $data[0]['lon']
            ];
        }

        return null;
    }
    public function autoFillMissingCoordinates()
    {ini_set('max_execution_time', 300); // 300 seconds = 5 minutes

        $results = [];

        $locations = Location::whereNull('latitude')
            ->orWhereNull('longitude')
            ->get();

        foreach ($locations as $c) {
            $coords = $this->fetchCoordinatesFromExternalSource($c->name);

            if ($coords) {
                $c->latitude = $coords['lat'];
                $c->longitude = $coords['lng'];
                $c->save();

                $results[] = [
                    'level' => 1,
                    'name' => $c->name,
                    'lat' => $coords['lat'],
                    'lng' => $coords['lng']
                ];
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Locations fetched successfully!',
            'updated' => $results
        ]);
    }

}
