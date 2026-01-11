<?php

namespace App\Http\Controllers;
use App\Models\Attachment;
use App\Models\WeeklyReport;
use App\Models\AttachmentStudent;
use App\Models\Company;
use App\Models\IndustrialSupervisor;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Opportunity;
use App\Models\AttachmentAssessment;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class IndustrialSupervisorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = IndustrialSupervisor::with(['user',])->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', fn($row) => $row->user->name ?? '-')
                ->addColumn('email', fn($row) => $row->user->email ?? '-')
                ->addColumn('phone_number', fn($row) => $row->user->phone_number ?? '-')
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-sm btn-primary edit" data-id="'.$row->id.'">Edit</button>
                        <button class="btn btn-sm btn-danger delete" data-id="'.$row->id.'">Delete</button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        return view('company.indurstrial_supervisors');
    }


    public function store(Request $request)
    {
        $user_company = Company::where('user_id', Auth::id())->first();
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|string|max:255|unique:users,email',
            'phone_number' => 'nullable|string|max:50|unique:users,phone_number',
            'staff_number' => [
                'nullable',
                Rule::unique('industrial_supervisors')->where(fn ($query) =>
                $query->where('company_id', $user_company->id)
                ),
            ],
            'position_title'   => 'required|string',
        ]);
        DB::beginTransaction();
        try {
            $user = User::updateOrCreate(
                ['email' => strtolower($validated['email'])],
                [
                    'name' => $validated['name'],
                    'phone_number' => $validated['phone_number'],
                    'password' => Hash::make(config('app.default_password')),
                    'role' => 'industrial_supervisor',
                ]
            );

            IndustrialSupervisor::create([ 
                'user_id' => $user->id,
                'company_id' => $user_company->id,
                'staff_number' => Str::upper($validated['staff_number']),
                'position_title' => $validated['position_title'],
                'phone_alt' => $validated['phone_number'],
            ]); // if you have a model
            DB::Commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Supervisor Created successfully',
            ]);

        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Company Creation Failed',
                'error' => $e->getMessage(),
            ]);
        }

    }



    public function attaches(Request $request)
{
    if ($request->ajax()) {

    $attachment_id = $request->session()->get('attachment_id');
    $industrial_supervisor_id = IndustrialSupervisor::where('user_id', Auth::id())->first()->id;
    $data = AttachmentStudent::with(['attachment', 'student', 'student.user'])
        ->where('attachment_id', $attachment_id)
        ->where('industrial_supervisor_id', $industrial_supervisor_id)
    ;
    return DataTables::of($data)
        ->addIndexColumn()
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
    $supervisorId = request()->session()->get('industrial_supervisor_id');

$assessment = AttachmentAssessment::where('attachment_student_id', $row->id)
    ->where('industrial_supervisor_id', $supervisorId)
    ->first();

if ($assessment && $assessment->punctuality_marks !== null) {
    return '<button type="button" disabled class="bg-green-600 text-white font-semibold px-3 py-1 rounded cursor-not-allowed opacity-70">
                Already Assessed 
            </button>';
}

    
            return '
            <div class="flex space-x-2">
                <button
            type="button"
            class="assessBtn text-white bg-green-600 hover:bg-green-700
                   focus:ring-4 focus:ring-green-200 rounded-lg text-xs px-2 py-1"
            data-id="'.$row->id.'"
            data-name="'.$row->student->user->name.'">
            Assess
        </button>
               <a href="' . route('logbook', [$row->id]) . '"
                   class="w-auto text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center justify-center rounded-lg text-xs px-2 py-1 text-center">
                    Logbook
                </a>

                <a href="javascript:void(0)"  data-id="' . $row->id . '"
                   class="w-auto text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center justify-center rounded-lg text-xs px-2 py-1 text-center open-student_attachment_details_modal-btn">
                    Profile
                </a>

            </div>
            ';
        })
        ->rawColumns(['action'])
        ->make(true);
}

    return view('industrial_supervisor.attaches');
}




    public function getCompanyIndustrialSupervisors($company_id)
    {
        $supervisors = IndustrialSupervisor::with('user:id,name,phone_number,email')
            ->where('company_id', $company_id)
            ->get(['id', 'user_id']); // only select what’s needed

        return response()->json($supervisors);
    }

public function weeklyReports()
{
    $industrialSupervisor = auth()->user();

    if ($industrialSupervisor->role !== 'industrial_supervisor') {
        abort(403);
    }

    $weeklyReports = WeeklyReport::whereHas('attachmentStudent', function ($q) use ($industrialSupervisor) {
        $q->where('industrial_supervisor_id', $industrialSupervisor->id);
    })->orderBy('week_id')->get();

    return view('industrial_supervisor.weekly-reports', compact('weeklyReports'))
           ->with('user_role', 'industrial_supervisor');
}
public function update(Request $request, WeeklyReport $report)
{
    $request->validate([
        'industrial_supervisor_comment' => 'required|string',
        'is_approved' => 'nullable|boolean',
    ]);

    // Authorization check: the report must belong to the industrial supervisor
    if ($report->attachmentStudent->industrial_supervisor_id !== auth()->id()) {
        abort(403);
    }

    $report->update([
        'industrial_supervisor_comment' => $request->industrial_supervisor_comment,
        'is_approved' => $request->has('is_approved'),
    ]);

    return back()->with('success', 'Comment and approval updated successfully.');
}




}
