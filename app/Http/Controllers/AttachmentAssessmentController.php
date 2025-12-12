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

        // 🔥 Redirect School Supervisor to My Students page
        return redirect()->route('lecturer.my-students')
            ->with('success', 'School assessment saved successfully.');
    }
}
