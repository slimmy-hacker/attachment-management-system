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

    private function getCounties(): array
    {
        return [
            '001' => 'Mombasa',
            '002' => 'Kwale',
            '003' => 'Kilifi',
            '004' => 'Tana River',
            '005' => 'Lamu',
            '006' => 'Taita-Taveta',
            '007' => 'Garissa',
            '008' => 'Wajir',
            '009' => 'Mandera',
            '010' => 'Marsabit',
            '011' => 'Isiolo',
            '012' => 'Meru',
            '013' => 'Tharaka-Nithi',
            '014' => 'Embu',
            '015' => 'Kitui',
            '016' => 'Machakos',
            '017' => 'Makueni',
            '018' => 'Nyandarua',
            '019' => 'Nyeri',
            '020' => 'Kirinyaga',
            '021' => "Murang'a",
            '022' => 'Kiambu',
            '023' => 'Turkana',
            '024' => 'West Pokot',
            '025' => 'Samburu',
            '026' => 'Trans Nzoia',
            '027' => 'Uasin Gishu',
            '028' => 'Elgeyo-Marakwet',
            '029' => 'Nandi',
            '030' => 'Baringo',
            '031' => 'Laikipia',
            '032' => 'Nakuru',
            '033' => 'Narok',
            '034' => 'Kajiado',
            '035' => 'Kericho',
            '036' => 'Bomet',
            '037' => 'Kakamega',
            '038' => 'Vihiga',
            '039' => 'Bungoma',
            '040' => 'Busia',
            '041' => 'Siaya',
            '042' => 'Kisumu',
            '043' => 'Homa Bay',
            '044' => 'Migori',
            '045' => 'Kisii',
            '046' => 'Nyamira',
            '047' => 'Nairobi',
        ];
    }

    private function getSubCounties(): array
    {
        return [
            ['code' => '0011', 'name' => 'Changamwe',   'county_code' => '001'],
            ['code' => '0012', 'name' => 'Jomvu',       'county_code' => '001'],
            ['code' => '0013', 'name' => 'Kisauni',     'county_code' => '001'],
            ['code' => '0021', 'name' => 'Msambweni',   'county_code' => '002'],
            ['code' => '0022', 'name' => 'Matuga',      'county_code' => '002'],
            ['code' => '0031', 'name' => 'Kilifi North','county_code' => '003'],
            // ...
            ['code' => '999', 'name' => 'Diaspora', 'county_code' => '999'], // Special
        ];
    }

    public function companies(Request $request)
    {
        if ($request->ajax()) {
            $data = Company::with(['county', 'subcounty'])->latest();

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

        $counties = $this->getCounties();
        $counties = Location::where('level','1')
                             ->select('id','name','code')
                            ->get();
        $sub_counties = Location::where('level','2')
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
            'county'    => ['required'],
            'subcounty'    => ['nullable'],
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
                    'password' => Hash::make(1212),
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
        'location' => 'nullable|string',
        'deadline' => 'nullable|date',
    ]);

    Opportunity::create([
        'industry_id' => auth()->id(), // logged in company/industry
        'title' => $request->title,
        'description' => $request->description,
        'location' => $request->location,
        'deadline' => $request->deadline,
    ]);

    return back()->with('success', 'Opportunity created successfully.');
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
