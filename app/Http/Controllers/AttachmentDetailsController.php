<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\AttachmentStudent;
use App\Models\Company;
use App\Models\DailyReport;
use App\Models\Student;
use App\Models\WeeklyReport;
use Illuminate\Http\Request;

class AttachmentDetailsController extends Controller
{public function edit(Request $req)
{
    $attachment_student_id = $req->session()->get('attachment_student_id');
    $attachment_student = AttachmentStudent::find($attachment_student_id);
    $companies = Company::with('subcounty')->get();
    $logged_user = auth()->user();
    $my_student_details = Student::with('program')
                                    ->where('user_id', $logged_user->id)
                                    ->first();
    return view('student.attachment-form',  compact('companies',  'logged_user','my_student_details','attachment_student'));
}
    public function update(Request $request)
    {
        $attachment_id = $request->session()->get('attachment_id');
        $attachment = Attachment::find($attachment_id);
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'industrial_supervisor_id' => 'required|exists:users,id',
            'start_date' => [
                'required',
                'date',
                'after_or_equal:' . $attachment->start_date,
                'before_or_equal:' . $attachment->end_date,
            ],
            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
                'before_or_equal:' . $attachment->end_date,
            ],
        ]);
        $attachment_student_id = $request->session()->get('attachment_student_id');

        if (!$attachment_student_id) {
            return redirect()->back()->withInput()->with([
                'notification' => [
                    'icon' => 'error',
                    'title' => 'Error',
                    'message' => 'Invalid student attachment',
                ]
            ]);
        }

        $exists = WeeklyReport::where('attachment_student_id', $attachment_student_id)
                                ->whereHas('dailyReports')
                                ->exists();

        if ($exists) {
            return redirect()->back()->withInput()->with([
                'notification' => [
                    'icon' => 'error',
                    'title' => 'Error',
                    'message' => 'You have already filled the log book. Hence your updates cannot be saved'
                ]
            ]);
        }

        // 3. Update the attachment student record
        AttachmentStudent::where('id', $attachment_student_id)
            ->update([
                'company_id' => $validated['company_id'],
                'industrial_supervisor_id' => $validated['industrial_supervisor_id'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
            ]);

        return redirect()->back()->withInput()->with([
            'notification' => [
                'icon' => 'success',
                'title' => 'Success',
                'message' => 'Attachment Details Saved successfully.'
            ]
        ]);
    }

    public function show($id)
    {
        $data = AttachmentStudent::with([
            'student',
            'student.user',
            'student.program',
            'company.subcounty',
            'industrialSupervisor.user',
            'lecturer',
            'attachment'
        ])->findOrFail($id);

        return response()->json($data);
    }

}
