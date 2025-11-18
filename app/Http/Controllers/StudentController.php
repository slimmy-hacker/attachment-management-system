<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Models\AttachmentLecturer;
use App\Models\AttachmentStudent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Company;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;



class StudentController extends Controller
{
public function index(Request $request){

    if ($request->ajax()) {
        $data = Student::with('user')
            ->whereHas('user')
            ->orderBy(User::select('name')->whereColumn('users.id', 'students.user_id'))
            ->get();

        return DataTables::of($data)
            ->addIndexColumn() // adds DT_RowIndex
            ->addColumn('name', fn ($row) => $row->user->name ?? '-')
            ->addColumn('email', fn ($row) => $row->user->email ?? '-')
            ->addColumn('department', fn ($row) =>  '-')
            ->addColumn('program', fn ($row) =>  '-')
          //  ->addColumn('department', fn ($row) => $row->department->slug ?? '-')
           // ->addColumn('pro', fn ($row) => $row->department->slug ?? 0)

            ->addColumn('action', function ($row) {
                return '<button class="btn btn-sm btn-danger delete" data-id="'.$row->id.'">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    return view('admin.students');
}

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls|max:2048',
        ]);

        $file = $request->file('file');

        Excel::import(new StudentsImport, $file);

        return response()->json([
            'status' => 'success',
            'message' => 'Students imported successfully',
        ]);
    }

    public function portal() {
        return view('student.portal');
    }
    public function showAttachmentForm()
    {
        $companies = Company::all();
        $logged_user = auth()->user();
        $my_student_details = Student::where('user_id', $logged_user->id)
                                        ->first();
        return view('student.attachment-form',  compact('companies',  'logged_user','my_student_details'));
    }

    public function storeAttachmentForm(Request $request)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'reg_no' => 'required|string|max:100',
            'course' => 'required|string|max:100',
            'student_phone' => 'required|string|max:20',
            'student_email' => 'required|email',

            'organization' => 'required|string|max:255',
            'date_commenced' => 'required|date',
            'date_finished' => 'required|date|after_or_equal:date_commenced',
            'town' => 'required|string|max:100',
            'street' => 'required|string|max:100',
            'building' => 'required|string|max:100',
            'supervisor_name' => 'required|string|max:255',
            'supervisor_phone' => 'required|string|max:20',
            'supervisor_email' => 'required|email',
        ]);


        return redirect()->back()->with('success', 'Attachment form submitted successfully!');
    }



public function reports()
{
    // Fetch all reports for the logged-in student
    $reports = Report::where('student_id', Auth::id())
                     ->orderBy('created_at', 'desc')
                     ->get();

    // Return the view with the reports variable
    return view('student.reports', compact('reports'));
}

  public function logbook()
   {

    return view ('student.logbook');
   }

    // Returns the full counties array (code => name)
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
        // Mombasa County
        ['code' => '0011', 'name' => 'Changamwe',   'county_code' => '001'],
        ['code' => '0012', 'name' => 'Jomvu',       'county_code' => '001'],
        ['code' => '0013', 'name' => 'Kisauni',     'county_code' => '001'],
        ['code' => '0014', 'name' => 'Likoni',      'county_code' => '001'],
        ['code' => '0015', 'name' => 'Mvita',       'county_code' => '001'],

        // Kwale County
        ['code' => '0021', 'name' => 'Msambweni',   'county_code' => '002'],
        ['code' => '0022', 'name' => 'Matuga',      'county_code' => '002'],
        ['code' => '0023', 'name' => 'Lunga Lunga', 'county_code' => '002'],
        ['code' => '0024', 'name' => 'Kinango',     'county_code' => '002'],

        // Kilifi County
        ['code' => '0031', 'name' => 'Kilifi North','county_code' => '003'],
        ['code' => '0032', 'name' => 'Kilifi South','county_code' => '003'],
        ['code' => '0033', 'name' => 'Malindi',     'county_code' => '003'],
        ['code' => '0034', 'name' => 'Rabai',       'county_code' => '003'],
        ['code' => '0035', 'name' => 'Ganze',       'county_code' => '003'],

        // Tana River County
        ['code' => '0041', 'name' => 'Garsen',      'county_code' => '004'],
        ['code' => '0042', 'name' => 'Bura',        'county_code' => '004'],
        ['code' => '0043', 'name' => 'Galole',      'county_code' => '004'],

        // Lamu County
        ['code' => '0051', 'name' => 'Lamu East',   'county_code' => '005'],
        ['code' => '0052', 'name' => 'Lamu West',   'county_code' => '005'],

        // Taita Taveta County
        ['code' => '0061', 'name' => 'Voi',         'county_code' => '006'],
        ['code' => '0062', 'name' => 'Mwatate',     'county_code' => '006'],
        ['code' => '0063', 'name' => 'Wundanyi',    'county_code' => '006'],
        ['code' => '0064', 'name' => 'Mwatate',     'county_code' => '006'],

        // Garissa County
        ['code' => '0071', 'name' => 'Garissa Township','county_code' => '007'],
        ['code' => '0072', 'name' => 'Lagdera',        'county_code' => '007'],
        ['code' => '0073', 'name' => 'Fafi',           'county_code' => '007'],
        ['code' => '0074', 'name' => 'Balambala',      'county_code' => '007'],
        ['code' => '0075', 'name' => 'Dadaab',         'county_code' => '007'],
        ['code' => '0076', 'name' => 'Ijara',          'county_code' => '007'],

        // Wajir County
        ['code' => '0081', 'name' => 'Wajir North',    'county_code' => '008'],
        ['code' => '0082', 'name' => 'Wajir West',     'county_code' => '008'],
        ['code' => '0083', 'name' => 'Wajir East',     'county_code' => '008'],
        ['code' => '0084', 'name' => 'Eldas',          'county_code' => '008'],
        ['code' => '0085', 'name' => 'Tarbaj',         'county_code' => '008'],

        // Mandera County
        ['code' => '0091', 'name' => 'Mandera East',  'county_code' => '009'],
        ['code' => '0092', 'name' => 'Mandera West',  'county_code' => '009'],
        ['code' => '0093', 'name' => 'Mandera North', 'county_code' => '009'],
        ['code' => '0094', 'name' => 'Mandera South', 'county_code' => '009'],
        ['code' => '0095', 'name' => 'Banissa',       'county_code' => '009'],
        ['code' => '0096', 'name' => 'Lafey',         'county_code' => '009'],

        // Marsabit County
        ['code' => '0101', 'name' => 'Marsabit North', 'county_code' => '010'],
        ['code' => '0102', 'name' => 'Laisamis',       'county_code' => '010'],
        ['code' => '0103', 'name' => 'North Horr',     'county_code' => '010'],
        ['code' => '0104', 'name' => 'Saku',           'county_code' => '010'],

        // Isiolo County
        ['code' => '0111', 'name' => 'Isiolo North',  'county_code' => '011'],
        ['code' => '0112', 'name' => 'Isiolo South',  'county_code' => '011'],

        // Meru County
        ['code' => '0121', 'name' => 'Igembe North',  'county_code' => '012'],
        ['code' => '0122', 'name' => 'Igembe Central','county_code' => '012'],
        ['code' => '0123', 'name' => 'Igembe South',  'county_code' => '012'],
        ['code' => '0124', 'name' => 'Tigania West',  'county_code' => '012'],
        ['code' => '0125', 'name' => 'Tigania East',  'county_code' => '012'],
        ['code' => '0126', 'name' => 'North Imenti',  'county_code' => '012'],
        ['code' => '0127', 'name' => 'Central Imenti','county_code' => '012'],
        ['code' => '0128', 'name' => 'South Imenti',  'county_code' => '012'],
// Kitui County
['code' => '0131', 'name' => 'Mwingi North', 'county_code' => '013'],
['code' => '0132', 'name' => 'Mwingi West',  'county_code' => '013'],
['code' => '0133', 'name' => 'Mwingi Central','county_code' => '013'],
['code' => '0134', 'name' => 'Kitui East',   'county_code' => '013'],
['code' => '0135', 'name' => 'Kitui Central','county_code' => '013'],
['code' => '0136', 'name' => 'Kitui West',   'county_code' => '013'],
['code' => '0137', 'name' => 'Kitui South',  'county_code' => '013'],

// Machakos County
['code' => '0141', 'name' => 'Mavoko',         'county_code' => '014'],
['code' => '0142', 'name' => 'Machakos Town', 'county_code' => '014'],
['code' => '0143', 'name' => 'Mwala',          'county_code' => '014'],
['code' => '0144', 'name' => 'Yatta',          'county_code' => '014'],
['code' => '0145', 'name' => 'Kangundo',       'county_code' => '014'],
['code' => '0146', 'name' => 'Matungulu',      'county_code' => '014'],


        ['code' => '999',  'name' => 'Diaspora', 'county_code' => '999'],
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
        $sub_counties = $this->getSubCounties();
        return view('student.companies', compact('counties',  'sub_counties'));
    }


    public function storeCompany(Request $request)
    {


        $validated = $request->validate([
            'name'    => 'required|string|max:255|unique:companies,name',
            'email'   => 'required|string|max:255|unique:companies,email',
            'alias'   => 'required|string|max:50|unique:companies,alias',
            'contact' => 'required|string|max:50|unique:companies,contact',
            'parent_company'    => 'nullable|string|max:255',
            'address'   => 'required|string|max:255',
            'county'    => ['required'],
            'subcounty'    => ['nullable'],
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
        ]);

         Company::create($validated); // if you have a model

        return response()->json([
            'status' => 'success',
            'message' => 'Company Created successfully',

        ]);
    }


}

