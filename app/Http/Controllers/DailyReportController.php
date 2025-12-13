<?php

namespace App\Http\Controllers;

use App\GenerateWeekNumber;
use App\Models\AttachmentStudent;
use App\Models\Calender;
use App\Models\Student;
use App\Models\User;
use App\Models\WeeklyReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DailyReport;
use Illuminate\Support\Facades\Auth;

class DailyReportController extends Controller
{
    private function calenderResponse($id, $type)
    { $data = [];
        if ($type == 'daily') {
            $daily_report = DailyReport::findOrFail($id);
            $data = [
                'id'             => $daily_report->id,
                'title'          => $daily_report->task_title,
                'start'          => $daily_report->start_date,
                'end'            => Carbon::parse($daily_report->end_date)->addDay()->toDateString(),
                'tasks'          => $daily_report->tasks,
                'skills_learned' => $daily_report->skills_learned,
                'challenges'     => $daily_report->challenges,
                'type'        => 'daily'
            ];
        }
        if ($type == 'weekly') {
            $weekly_report = WeeklyReport::findOrFail($id);

            $data = [
                    'id' => $weekly_report->week_id,
                    'title' => $weekly_report->status,
                    'start' => $weekly_report->week_start_date,
                    'end' => Carbon::parse($weekly_report->week_end_date)->addDay()->toDateString(),
                    'status' => $weekly_report->status,
                    'weekly_report' => $weekly_report->weekly_report,
                    'weekly_report_id' => $weekly_report->id,
                    'industrial_supervisor_comment' => $weekly_report->industrial_supervisor_comment,
                    'lecturer_comment' => $weekly_report->lecturer_comment,
                    'type' => 'weekly',
                    'color' => '#28a745',
                ];
        }
        return $data;
    }
    public function index(Request $request, $id = null)
    {       $user_role = Auth::user()->role;
        if ($user_role == 'student') {
            $attachment_student_id = $request->session()->get('attachment_student_id');
        }elseif($id){
            $attachment_student_id = $id;
        }else{
            abort(404);
        }

        $weekly_reports = WeeklyReport::where('attachment_student_id', $attachment_student_id)->pluck('id');
        $weekly_events =
            $weekly_reports ->map(function ($event) {
                return $this->calenderResponse($event, 'weekly');
            });
        $daily_events = DailyReport::whereIn('weekly_report_id', $weekly_reports)
            ->pluck('id')
            ->map(function ($event) {
            return $this->calenderResponse($event, 'daily');
        });
        $events = $weekly_events->merge($daily_events);
        $attachment_student = AttachmentStudent::with([ 'student', 'student.user'])
                                    ->where('id', $attachment_student_id)
                                    ->first();

        $report_route =  '#';
        if ($user_role == 'student') {
            $report_route =  route('student.weekly_activities.store');
        }
        elseif ($user_role == 'lecturer') {
            $report_route =  route('lecturer.weekly_activities.store');
        }
        elseif ($user_role == 'industrial_supervisor') {
            $report_route =  route('industrial_supervisor.weekly_activities.store');
        }
        return view('daily_activities.index', compact('events',  'user_role', 'attachment_student', 'report_route'));

    }
    public function store(Request $request)
    {
        try {
            $attachment_student_id = $request->session()->get('attachment_student_id');
            $attachment_student = AttachmentStudent::find($attachment_student_id);
            if (!$attachment_student->company_id ?? null || !$attachment_student->start_date ?? null) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Fill in your attachment form first.',

                ]);
            }
            $validated = $request->validate([
                'daily_report_id' => 'nullable|exists:daily_reports,id',
                'start_date' => [
                    'required',
                    'date',
                    'after_or_equal:' . $attachment_student->start_date,
                    'before_or_equal:' . $attachment_student->end_date,
                ],
                'end_date' => [
                    'required',
                    'date',
                    'after_or_equal:start_date', // must be after the chosen start_date
                    'before_or_equal:' . $attachment_student->end_date,
                ],
                'task_title' => 'required|string|max:255',
                'tasks' => 'required|string',
                'skills_learned' => 'required|string',
                'challenges' => 'nullable|string',
            ]);
            $weekGen = new GenerateWeekNumber();
            $uniqueWeekId = $weekGen->weekId($validated['start_date']);
            $weekly_report = WeeklyReport::where('week_id', $uniqueWeekId)
                ->where('attachment_student_id', $attachment_student_id)
                ->first();

            if (!$weekly_report) {

                $week_range = $weekGen->weekRangeFromId($uniqueWeekId);

                $weekly_report = new WeeklyReport();
                $weekly_report->attachment_student_id = $attachment_student_id;
                $weekly_report->week_start_date = $week_range['start'];
                $weekly_report->week_end_date = $week_range['end'];
                $weekly_report->week_id = $uniqueWeekId;
                $weekly_report->save();
            }
            $validated['weekly_report_id'] = $weekly_report->id;

            if (!empty($validated['daily_report_id'])) {

                // Get the report using the ID
                $report = DailyReport::findOrFail($validated['daily_report_id']);

                // Remove the key before update
                unset($validated['daily_report_id']);

                // Update
                $report->update($validated);

                // After update, the updated report *is still in $report*
                $daily_report = $report;

            } else {

                // Remove the unused key
                unset($validated['daily_report_id']);

                // Create new
                $daily_report = DailyReport::create($validated);
            }

// Prepare the response data
            $data = collect([
                $this->calenderResponse($daily_report->id, 'daily'),
                $this->calenderResponse($weekly_report->id, 'weekly'),
            ]);




            return response()->json([
                'status'  => 'success',
                'message' => 'Daily activity recorded successfully.',
                'data'    => $data
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation failed.',
                'errors'  => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong. Please try again later.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function storeStudentWeeklyReport(Request $request)
    {
        try {
            $validated = $request->validate([
                                    'weekly_report_id' => 'required|exists:weekly_reports,id',
                                    'weekly_report' => 'required|string|max:255',
                                ]);
            WeeklyReport::find($validated['weekly_report_id'])
                          ->update([
                                'weekly_report' => $validated['weekly_report'],
                            ]);
            $data = collect([
                $this->calenderResponse($validated['weekly_report_id'], 'weekly'),
            ]);
            return response()->json([
                'status'  => 'success',
                'message' => 'Weekly Report Saved.',
                'data'    => $data
            ]);
        }
        catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
            'status'  => 'error',
            'message' => 'Validation failed.',
            'errors'  => $e->errors()
            ], 422);

            }
            catch (\Exception $e) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Something went wrong. Please try again later.',
                    'error'   => $e->getMessage()
                ], 500);
            }
    }

    public function storeLecturerWeeklyReport(Request $request)
    {
        try {
            $validated = $request->validate([
                                    'weekly_report_id' => 'required|exists:weekly_reports,id',
                                    'lecturer_comment' => 'required|string|max:255',
                                ]);
            WeeklyReport::find($validated['weekly_report_id'])
                          ->update([
                                'lecturer_comment' => $validated['lecturer_comment'],
                            ]);
            $data = collect([
                $this->calenderResponse($validated['weekly_report_id'], 'weekly'),
            ]);
            return response()->json([
                'status'  => 'success',
                'message' => 'Weekly Report Saved.',
                'data'    => $data
            ]);
        }
        catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
            'status'  => 'error',
            'message' => 'Validation failed.',
            'errors'  => $e->errors()
            ], 422);

            }
            catch (\Exception $e) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Something went wrong. Please try again later.',
                    'error'   => $e->getMessage()
                ], 500);
            }
    }

    public function storeIndustrialSupervisorWeeklyReport(Request $request)
    {
        try {
            $validated = $request->validate([
                                    'weekly_report_id' => 'required|exists:weekly_reports,id',
                                    'industrial_supervisor_comment' => 'required|string|max:255',
                                ]);
            WeeklyReport::find($validated['weekly_report_id'])
                          ->update([
                                'industrial_supervisor_comment' => $validated['industrial_supervisor_comment'],
                            ]);
            $data = collect([
                $this->calenderResponse($validated['weekly_report_id'], 'weekly'),
            ]);
            return response()->json([
                'status'  => 'success',
                'message' => 'Weekly Report Remarks Saved.',
                'data'    => $data
            ]);
        }
        catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
            'status'  => 'error',
            'message' => 'Validation failed.',
            'errors'  => $e->errors()
            ], 422);

            }
            catch (\Exception $e) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Something went wrong. Please try again later.',
                    'error'   => $e->getMessage()
                ], 500);
            }
    }
}
