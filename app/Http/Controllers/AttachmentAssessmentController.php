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
                ->addIndexColumn() 
                ->addColumn('name', function ($row) {
                    return $row->student && $row->student->user
                        ? $row->student->user->name
                        : '-';
                })
                ->addColumn('reg_no', fn ($row) =>  $row->student->reg_no ?? '-')
                ->addColumn('attachment', fn ($row) => $row->attachment->name ?? '-')
                ->addColumn('department', fn ($row) => $row->department->name ?? '-')
                ->addColumn('lecturer', fn ($row) => $row->lecturer->user->name ?? '-')
                
              
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
          'acceptability_to_colleagues_marks' =>'required|integer|min:0|max:5',
            'acceptability_to_colleagues_remarks' => 'required|string',
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
            'punctuality_remarks' => $validated['punctuality_remarks'],

            'attendance_marks' => $validated['attendance_marks'],
            'attendance_remarks' => $validated['attendance_remarks'],

            'basic_skills_marks' => $validated['basic_skills_marks'],
            'basic_skills_remarks' => $validated['basic_skills_remarks'],

            'general_office_applications_marks' => $validated['general_office_applications_marks'],
            'general_office_applications_remarks' => $validated['general_office_applications_remarks'],

            'technical_applications_marks' => $validated['technical_applications_marks'],
            'technical_applications_remarks' => $validated['technical_applications_remarks'],

            'area_of_specialization_marks' => $validated['area_of_specialization_marks'],
            'area_of_specialization_remarks' => $validated['area_of_specialization_remarks'],

            'scientific_and_technical_knowledge_marks' => $validated['scientific_and_technical_knowledge_marks'],
            'scientific_and_technical_knowledge_remarks' => $validated['scientific_and_technical_knowledge_remarks'],

            'intelligence_marks' => $validated['intelligence_marks'],
            'intelligence_remarks' => $validated['intelligence_remarks'],

            'learning_ability_marks' => $validated['learning_ability_marks'],
            'learning_ability_remarks' => $validated['learning_ability_remarks'],

            'responsibility_acceptance_marks' => $validated['responsibility_acceptance_marks'],
            'responsibility_acceptance_remarks' => $validated['responsibility_acceptance_remarks'],
 'acceptability_to_colleagues_marks' => $validated['acceptability_to_colleagues_marks'],
            'acceptability_to_colleagues_remarks' => $validated['acceptability_to_colleagues_remarks'],

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


 



    
    public function createSchool($studentId)
    {
        $student = Student::findOrFail($studentId);
        return view('my.lecturer', compact('student'));
    }

    
   public function storeSchool(Request $request)
{
    $validated = $request->validate([
        'attachment_student_id' => 'required|exists:attachment_students,id',

        'practical_orientation_marks'   => 'required|integer|min:0|max:5',
        'practical_orientation_remarks' => 'required|string',

        'intellectual_activity_marks'   => 'required|integer|min:0|max:5',
        'intellectual_activity_remarks' => 'required|string',

        'independence_marks'   => 'required|integer|min:0|max:5',
        'independence_remarks' => 'required|string',

        'communication_marks'   => 'required|integer|min:0|max:5',
        'communication_remarks' => 'required|string',

        'technology_and_skills_marks' => 'required|integer|min:0|max:5',
        'technology_and_skills_remarks' => 'required|string',

        'innovativeness_marks'   => 'required|integer|min:0|max:5',
        'innovativeness_remarks' => 'required|string',
    ]);
       $existingLecturer = AttachmentAssessment::where('attachment_student_id', $request->attachment_student_id)
            ->where('practical_orientation_marks', '>', 0)
            ->first();

    if ($existingLecturer) {
        return response()->json([
            'status' => 'error',
            'message' => 'Lecturer assessment already submitted!'
        ], 422);
    }
    
    
  
    AttachmentAssessment::updateOrCreate(
        [
            'attachment_student_id' => $validated['attachment_student_id']
        ],
        [
            'practical_orientation_marks'   => $validated['practical_orientation_marks'],
            'practical_orientation_remarks' => $validated['practical_orientation_remarks'],

            'intellectual_activity_marks'   => $validated['intellectual_activity_marks'],
            'intellectual_activity_remarks' => $validated['intellectual_activity_remarks'],

            'independence_marks'   => $validated['independence_marks'],
            'independence_remarks'   => $validated['independence_remarks'],
            

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
public function check(Request $request)
{
    $assessment = AttachmentAssessment::where('attachment_student_id', $request->student_id)->first();

   if ($assessment && $assessment->practical_orientation_marks > 0) {
        
        $total = $assessment->practical_orientation_marks 
               + $assessment->intellectual_activity_marks 
               + $assessment->independence_marks 
               + $assessment->communication_marks 
               + $assessment->technology_and_skills_marks 
               + $assessment->innovativeness_marks;

        return response()->json([
            'exists' => true,
            'total' => $total, 
            'assessment' => [
                'Practical Orientation' => ['marks' => $assessment->practical_orientation_marks, 'remarks' => $assessment->practical_orientation_remarks],
                'Intellectual Activity' => ['marks' => $assessment->intellectual_activity_marks, 'remarks' => $assessment->intellectual_activity_remarks],
                'Independence'          => ['marks' => $assessment->independence_marks, 'remarks' => $assessment->independence_remarks],
                'Communication'         => ['marks' => $assessment->communication_marks, 'remarks' => $assessment->communication_remarks],
                'Technology & Skills'   => ['marks' => $assessment->technology_and_skills_marks, 'remarks' => $assessment->technology_and_skills_remarks],
                'Innovativeness'        => ['marks' => $assessment->innovativeness_marks, 'remarks' => $assessment->innovativeness_remarks],
            ]
        ]);
    }
    return response()->json(['exists' => false]);
}
public function checkIndustry(Request $request)
{
    $studentId = $request->student_id;

   
    $assessment = \App\Models\AttachmentAssessment::where('attachment_student_id', $studentId)->first();

   
    if ($assessment && $assessment->punctuality_marks > 0) {
        return response()->json([
            'exists' => true,
            'assessment' => [
                'Punctuality' => ['marks' => $assessment->punctuality_marks, 'remarks' => $assessment->punctuality_remarks],
                'Attendance' => ['marks' => $assessment->attendance_marks, 'remarks' => $assessment->attendance_remarks],
                'Basic Skills' => ['marks' => $assessment->basic_skills_marks, 'remarks' => $assessment->basic_skills_remarks],
                'Office Apps' => ['marks' => $assessment->general_office_applications_marks, 'remarks' => $assessment->general_office_applications_remarks],
                'Technical Apps' => ['marks' => $assessment->technical_applications_marks, 'remarks' => $assessment->technical_applications_remarks],
                'Specialization' => ['marks' => $assessment->area_of_specialization_marks, 'remarks' => $assessment->area_of_specialization_remarks],
                'Scientific Knowledge' => ['marks' => $assessment->scientific_and_technical_knowledge_marks, 'remarks' => $assessment->scientific_and_technical_knowledge_remarks],
                'Intelligence' => ['marks' => $assessment->intelligence_marks, 'remarks' => $assessment->intelligence_remarks],
                'Learning Ability' => ['marks' => $assessment->learning_ability_marks, 'remarks' => $assessment->learning_ability_remarks],
                'Responsibility' => ['marks' => $assessment->responsibility_acceptance_marks, 'remarks' => $assessment->responsibility_acceptance_remarks],
                'acceptability_to_colleagues' => ['marks' => $assessment->acceptability_to_colleagues_marks, 'remarks' => $assessment->acceptability_to_colleagues_remarks],
                'Improvisation' => ['marks' => $assessment->improvisation_marks, 'remarks' => $assessment->improvisation_remarks],
                'Env Adjustment' => ['marks' => $assessment->environment_adjustment_marks, 'remarks' => $assessment->environment_adjustment_remarks],
                'Reliability' => ['marks' => $assessment->dependability_and_reliability_marks, 'remarks' => $assessment->dependability_and_reliability_remarks],
                'Organization' => ['marks' => $assessment->organization_and_planning_marks, 'remarks' => $assessment->organization_and_planning_remarks],
                'Time Use' => ['marks' => $assessment->effective_time_use_marks, 'remarks' => $assessment->effective_time_use_remarks],
            ]
        ]);
    }

    return response()->json(['exists' => false]);
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
         + $this->acceptability_to_colleagues_marks
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