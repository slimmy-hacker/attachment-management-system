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

    // SAVE Industrial Supervisor Assessment
  public function storeIndustrial(Request $request)
{
    $validated = $request->validate([
        'attachment_student_id' => 'required|exists:attachment_students,id',

        'punctuality_marks' => 'required|integer|min:0|max:5',
        'ppunctuality_remarks' => 'required|string',

        'attendance_marks' => 'required|integer|min:0|max:5',
        'attendance_remarks' => 'required|string',

        'basic_skils_marks' => 'required|integer|min:0|max:5',
        'basic_skils_remarks' => 'required|string',

        'general_office_applications_marks' => 'required|integer|min:0|max:5',
        'general_office_applications_remarks' => 'required|string',

        'technical_applicationss_marks' => 'required|integer|min:0|max:5',
        'technical_applications_remarks' => 'required|string',

        'area_of_specialization_marks' => 'required|integer|min:0|max:5',
        'area_of_specialization_remarks' => 'required|string',

        'scientific_and_technical_knowledgel_marks' => 'required|integer|min:0|max:5',
        'scientific_and_technical_knowledgel_remarks' => 'required|string',

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

    AttachmentAssessment::updateOrCreate(
        ['attachment_student_id' => $validated['attachment_student_id']],
        [
            'punctuality_marks' => $validated['punctuality_marks'],
            'punctuality_remarks' => $validated['ppunctuality_remarks'],

            'attendance_marks' => $validated['attendance_marks'],
            'attendance_remarks' => $validated['attendance_remarks'],

            'basic_skills_marks' => $validated['basic_skils_marks'],
            'basic_skills_remarks' => $validated['basic_skils_remarks'],

            'general_office_applications_marks' => $validated['general_office_applications_marks'],
            'general_office_applications_remarks' => $validated['general_office_applications_remarks'],

            'technical_applications_marks' => $validated['technical_applicationss_marks'],
            'technical_applications_remarks' => $validated['technical_applications_remarks'],

            'area_of_specialization_marks' => $validated['area_of_specialization_marks'],
            'area_of_specialization_remarks' => $validated['area_of_specialization_remarks'],

            'scientific_and_technical_knowledge_marks' => $validated['scientific_and_technical_knowledgel_marks'],
            'scientific_and_technical_knowledge_remarks' => $validated['scientific_and_technical_knowledgel_remarks'],

            'intelligence_marks' => $validated['intelligence_marks'],
            'intelligence_remarks' => $validated['intelligence_remarks'],

            'learning_ability_marks' => $validated['learning_ability_marks'],
            'learning_ability_remarks' => $validated['learning_ability_remarks'],

            'responsibility_acceptance_marks' => $validated['responsibility_acceptance_marks'],
            'responsibility_acceptance_remarks' => $validated['responsibility_acceptance_remarks'],

            'improvisation_marks' => $validated['improvisation_marks'],
            'improvisation_remarks' => $validated['improvisation_remarks'],

            'environment_adjustment_marks' => $validated['environment_adjustment_marks'],
            'environment_adjustment_remarks' => $validated['environment_adjustment_remarks'],

            'dependability_and_reliability_marks' => $validated['dependability_and_reliability_marks'],
            'dependability_and_reliability_remarks' => $validated['dependability_and_reliability_remarks'],

            'organization_and_planning_marks' => $validated['organization_and_planning_marks'],
            'organization_and_planning_remarks' => $validated['organization_and_planning_remarks'],

            'effective_time_use_marks' => $validated['effective_time_use_marks'],
            'effective_time_use_remarks' => $validated['effective_time_use_remarks'],
        ]
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

    // SAVE School Supervisor Assessment
   public function storeSchool(Request $request)
{
    $validated = $request->validate([
        'attachment_student_id' => 'required|exists:attachment_students,id',

        'practical_orientation_marks'   => 'required|integer|min:0|max:5',
        'practical_orientation_remarks' => 'required|string',

        'intellectual_activity_Marks'   => 'required|integer|min:0|max:5',
        'intellectual_activity_Remarks' => 'required|string',

        'independence_marks'   => 'required|integer|min:0|max:5',
        'independence_remarks' => 'required|string',

        'communication_marks'   => 'required|integer|min:0|max:5',
        'communication_remarks' => 'required|string',

        'technology_and_skills_marks' => 'required|integer|min:0|max:5',
        'technology_and_skills_remarks' => 'required|string',

        'innovativeness_marks'   => 'required|integer|min:0|max:5',
        'innovativeness_remarks' => 'required|string',
    ]);

    AttachmentAssessment::updateOrCreate(
        [
            'attachment_student_id' => $validated['attachment_student_id']
        ],
        [
            'practical_orientation_marks'   => $validated['practical_orientation_marks'],
            'practical_orientation_remarks' => $validated['practical_orientation_remarks'],

            'intellectual_activity_marks'   => $validated['intellectual_activity_Marks'],
            'intellectual_activity_remarks' => $validated['intellectual_activity_Remarks'],

            'independence_marks'   => $validated['independence_marks'],
            'independence_marks'   => $validated['independence_remarks'],
            

            'communication_marks'   => $validated['communication_marks'],
            'communication_remarks' => $validated['communication_remarks'],

            'technology_and_skills_marks'   => $validated['technology_and_skills_marks'],
            'technology_and_skills_remarks' => $validated['technology_and_skills_remarks'],

            'innovativeness_marks'   => $validated['innovativeness_marks'],
            'innovativeness_remarks' => $validated['innovativeness_remarks'],
        ]
    );

    return response()->json([
        'status'  => 'success',
        'message' => 'Assessment saved successfully',
    ]);
}

}

