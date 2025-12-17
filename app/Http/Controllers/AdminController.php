<?php
namespace App\Http\Controllers;
use App\Models\Budget;
use App\Models\AttachmentAssessment;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function portal() {
        return view('admin.portal');
    }

    public function students() {
        return view('students');
    }

    public function supervisors() {
        return view('supervisors');
    }

    public function industry() {
        return view('industry');
    }

    public function attachments() {
        return view('attachments');
    }

     public function budgets()
    {
        $budgets = Budget::all();
        return view('admin.budgets', compact('budgets'));
    }

    public function storeBudget(Request $request)
    {
        $request->validate([
            'staffnumber' => 'required|string|max:255',
            'grade' => 'required|string|max:255',
            'lecturer_name' => 'required|string|max:255',
            'daily_allowance' => 'required|numeric|min:0',
            'transport_town' => 'required|numeric|min:0',
            'totals' => 'required|numeric|min:0',
            'student_list_file' => 'nullable|file|mimes:csv,txt|max:2048',
        ]);

        $budget = new Budget();
        $budget->staffnumber = $request->staffnumber;
        $budget->grade = $request->grade;
        $budget->lecturer_name = $request->lecturer_name;
        $budget->daily_allowance = $request->daily_allowance;
        $budget->transport_town = $request->transport_town;
        $budget->totals = $request->totals;

        // Handle file upload
        if ($request->hasFile('student_list_file')) {
            $fileName = time() . '_' . $request->student_list_file->getClientOriginalName();
            $request->student_list_file->move(public_path('uploads/student_lists'), $fileName);
            $budget->student_list_file = $fileName;
        }

        $budget->save();

        return redirect()->route('admin.budgets')->with('success', 'Budget saved successfully!');
    }

    public function showBudget($id)
    {
        $budget = Budget::findOrFail($id);
        return view('admin.show-budget', compact('budget'));
    }
public function destroyBudget($id)
{
    // Import the Budget model at the top if not already done:
    // use App\Models\Budget;

    $budget = \App\Models\Budget::find($id);

    if (!$budget) {
        return redirect()->route('admin.budgets')
                         ->with('error', 'Budget not found.');
    }

    $budget->delete();

    return redirect()->route('admin.budgets')
                     ->with('success', 'Budget deleted successfully.');
}


    public function reports() {
        return view('admin.reports');
    }

    public function settings() {
        return view('admin.settings');
    }
    public function index()
{
    $assessments = AttachmentAssessment::with([
        'attachmentStudent.student.user',
        'attachmentStudent.student.program',
        'lecturer.user',
        'industrialSupervisor.user'
    ])->get();

    $totals = [
        'lecturer_total' => $assessments->sum(fn($a) => $a->lecturer_total_marks ?? 0),
        'industrial_total' => $assessments->sum(fn($a) => $a->industrial_supervisor_total_marks ?? 0),
        'combined_total' => $assessments->sum(fn($a) => ($a->lecturer_total_marks ?? 0) + ($a->industrial_supervisor_total_marks ?? 0)),
    ];

    return view('admin.assessments', compact('assessments', 'totals'));
}

}
