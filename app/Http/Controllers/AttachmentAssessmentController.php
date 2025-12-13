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

        // 🔥 Redirect Industrial Supervisor to their attaches page
        return redirect()->route('industrial_supervisor.attaches')
            ->with('success', 'Industrial assessment saved successfully.');
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
        $request->validate([
            'attachment_student_id' => 'required|exists:attachment_students,id,',
            'practical_marks' => 'required|integer|min:0|max:5',
            'practical_remarks' => 'required|string',
            'report_marks' => 'required|integer|min:0|max:5',
            'report_remarks' => 'required|string',
            'presentation_marks' => 'required|integer|min:0|max:5',
            'presentation_remarks' => 'required|string',
            'communication_marks' => 'required|integer|min:0|max:5',
            'communication_remarks' => 'required|string',
            'skills_marks' => 'required|integer|min:0|max:5',
            'skills_remarks' => 'required|string',
            'innovativeness_marks' => 'required|integer|min:0|max:5',
            'innovativeness_remarks' => 'required|string',
        ]);

        AttachmentAssessment::updateOrCreate(
            ['attachment_student_id' => $request->attachment_student_id],
            $request->only([
                'practical_marks',
                'practical_remarks',
                'report_marks',
                'report_remarks',
                'presentation_marks',
                'presentation_remarks',
                'skills_marks',
                'skills_remarks' ,
                'innovativeness_marks',
                'innovativeness_remarks',
                'communication_marks',
                'communication_remarks',
            ])
        );


        return redirect()->route('lecturer.my-students')
            ->with('success', 'School assessment saved successfully.');
    }
}
