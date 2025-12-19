<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\AttachmentAssessment;
use Illuminate\Http\Request;

class AttachmentAssessmentController extends Controller
{
 public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = AttachmentStudent::with(['attachment', 'student', 'student.user']);
                if (!empty($request->attachment_id)) {
                    $data->where('attachment_id', $request->attachment_id);
                }

            return DataTables::of($data)
                ->addIndexColumn() // adds DT_RowIndex
                ->addColumn('name', function ($row) {
                    return $row->student && $row->student->user
                        ? $row->student->user->name
                        : '-';
                })
                ->addColumn('reg_no', fn ($row) =>  $row->student->reg_no ?? '-')
                ->addColumn('attachment', fn ($row) => $row->attachment->name ?? '-')
                ->addColumn('department', fn ($row) => $row->department->name ?? '-')
                ->addColumn('lecturer', fn ($row) => $row->lecturer->user->name ?? '-')
                ->addColumn('status', fn ($row) => $row->attachment->status ?? '-')
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-sm btn-danger delete" data-id="'.$row->id.'">Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $attachments = Attachment::select('id', 'name')
            ->orderBy('start_date', 'desc')
            ->get();
            $students = Student::select('id', 'user_id')
    ->with('user:id,name')
    ->get();

        return view('lecturer.my-students', compact('attachments','students'));
    }
    // INDUSTRIAL SUPERVISOR ASSESSMENT FORM
    public function createIndustrial($studentId)
    {
        $student = Student::findOrFail($studentId);
        return view('attaches.industrial_supervisor', compact('student'));
    }

   

  public function storeIndustrial(Request $request)
{
    $validated = $request->validate([
        'attachment_student_id' => 'required|exists:attachment_students,id',

        'punctuality_marks' => 'required|integer|min:0|max:5',
        'punctuality_remarks' => 'required|string',

        'attendance_marks' => 'required|integer|min:0|max:5',
        'attendance_remarks' => 'required|string',

        'basic_skills_marks' => 'required|integer|min:0|max:5',
        'basic_skills_remarks' => 'required|string',

        'general_office_applications_marks' => 'required|integer|min:0|max:5',
        'general_office_applications_remarks' => 'required|string',

        'technical_applications_marks' => 'required|integer|min:0|max:5',
        'technical_applications_remarks' => 'required|string',

        'area_of_specialization_marks' => 'required|integer|min:0|max:5',
        'area_of_specialization_remarks' => 'required|string',

        'scientific_and_technical_knowledge_marks' => 'required|integer|min:0|max:5',
        'scientific_and_technical_knowledge_remarks' => 'required|string',

        'intelligence_marks' => 'required|integer|min:0|max:5',
        'intelligence_remarks' => 'required|string',

        'learning_ability_marks' => 'required|integer|min:0|max:5',
        'learning_ability_remarks' => 'required|string',

        'responsibility_acceptance_marks' => 'required|integer|min:0|max:5',
        'responsibility_acceptance_remarks' => 'required|string',

        'improvisation_marks' => 'required|integer|min:0|max:5',
        'improvisation_remarks' => 'required|string',

        'environment_adjustment_marks' => 'required|integer|min:0|max:5',
        'environment_adjustment_remarks' => 'required|string',

        'dependability_and_reliability_marks' => 'required|integer|min:0|max:5',
        'dependability_and_reliability_remarks' => 'required|string',

        'organization_and_planning_marks' => 'required|integer|min:0|max:5',
        'organization_and_planning_remarks' => 'required|string',

        'effective_time_use_marks' => 'required|integer|min:0|max:5',
        'effective_time_use_remarks' => 'required|string',
    ]);

    // Get industrial supervisor ID from session
    $supervisorId = $request->session()->get('industrial_supervisor_id');

    if (!$supervisorId) {
        return response()->json([
            'status' => 'error',
            'message' => 'Industrial Supervisor ID not found in session',
        ], 400);
    }

    // Check if this supervisor has already assessed this student
    $existingAssessment = AttachmentAssessment::where('attachment_student_id', $validated['attachment_student_id'])
        ->where('industrial_supervisor_id', $supervisorId)
        ->whereNotNull('punctuality_marks')  // or any key industrial assessment mark column
        ->first();

    if ($existingAssessment) {
        return response()->json([
            'status' => 'error',
            'message' => 'You have already assessed this student.',
        ], 409);
    }

    // Save or update assessment
    $assessment = AttachmentAssessment::updateOrCreate(
        ['attachment_student_id' => $validated['attachment_student_id']],
        array_merge($validated, ['industrial_supervisor_id' => $supervisorId])
    );

    return response()->json([
        'status' => 'success',
        'message' => 'Industrial assessment saved successfully',
    ]);
}





    // SCHOOL SUPERVISOR ASSESSMENT FORM
    public function createSchool($studentId)
    {
        $student = Student::findOrFail($studentId);
        return view('my.lecturer', compact('student'));
    }

    public function storeSchool(Request $request)
{
    $validated = $request->validate([
        'attachment_student_id' => 'required|exists:attachment_students,id',

        'practical_orientation_marks' => 'required|integer|min:0|max:5',
        'practical_orientation_remarks' => 'required|string',

        'intellectual_activity_marks' => 'required|integer|min:0|max:5',
        'intellectual_activity_remarks' => 'required|string',

        'independence_marks' => 'required|integer|min:0|max:5',
        'independence_remarks' => 'required|string',

        'communication_marks' => 'required|integer|min:0|max:5',
        'communication_remarks' => 'required|string',

        'technology_and_skills_marks' => 'required|integer|min:0|max:5',
        'technology_and_skills_remarks' => 'required|string',

        'innovativeness_marks' => 'required|integer|min:0|max:5',
        'innovativeness_remarks' => 'required|string',
    ]);

    $lecturerId = $request->session()->get('attachment_lecturer_id');

    if (!$lecturerId) {
        return response()->json([
            'status' => 'error',
            'message' => 'Lecturer ID not found in session',
        ], 400);
    }

    // Check if already assessed before updating/creating
    $existingAssessment = AttachmentAssessment::where('attachment_student_id', $validated['attachment_student_id'])
        ->where('lecturer_id', $lecturerId)
        ->whereNotNull('practical_orientation_marks')  // check key column for assessment
        ->first();

    if ($existingAssessment) {
        return response()->json([
            'status' => 'error',
            'message' => 'You have already assessed this student.',
        ], 409);
    }

    // Only update or create if not assessed
    $assessment = AttachmentAssessment::updateOrCreate(
        ['attachment_student_id' => $validated['attachment_student_id']],
        array_merge($validated, ['lecturer_id' => $lecturerId])
    );

    return response()->json([
        'status' => 'success',
        'message' => 'Assessment saved successfully',
    ]);
}

public function getLecturerTotalMarksAttribute()
{
    return $this->practical_orientation_marks
         + $this->intellectual_activity_marks
         + $this->independence_marks
         + $this->communication_marks
         + $this->technology_and_skills_marks
         + $this->innovativeness_marks;
}

public function getIndustrialSupervisorTotalMarksAttribute()
{
    return $this->punctuality_marks
         + $this->attendance_marks
         + $this->basic_skills_marks
         + $this->general_office_applications_marks
         + $this->technical_applications_marks
         + $this->area_of_specialization_marks
         + $this->scientific_and_technical_knowledge_marks
         + $this->intelligence_marks
         + $this->learning_ability_marks
         + $this->responsibility_acceptance_marks
         + $this->improvisation_marks
         + $this->environment_adjustment_marks
         + $this->dependability_and_reliability_marks
         + $this->organization_and_planning_marks
         + $this->effective_time_use_marks;
}
public function getCombinedTotalMarksAttribute()
{
    return $this->lecturer_total_marks + $this->industrial_supervisor_total_marks;
}

}

