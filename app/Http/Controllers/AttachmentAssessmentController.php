<?php

namespace App\Http\Controllers;
use App\Models\Student; 
use App\Models\AttachmentAssessment;
use Illuminate\Http\Request;

class AttachmentAssessmentController extends Controller
{


public function createIndustrial($studentId)
{
    $student = Student::findOrFail($studentId);  // fetch the student record

    return view('assessment.industrial_supervisor', compact('student'));
}

    // Store Industrial Supervisor assessment data
    public function storeIndustrial(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'attendance_marks' => 'nullable|integer|min:0|max:100',
            'attendance_remarks' => 'nullable|string',
            'punctuality_marks' => 'nullable|integer|min:0|max:100',
            'punctuality_remarks' => 'nullable|string',
            'work_quality_marks' => 'nullable|integer|min:0|max:100',
            'work_quality_remarks' => 'nullable|string',
            'teamwork_marks' => 'nullable|integer|min:0|max:100',
            'teamwork_remarks' => 'nullable|string',
            'discipline_marks' => 'nullable|integer|min:0|max:100',
            'discipline_remarks' => 'nullable|string',
        ]);

        AttachmentAssessment::updateOrCreate(
            ['student_id' => $request->student_id],
            $request->only([
                'attendance_marks',
                'attendance_remarks',
                'punctuality_marks',
                'punctuality_remarks',
                'work_quality_marks',
                'work_quality_remarks',
                'teamwork_marks',
                'teamwork_remarks',
                'discipline_marks',
                'discipline_remarks',
            ])
        );

        return redirect()->back()->with('success', 'Industrial assessment saved successfully.');
    }

    // Show form for School Supervisor to assess a student
    public function createSchool($studentId)
    {
        $student = Student::findOrFail($studentId);  // fetch the student record

    return view('assessment.lecturer', compact('student'));
    }

    // Store School Supervisor assessment data
    public function storeSchool(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'practical_marks' => 'nullable|integer|min:0|max:100',
            'practical_remarks' => 'nullable|string',
            'report_marks' => 'nullable|integer|min:0|max:100',
            'report_remarks' => 'nullable|string',
            'presentation_marks' => 'nullable|integer|min:0|max:100',
            'presentation_remarks' => 'nullable|string',
        ]);

        AttachmentAssessment::updateOrCreate(
            ['student_id' => $request->student_id],
            $request->only([
                'practical_marks',
                'practical_remarks',
                'report_marks',
                'report_remarks',
                'presentation_marks',
                'presentation_remarks',
            ])
        );

        return redirect()->back()->with('success', 'School assessment saved successfully.');
    }
   public function listStudents()
{
    $industrySupervisor = auth()->user();

    if (!$industrySupervisor) {
        abort(403, 'Unauthorized');
    }

    $students = $industrySupervisor->attachedStudents ?? collect();

    return view('assessment.students_list', compact('students'));
}


}
