<?php

namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\IndustrialSupervisor;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Opportunity;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class IndurstrialSupervisorController extends Controller
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
                ['email' => $validated['email']],
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





    public function students()
    {
        // Get logged-in company
        $companyId = Auth::id();  // if companies log in through users table

        // Get students linked to this company through placements
        $students = Student::whereHas('placements', function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->get();

        return view('company.students', compact('students'));
    }

    public function getCompanyIndustrialSupervisors($company_id)
    {
        $supervisors = IndustrialSupervisor::with('user:id,name,phone_number,email')
            ->where('company_id', $company_id)
            ->get(['id', 'user_id']); // only select what’s needed

        return response()->json($supervisors);
    }





}
