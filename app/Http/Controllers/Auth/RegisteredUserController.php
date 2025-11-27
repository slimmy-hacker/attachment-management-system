<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the default registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request (default Breeze form).
     */
   public function store(Request $request)
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $portal = $request->input('portal'); // get selected portal

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'portal' => $portal, // ✅ store portal
    ]);

    event(new Registered($user));

    // Redirect user to login page with a success message
    return redirect()->route('login')->with('status', 'Registration successful! Please log in to your ' . ucfirst($portal) . ' portal.');
}
    /**
     * ✅ Show the registration form for a specific portal.
     */
    public function showPortalForm($portal): View
    {
        $validPortals = ['student', 'lecturer', 'industrial_supervisor', 'company','admin'];

        if (!in_array($portal, $validPortals)) {
            abort(404);
        }

        return view('auth.register', compact('portal'));
    }

    /**
     * ✅ Handle registration for specific portals.
     */
   public function storePortal(Request $request, $portal): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $portal, // ✅ Assign role automatically
    ]);

    event(new Registered($user));

    Auth::login($user);


    switch ($portal) {
        case 'student':

            return redirect()->route('student.portal');
        case 'lecturer':
            return redirect()->route('lecturer.portal');
        case 'industrial_supervisor':
            return redirect()->route('industrial_supervisor.portal');
            case 'admin':
            return redirect()->route('admin.portal');
        case 'company':
            return redirect()->route('company.portal');
        default:
            return redirect()->route('welcome');
    }
}

public function storeStudent(Request $request): RedirectResponse
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users|unique:students',
        'registration_number' => 'required|string|max:50|unique:students',
        'course' => 'required|string|max:100',
        'telephone' => 'required|string|max:15',
        'password' => 'required|string|confirmed|min:8',
    ]);

    // ✅ Create user
    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // ✅ Create student record
    Student::create([
        'user_id'             => $user->id,
        'name'                => $request->name,
        'email'               => $request->email,
        'registration_number' => $request->registration_number,
        'course'              => $request->course,
        'telephone'           => $request->telephone,
    ]);

    // ✅ Fire event
    event(new Registered($user));

    // ✅ Auto login
    Auth::login($user);

    // ✅ Redirect to student portal
    return redirect()->route('student.portal')
                     ->with('success', 'Student registered successfully!');
}

}
