<?php

namespace App\Http\Controllers\admin;

use App\GenerateWeekNumber;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Models\User;
use App\Models\Attachment;

class AttachmentController extends Controller
{
    //
    public function index(Request $request){
        if ($request->ajax()) {

            $data = Attachment::query();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){

                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.attachments');
    }

    public function store(Request $request)
    {
        // ✅ Validate request
        $validated = $request->validate([
            'name'       => 'required|string|max:255|unique:attachments,name',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);
        // ✅ Generate slug (only lowercase letters, numbers, and dashes)
        $slug = Str::slug($validated['name'], '-');

        // Check uniqueness of slug
        if (Attachment::where('slug', $slug)->exists()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Slug already exists. Try another name.'
            ], 422);
        }
        // ✅ Generate week IDs
        $weekGen = new GenerateWeekNumber();
        $startWeekId = $weekGen->weekId($validated['start_date']);
        $endWeekId   = $weekGen->weekId($validated['end_date']);

        // ✅ Save record
        $record = Attachment::create([
            'name'          => $validated['name'],
            'slug'          => $slug,
            'start_date'    => $validated['start_date'],
            'end_date'      => $validated['end_date'],
            'start_week_id' => $startWeekId,
            'end_week_id'   => $endWeekId,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Record created successfully',
            'data'    => $record
        ]);
    }
}
