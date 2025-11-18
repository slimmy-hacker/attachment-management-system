<?php

namespace App\Http\Controllers\Auth;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create($portal = null)
{
    if ($portal) {
        session(['portal' => $portal]);
    }
    return view('auth.login', compact('portal'));
}


    /**
     * Handle an incoming authentication request.
     */
    // app/Http/Controllers/Auth/AuthenticatedSessionController.php

public function store(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'string', 'email'],
        'password' => ['required', 'string'],
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();

        $user = Auth::user();

        // Redirect based on user's stored portal
        switch ($user->portal) {
            case 'student':
                return redirect()->route('student.portal');
            case 'lecturer':
                return redirect()->route('lecturer.portal');
            case 'industrial_supervisor':
                return redirect()->route('industry.portal');
            case 'company':
                return redirect()->route('company.portal');
            case 'admin':
                return redirect()->route('admin.portal');
            default:
                return redirect()->route('welcome');
        }
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
}



    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
