<?php

namespace App\Http\Controllers;

use App\Models\AttachmentSchoolSupervisor;
use App\Models\AttachmentStudent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Company;


class StudentController extends Controller
{

    public function portal() {
        return view('student.portal');
    }
    public function showAttachmentForm()
    {
        return view('student.attachment-form');
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
    return view('student.reports');
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

