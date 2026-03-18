<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
class OpportunityController extends Controller
{
    



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
            ->addColumn('company_name', function ($row) {
    return $row->company->name ?? 'N/A';
})
   ->editColumn('expiry_date', function($row) {

                    return Carbon::parse($row->expiry_date)->format('M d, Y');

                })
                 ->addColumn('link', function($row) {
            return $row->link; 
        })
        
    ->rawColumns(['action', 'link'])  
    
                

    
 ->addColumn('action', function ($row) use ($isCompany) {

    if ($isCompany) {
        return '
            <form method="POST" action="' . route('opportunities.destroy', $row->id) . '" onsubmit="return confirm(\'Are you sure?\');">
                ' . csrf_field() . method_field('DELETE') . '
                <button type="submit" class="text-red-500 hover:text-red-700 transition-colors">
                   <i class="fas fa-trash-alt"></i>
                </button>
            </form>
        ';
    }  if ($row->is_expired) {
            return '<span class="text-gray-400 font-semibold">Expired</span>';
        }

        if ($row->link) {
            return '
                <a href="' . $row->link . '" 
                   target="_blank"
                   class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                   Apply
                </a>
        ';
    }
     return '<span class="text-gray-400">No Link</span>';
 
})



->rawColumns(['action'])
->make(true);
    }

    
    return view('opportunities.index', [
        'isCompany' => $isCompany,
    ]);
}




    
    public function myOpportunities()
    {
        $opportunities = Opportunity::where('company_id', Auth::id())->latest()->get();
        return view('opportunities.my-opportunities', compact('opportunities'));
    }

    
    public function create()
    {
        return view('opportunities.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'location' => 'required|string|max:255',
        // Changed from expiry_days to expiry_date
        'expiry_date' => [
            'required',
            'date',
            'after:today', // Ensures the date is tomorrow or later
            'before_or_equal:' . now()->addDays(90)->format('Y-m-d')
        ],
        'link' => 'required|url'
    ]);

    Opportunity::create([
        'company_id' => Auth::id(),
        'title' => $request->title,
        'description' => $request->description,
        'location' => $request->location,
        // Save the date directly from the request
        'expiry_date' => $request->expiry_date, 
        'link' => $request->link,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Opportunity posted successfully!'
    ]);
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

    
    if ($user->role !== 'student') {
        abort(403, 'Only students can apply to opportunities.');
    }

    $opportunity = Opportunity::findOrFail($id);

    
    $alreadyApplied = $opportunity->applicants()->where('user_id', $user->id)->exists();
    if ($alreadyApplied) {
        return redirect()->back()->with('error', 'You have already applied for this opportunity.');
    }

    
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

   
    $data = $request->validate([
        'cover_letter' => 'required|string|max:2000',
        'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',  
    ]);

    
    if ($opportunity->applicants()->where('user_id', $user->id)->exists()) {
        return redirect()->route('opportunities.index')->with('error', 'You have already applied for this opportunity.');
    }

    
    $cvPath = $request->file('cv')->store('cvs', 'public');

    
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
    
    $opportunity = \App\Models\Opportunity::with('applications.user')->findOrFail($opportunityId);

    
    return view('opportunities.applications', compact('opportunity'));
}


}
