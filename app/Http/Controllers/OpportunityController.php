<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
class OpportunityController extends Controller
{
    // Display all opportunities (for students)
  



public function index(Request $request)
{
    $user = Auth::user();
    $isCompany = $user->role === 'company';

    if ($request->ajax()) {
        if ($isCompany) {
            $query = Opportunity::where('company_id', $user->id);
        } else {
            $query = Opportunity::with('company')->whereDate('expiry_date', '>=', now());
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('company', function ($row) {
                return $row->company->name ?? 'N/A';
            })
            ->addColumn('action', function ($row) use ($isCompany) {
                if ($isCompany) {
                    return '
                        <form method="POST" action="' . route('opportunities.destroy', $row->id) . '" onsubmit="return confirm(\'Are you sure?\');">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    ';
                }
                return ''; // no actions for students
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // Normal page load returns blade view with minimal data (or empty)
    return view('opportunities.index', [
        'isCompany' => $isCompany,
    ]);
}




    // Display company’s own opportunities
    public function myOpportunities()
    {
        $opportunities = Opportunity::where('company_id', Auth::id())->latest()->get();
        return view('opportunities.my-opportunities', compact('opportunities'));
    }

    // Show create form
    public function create()
    {
        return view('opportunities.create');
    }

    // Store new opportunity
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'expiry_days' => 'required|integer|min:1|max:90', // how long it should stay active
             
        ]);

        Opportunity::create([
            'company_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'expiry_date' => Carbon::now()->addDays((int) $request->expiry_days),
        ]);

        return redirect()->route('opportunities.my')->with('success', 'Opportunity posted successfully!');
    }

   
    public function destroy(Opportunity $opportunity)
    {
        if ($opportunity->company_id !== Auth::id()) {
            abort(403);
        }

        $opportunity->delete();
        return back()->with('success', 'Opportunity deleted successfully.');
    }
    public function apply($id)
{
    $user = auth()->user();

    // Check if user is a student (optional: add your own role check)
    if ($user->role !== 'student') {
        abort(403, 'Only students can apply to opportunities.');
    }

    $opportunity = Opportunity::findOrFail($id);

    // Optional: Check if the user already applied
    $alreadyApplied = $opportunity->applicants()->where('user_id', $user->id)->exists();
    if ($alreadyApplied) {
        return redirect()->back()->with('error', 'You have already applied for this opportunity.');
    }

    // Attach the user to the opportunity (assuming many-to-many relationship)
    $opportunity->applicants()->attach($user->id);

    return redirect()->back()->with('success', 'Application submitted successfully!');
}
public function submitApplication(Request $request, $id)
{
    $user = auth()->user();

    if ($user->role !== 'student') {
        abort(403, 'Only students can apply.');
    }

    $opportunity = \App\Models\Opportunity::findOrFail($id);

    // Validate input
    $data = $request->validate([
        'cover_letter' => 'required|string|max:2000',
        'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',  // max 2MB
    ]);

    // Check if already applied
    if ($opportunity->applicants()->where('user_id', $user->id)->exists()) {
        return redirect()->route('opportunities.index')->with('error', 'You have already applied for this opportunity.');
    }

    // Store uploaded CV
    $cvPath = $request->file('cv')->store('cvs', 'public');

    // Attach user to opportunity with extra pivot data
    $opportunity->applicants()->attach($user->id, [
        'cover_letter' => $data['cover_letter'],
        'cv_path' => $cvPath,
        'applied_at' => now(),
    ]);

    return redirect()->route('opportunities.index')->with('success', 'Application submitted successfully!');
}
public function showApplyForm($id)
{
    $opportunity = \App\Models\Opportunity::findOrFail($id);

    
    if (auth()->user()->role !== 'student') {
        abort(403, 'Only students can apply.');
    }

    return view('opportunities.apply', compact('opportunity'));
}
public function showApplications($opportunityId)
{
    // Load the opportunity with its applications and applicant user info
    $opportunity = \App\Models\Opportunity::with('applications.user')->findOrFail($opportunityId);

    // Pass to view
    return view('opportunities.applications', compact('opportunity'));
}


}
