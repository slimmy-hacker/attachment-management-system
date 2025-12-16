<?php

namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\Location;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Opportunity;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
{



    public function companies(Request $request)
    {

        if ($request->ajax()) {
            $data = Company::with(['county', 'subcounty'])->orderBy('name', 'ASC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('county', fn($row) => $row->county->name ?? '-')
                ->editColumn('subcounty', fn($row) => $row->subcounty->name ?? '-')
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-sm btn-primary edit" data-id="'.$row->id.'">Edit</button>
                        <button class="btn btn-sm btn-danger delete" data-id="'.$row->id.'">Delete</button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        $counties = Location::where('level','1')
                                ->whereNotNull('latitude')
                                ->whereNotNull('longitude')
                             ->select('id','name','code')
                            ->get();
        $sub_counties = Location::where('level','2')
                                ->whereNotNull('latitude')
                                ->whereNotNull('longitude')
                                ->select('id','name','code','parent_code')
                                ->get();
        return view('companies', compact('counties',  'sub_counties'));
    }


    public function storeCompany(Request $request)
    {


        $validated = $request->validate([
            'name'    => 'required|string|max:255|unique:companies,name',
            'email'   => 'required|string|max:255|unique:users,email',
            'alias'   => 'required|string|max:50|unique:companies,alias',
            'contact' => 'required|string|max:50|unique:companies,contact',
            'parent_company'    => 'nullable|string|max:255',
            'address'   => 'required|string|max:255',
            'county_id'    => 'required|exists:locations,id',
            'sub_county_id'    => 'required|exists:locations,id',
            'latitude'    => 'nullable|string|max:255',
            'longitude'   => 'nullable|string',
            'street'    => 'nullable|string|max:255',
            'building'   => 'nullable|string',
        ]);
        DB::beginTransaction();
        try {
            $user = User::updateOrCreate(
                ['email' =>Str::lower($validated['email'])],
                [
                    'name' => $validated['name'],
                    'phone_number' => $validated['contact'],
                    'password' => Hash::make(config('app.default_password')),
                    'role' => 'company',
                ]
            );
            $validated['user_id'] = $user->id;
            Company::create($validated); // if you have a model
            DB::Commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Company Created successfully',
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


    public function portal()
    {
        return view('company.portal');
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



public function opportunities()
{
    // fetch data (use get() or paginate())
    $opportunities = Opportunity::orderBy('created_at', 'desc')->get();

    // return view and pass the variable
    return view('company.opportunities', compact('opportunities'));
    // OR: return view('opportunities', compact('opportunities')); depending on your view path
}
// Show form to create opportunity
public function createOpportunity()
{
    return view('company.create-opportunity');
}
public function storeOpportunity(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'location' => 'required|string',
        'deadline' => 'required|date',
    ]);

    Opportunity::create([
        'industry_id' => auth()->id(), // logged in company/industry
        'title' => $request->title,
        'description' => $request->description,
        'location' => $request->location,
        'deadline' => $request->deadline,
    ]);

   return response()->json([
        'status' => 'success',
        'message' => 'Opportunity created successfully.',
        'data' => $opportunity,
    ]);
}

    // 📌 Documents
    public function documents()
    {
        return view('company.documents');
    }

    // 📌 Reports
    public function reports()
    {
        return view('company.reports');
    }
    public function index()
{
    $opportunities = Opportunity::where('industry_id', auth()->id())->get();

    return view('company.opportunities', compact('opportunities'));
}
public function destroy($id)
{
    $opportunity = Opportunity::findOrFail($id);
    $opportunity->delete();

    return redirect()->route('company.opportunities')
                     ->with('success', 'Opportunity deleted successfully.');
}


public function applications(Opportunity $opportunity)
{
    if ($opportunity->industry_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    $applications = $opportunity->applications;
    return view('company.opportunities.applications', compact('opportunity', 'applications'));
}



}
