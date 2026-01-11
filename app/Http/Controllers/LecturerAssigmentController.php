<?php

namespace App\Http\Controllers;

use App\Models\AdministrativeUnit;
use App\Models\Attachment;
use App\Models\AttachmentLecturer;
use App\Models\AttachmentStudent;
use App\Models\LecturerAssigment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\Facades\DataTables;

class LecturerAssigmentController extends Controller
{
    public function index(Request $request)
    {
        

        if ($request->ajax()) {
            $data = AttachmentStudent::whereNotNull('company_id')
            ->with([
                'attachment',
                'student',
                'student.user',
                'student.program.parent',
                'attachment_lecturer.lecturer.user',
                'company'
            ]);

            if (!empty($request->attachment_id)) {
                $data->where('attachment_id', $request->attachment_id);
            }

            if (!empty($request->department_id)) {
                $data->whereHas('student.program.parent', function ($q) use ($request) {
                    $q->where('id', $request->department_id);
                });
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
                ->addColumn('lecturer', fn ($row) => $row->attachment_lecturer->lecturer->user->name ?? '-')
                ->addColumn('status', fn ($row) => $row->attachment->status ?? '-')
                ->addColumn('company', fn ($row) => $row->company->name ?? '-')
                ->addColumn('subcounty', fn ($row) => $row->company->subcounty->name ?? '-')
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-sm btn-danger delete" data-id="'.$row->id.'">Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $attachments = Attachment::select('id', 'name')
            ->orderBy('start_date', 'desc')
            ->get();
        $departments = AdministrativeUnit::where('level', 2)->get();

        return view('admin.lecturer_assignment', compact('attachments','departments'));
    }
    function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
       
        $earthRadius = 6371; // KM

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon/2) * sin($dLon/2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
    function clusterStudents($students, $lecturers)
    {
        $k = $lecturers->count();

        if ($k === 0 || $students->isEmpty()) {
            return collect();
        }

        $centroids = $students->shuffle()->take($k)->values();
  
        for ($iteration = 0; $iteration < 10; $iteration++) {

            // Reset clusters (Collection of Collections)
            $clusters = collect(range(0, $k - 1))
                ->map(fn () => collect());

            // Step 2: assign students to nearest centroid
            foreach ($students as $student) {
                $minDistance = INF;
                $clusterIndex = 0;

                foreach ($centroids as $i => $centroid) {
                    $distance = $this->haversineDistance(
                        $student->lat,
                        $student->lng,
                        $centroid->lat,
                        $centroid->lng
                    );

                    if ($distance < $minDistance) {
                        $minDistance = $distance;
                        $clusterIndex = $i;
                    }
                }

                $clusters[$clusterIndex]->push($student);
            }

            // Step 3: recalculate centroids
            $centroids = $clusters->map(function ($cluster, $i) use ($centroids) {
                if ($cluster->isEmpty()) {
                    // Keep previous centroid if cluster is empty
                    return $centroids[$i];
                }

                return (object)[
                    'lat' => $cluster->avg('lat'),
                    'lng' => $cluster->avg('lng'),
                ];
            })->values();
        }

        // Step 4: assign lecturer per cluster
        $result = collect();
       

        foreach ($clusters as $i => $cluster) {
            foreach ($cluster as $student) {
                $result->push([
                    'student_id' => $student->id,
                    'lecturer_id' => $lecturers[$i]->id,
                ]);
            }
        }

        return $result;
    }


    public function generateDraft(Request $request)
    {
      
        $request->validate([
            'department_id' => 'required|exists:administrative_units,id',
            'attachment_id' => 'required|exists:attachments,id',
        ]);
        $students = AttachmentStudent::with('company', 'student.program.parent')
            ->whereNotNull('company_id')
            ->whereHas('student.program.parent', function ($q) use ($request) {
                $q->where('id', $request->department_id);
            })            ->where('attachment_id', $request->attachment_id)
            ->get();
            if($students->isEmpty()){
                return response()->json([
                    'status' => 'error',
                    'message' => 'No Students with attachment form Found'
                ]);
            }
        $students  =$students ->map(function ($s) {
                $s->lat = $s->company->subcounty->latitude;
                $s->lng = $s->company->subcounty->longitude;
                return $s;
            });
        $lecturers = AttachmentLecturer::where([
            'attachment_id'=> $request->attachment_id,
            'department_id' => $request->department_id
        ])->get();
        if($lecturers->isEmpty()){
            return response()->json([
                'status' => 'error',
                'message' => 'No Lecturers assigned for this attachment and department. '
            ]);
        }

        $clusters = $this->clusterStudents($students, $lecturers);

        DB::transaction(function () use ($clusters, $request, $students) {
          $prev_assigment = LecturerAssigment::where([
                'attachment_id' => $request->attachment_id,
                'department_id' => $request->department_id
            ])->orderBy('batch','desc')
              ->first();
$batch = 1;
if ($prev_assigment) {
    $batch = $prev_assigment->batch + 1;
}
            foreach ($clusters as $row) {
                $student = $students->firstWhere('id', $row['student_id']);
              AttachmentStudent::find($row['student_id'])->update([
                  'lecturer_id' => $row['lecturer_id'],
              ]);
                LecturerAssigment::create([
                    'attachment_id' => $request->attachment_id,
                    'department_id' => $request->department_id,
                    'attachment_student_id' => $row['student_id'],
                    'attachment_lecturer_id' => $row['lecturer_id'],
                    'company_id' => $student->company_id,
                    'latitude' => $student->lat,
                    'longitude' => $student->lng,
                    'created_by' => auth()->id(),
                    'batch' => $batch,
                ]);
            }
        });

        return response()->json(['status' => 'success']);
    }
    public function updateLecturer(Request $request, $id)
    {
        LecturerAssigment::findOrFail($id)
            ->update(['lecturer_id' => $request->lecturer_id]);

        return response()->json(['status' => 'updated']);
    }
    public function finalize(Request $request)
    {
        LecturerAssigment::where([
            'attachment_period_id' => $request->attachment_period_id,
            'department_id' => $request->department_id
        ])->update(['is_final' => true]);
    }


}
