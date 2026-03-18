<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\AdministrativeUnit;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
 public function create(): \Illuminate\View\View
{
    // Fetch everything from administrative_units
    $units = \Illuminate\Support\Facades\DB::table('administrative_units')
        ->orderBy('name', 'asc')
        ->get();

    // Fetch counties (level 1) from locations table
    $counties = \Illuminate\Support\Facades\DB::table('locations')
        ->where('level', 1)
        ->orderBy('name', 'asc')
        ->get();

    // Fetch towns (level 3) from locations table
    $towns = \Illuminate\Support\Facades\DB::table('locations')
        ->where('level', 3)
        ->orderBy('name', 'asc')
        ->get();

    // Pass them to the view
    return view('auth.register', [
        'departments' => $units,
        'programs'    => $units,
        'counties'    => $counties,
        'towns'       => $towns
    ]);
}
   public function store(Request $request)
{
    // 1. Validation
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        'role' => ['required', 'in:student,lecturer,company'],
        
        // Lecturer specific
        'staff_number' => ['required_if:role,lecturer', 'nullable', 'string', 'unique:lecturers,staff_number'],
        'job_grade' => ['required_if:role,lecturer', 'nullable', 'string'],
        'office_phone' => ['required_if:role,lecturer', 'max:20'],
        'department' => ['required_if:role,lecturer', 'string'],
        
        // Student Specific Validation
        'reg_no' => ['required_if:role,student', 'nullable', 'string', 'unique:students,reg_no'],
        'year_of_study' => ['required_if:role,student', 'nullable', 'string'],
        'program_id' => ['required_if:role,student', 'nullable', 'integer'],
        'phone_number' => ['required_if:role,student', 'max:20'],
        
        // Company Specific Validation
        'company_name' => ['required_if:role,company', 'nullable', 'string', 'max:255', 'unique:companies,name'],
        'alias' => ['required_if:role,company', 'nullable', 'string', 'max:100', 'unique:companies,alias'],
        'contact' => ['required_if:role,company', 'nullable', 'string', 'max:20'],
        'address' => ['required_if:role,company', 'nullable', 'string', 'max:255'],
        'county_id' => ['required_if:role,company', 'nullable', 'integer', 'exists:locations,id'],
        'town_id' => ['required_if:role,company', 'nullable', 'integer', 'exists:locations,id'],
        'street' => ['nullable', 'string', 'max:255'],
        'building' => ['nullable', 'string', 'max:255'],
    ]);

    // 2. Create the Base User
    $user = \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        'role' => $request->role,
    ]);

    // 3. Create Specific Profiles
    if ($request->role === 'lecturer') {
        \App\Models\Lecturer::create([
            'user_id' => $user->id,
            'staff_number' => $request->staff_number,
            'department_id' => $request->department,
            'job_grade' => $request->job_grade,
            'office_phone' => $request->office_phone, // Fixed: was using phone_number instead of office_phone
        ]);
    } elseif ($request->role === 'student') {
        \App\Models\Student::create([
            'user_id' => $user->id,
            'reg_no' => $request->reg_no,
            'year_of_study' => $request->year_of_study,
            'program_id' => $request->program_id,
            'phone_number' => $request->phone_number,
        ]);
    } elseif ($request->role === 'company') {
        \App\Models\Company::create([
            'user_id' => $user->id,
            'name' => $request->company_name,
            'alias' => $request->alias,
            'contact' => $request->contact,
            'email' => $request->email, // Using the same email as user account
            'address' => $request->address,
            'county_id' => $request->county_id,
            'town_id' => $request->town_id,
            'street' => $request->street,
            'building' => $request->building,
        ]);
    }

    // 4. Trigger Registration Event
    event(new Registered($user));

    // 5. Redirect
    return redirect()->route('login')
        ->with('success', 'Registration successful. Please wait for approval.');
}
}