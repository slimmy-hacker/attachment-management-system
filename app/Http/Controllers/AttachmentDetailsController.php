<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\User;
use App\Models\Attachment;
use App\Models\AttachmentStudent;
use App\Models\Company;
use App\Models\Location;
use App\Models\DailyReport;
use App\Models\Student;
use App\Models\WeeklyReport;
use Illuminate\Http\Request;

class AttachmentDetailsController extends Controller
{public function edit(Request $req)
{   
    $attachment_student_id = $req->session()->get('attachment_student_id');
$attachment_student = AttachmentStudent::find($attachment_student_id);


$companies = Company::with('town')->get();


$logged_user = auth()->user();
$my_student_details = Student::with('program')
                            ->where('user_id', $logged_user->id)
                            ->first();

$counties = Location::where('level', 1)->get();


$towns = Location::where('level', 3)->get();

if ($attachment_student->company_id) {
    return view('student.form-submitted', compact('attachment_student_id'));
}


return view('student.attachment-form', compact(
    'companies', 'logged_user', 'my_student_details', 'attachment_student','attachment_student_id', 'counties', 'towns'
));



$logged_user = auth()->user();
$my_student_details = Student::with('program')
                            ->where('user_id', $logged_user->id)
                            ->first();

$counties = Location::where('level', 1)->orderBy('name', 'asc')->get();
$towns = Location::where('level', 3)->orderBy('name', 'asc')->get();

if ($attachment_student->company_id) {
    return view('student.form-submitted', compact('attachment_student_id'));
}


return view('student.attachment-form', compact(
    'companies', 'logged_user', 'my_student_details', 'attachment_student', 'counties', 'towns'
));
}

    public function update(Request $request)
{
    $attachment_id = $request->session()->get('attachment_id');
    $attachment = Attachment::findOrFail($attachment_id);

    $validated = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email', 
        'student_phone' => 'required', 
        'supervisor_email' => 'required|email',
        'supervisor_phone' => 'required',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
    ]);

    
    auth()->user()->update([
        'phone_number' => $request->student_phone
    ]);

    
    $companyUser = User::updateOrCreate(
        ['email' => $request->email],
        [
            'name' => $request->name,
            'role' => 'company', 
            'password' => bcrypt('company123'), 
        ]
    );

   
    $company = Company::updateOrCreate(
        ['email' => $request->email],
        [
            'name' => $request->name,
            'alias' => $request->alias,
            'contact' => $request->contact,
            'address' => $request->address,
            'county_id' => $request->county_id,
            'town_id' => $request->town_id,
            'user_id' => $companyUser->id, 
            'street' => $request->street ?? 'N/A',
            'building' => $request->building ?? 'N/A',
        ]
    );

    
    $supervisorUser = \App\Models\User::updateOrCreate(
        ['email' => $request->supervisor_email],
        [
            'name' => $request->supervisor_name,
            'phone_number' => $request->supervisor_phone,
            'role' => 'industrial_supervisor', 
            'password' => bcrypt('password123'),
        ]
    );

   
    $supervisorProfile = \App\Models\IndustrialSupervisor::updateOrCreate(
        ['user_id' => $supervisorUser->id],
        [
            'company_id' => $company->id,
            'position_title' => 'Industrial Supervisor',
        ]
    );

   $attachment_student_id = $request->session()->get('attachment_student_id');

if (!$attachment_student_id) {
    return redirect()->back()->with('error', 'Session expired. Please refresh the page.');
}
    \App\Models\AttachmentStudent::where('id', $attachment_student_id)
        ->update([
            'company_id' => $company->id,
            'industrial_supervisor_id' => $supervisorProfile->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

    return redirect()->back()->with([
        'notification' => [
            'icon' => 'success',
            'title' => 'Success',
            'message' => 'Accounts created and details updated!'
        ]
    ]);
}
public function show($id)
{
    $data = AttachmentStudent::with([
        'student.user',
        'student.program',
        'company.town',
        'industrialSupervisor.user',
        'attachment',
        'attachmentLecturer.lecturer.user'  
    ])->findOrFail($id);

    return response()->json($data);
}
 public function import(Request $request)
{
       ini_set('max_execution_time', 0);

$request->validate([
    'file' => 'required|mimes:csv,txt,xlsx,xls'
]);

try {
    $dataRows = Excel::toCollection(
        new class implements WithHeadingRow {
            public function headingRow(): int { return 1; }
        },
        $request->file('file')
    )->first();

    // Get attachment from the first row (assuming all rows have same attachment)
    $firstRow = $dataRows->first();
    $attachmentSlug = trim(data_get($firstRow, 'attachment_slug'));
    
    $attachment = null;
    
    if ($attachmentSlug) {
        // Find by slug if provided
        $attachment = Attachment::where('slug', $attachmentSlug)->first();
        
        if (!$attachment) {
            return response()->json([
                'message' => "Attachment with slug '{$attachmentSlug}' not found."
            ], 422);
        }
    } else {
        // Fallback to most recent attachment
        $attachment = Attachment::latest()->first();
        
        if (!$attachment) {
            return response()->json([
                'message' => 'No attachment period found. Please create an attachment period first or provide attachment_slug in the import file.'
            ], 422);
        }
    }

    $processedCount = 0;

    foreach ($dataRows as $row) {
        $regNo = trim(data_get($row, 'reg_no'));
        if (!$regNo) continue;

        // 1. Prepare student info from Excel
        $studentName = trim(data_get($row, 'student_name')) 
                       ?? trim(data_get($row, 'Student Name')) 
                       ?? 'Student ' . $regNo;
        $studentEmail = trim(data_get($row, 'student_email')) ?: strtolower($regNo).'@student.com';
        $studentPhone = trim(data_get($row, 'student_phone')) ?: '07'.str_pad(rand(10000000,99999999), 8, '0', STR_PAD_LEFT);

        $studentUser = User::updateOrCreate(
            ['email' => $studentEmail],
            [
                'name' => $studentName,
                'phone_number' => $studentPhone,
                'role' => 'student',
                'password' => bcrypt('password'),
            ]
        );
        
        $programId = data_get($row, 'program_id'); // get from Excel
        if (!$programId) {
            $programId = 38; // default program ID if missing
        }

$student = Student::updateOrCreate(
    ['user_id' => $studentUser->id], // check by user_id
    [
         'phone_number' => $studentPhone,
        'reg_no'     => $regNo,
        'program_id' => $programId,
    ]
);
 



           $companyName = trim(data_get($row, 'name_of_organization'));
$companyEmail = trim(data_get($row, 'company_email')); // make sure your Excel has this column

if (!$companyName) {
    $companyName = 'Unknown Company';
}

if (!$companyEmail) {
    // Only generate email if Excel does not have it
    $companyEmail = strtolower(preg_replace('/[^A-Za-z0-9]/', '', $companyName)) . '@company.com';
}


            $companyUser = User::updateOrCreate(
                ['email' => $companyEmail],
                [
                    'name' => $companyName,
                    'role' => 'company',
                    'password' => bcrypt('password'),
                ]
            );

  // ===== FIXED LOCATION LOGIC =====
            $townName = trim(data_get($row, 'town'));
            $excelCounty = trim(data_get($row, 'county')); // This is empty in your data
            
            $townId = null;
            $countyId = null;

            // Find the town by name
            if (!empty($townName)) {
                $town = Location::where('level', 3)
                    ->whereRaw('LOWER(name) = ?', [strtolower($townName)])
                    ->first();
                
                if ($town) {
                    $townId = $town->id;
                    
                    // IMPORTANT: Use the town's parent_id as the county
                    // This is the correct county!
                    $countyId = $town->parent_id;
                    
                    // Log for debugging
                    \Log::info("Found town: {$town->name}, county_id: {$countyId}");
                }
            }

            // If town not found, try using Excel county
            if (!$countyId && !empty($excelCounty)) {
                $county = Location::where('level', 1)
                    ->whereRaw('LOWER(name) = ?', [strtolower($excelCounty)])
                    ->first();
                
                if ($county) {
                    $countyId = $county->id;
                }
            }

            // Last resort - but DON'T use Baringo
            if (!$countyId) {
                \Log::warning("Could not determine county for company: {$companyName}, town: {$townName}");
                
                // Use Nairobi or another major county as default
                $defaultCounty = Location::where('level', 1)
                    ->where('name', 'Nairobi')
                    ->first();
                
                if (!$defaultCounty) {
                    $defaultCounty = Location::where('level', 1)->first();
                }
                
                $countyId = $defaultCounty ? $defaultCounty->id : 1;
            }





            $company = Company::updateOrCreate(
                ['email' => $companyEmail],
                [
                    'name'      => $companyName,
                    'user_id'   => $companyUser->id,
                    'alias'     => strtoupper(substr($companyName, 0, 3)) . '-' . $companyUser->id,
                    'contact'   => trim(data_get($row, 'contact')) ?: '07' . str_pad($companyUser->id, 8, '0', STR_PAD_LEFT),
                    'address'   => data_get($row, 'address', $townName . ' Road'),
                    'county_id' => $countyId,
                   'town_id' => $townId,
                    'street'    => data_get($row, 'street', 'N/A'),
                    'building'  => data_get($row, 'building', 'N/A'),
                ]
            );

            

            $supervisorEmail = trim(data_get($row, 'supervisor_email'));
            $supervisorName  = trim(data_get($row, 'name_of_indusrty_supervisor'));
            $supervisorPhone = trim(data_get($row, 'telephone_number_of_supervisor'));

            $industrialSupervisorId = null;

            if ($supervisorEmail) {

                $supervisorUser = User::updateOrCreate(
                    ['email' => $supervisorEmail],
                    [
                        'name' => $supervisorName ?: 'Industrial Supervisor',
                        'phone_number' => $supervisorPhone,
                        'role' => 'industrial_supervisor',
                        'password' => bcrypt('password'),
                    ]
                );

                $supervisorProfile = \App\Models\IndustrialSupervisor::updateOrCreate(
                    ['user_id' => $supervisorUser->id],
                    [
                        'company_id' => $company->id,
                        'position_title' => 'Industrial Supervisor',
                    ]
                );

                $industrialSupervisorId = $supervisorProfile->id;
            }
$companyTown = $company->town;

// Fallbacks
$townId = $companyTown?->id;
$countyId = $companyTown?->parent_id ?? optional(Location::where('level', 1)->first())->id ?? 1;
            

            AttachmentStudent::updateOrCreate(
                [
                    'student_id'    => $student->id,
                    'attachment_id' => $attachment->id,
                ],
                [
                    'company_id' => $company->id,
                    'industrial_supervisor_id' => $industrialSupervisorId,
                    'start_date' => $this->transformDate(data_get($row, 'date_started')),
                    'end_date'   => $this->transformDate(data_get($row, 'expected_date_of_completion')),
                    'town_id' => $townId,
        'county_id' => $countyId,
        
       
                ]
                
            );

            $processedCount++;
        }

        return response()->json([
            'status' => 'success',
            'message' => "Successfully imported {$processedCount} student records."
        ]);

    } catch (\Exception $e) {

        \Log::error('Import Error: ' . $e->getMessage());

        return response()->json([
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}
private function transformDate($value)
{
    $value = trim($value);

    if (empty($value)) return null;

    
    if (is_numeric($value)) {
        try {
            return \Carbon\Carbon::instance(
                \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)
            )->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

   
    $value = preg_replace('/[^\d\/\-]/', '', $value);

    
    if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{2}$/', $value)) {
        $parts = explode('/', $value);
        $parts[2] = '20' . $parts[2]; 
        $value = implode('/', $parts);
    }

    foreach (['d/m/Y', 'd-m-Y', 'Y-m-d'] as $format) {
        try {
            return \Carbon\Carbon::createFromFormat($format, $value)->format('Y-m-d');
        } catch (\Exception $e) {
            continue;
        }
    }

    
    try {
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    } catch (\Exception $e) {
        \Log::warning("Unable to parse date: {$value}");
        return null;
    }
}



    public function showImportPage()
{
   
    return view('admin.attachmentimport');
}
}
