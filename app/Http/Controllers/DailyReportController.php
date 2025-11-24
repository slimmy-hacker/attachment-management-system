<?php

namespace App\Http\Controllers;

use App\GenerateWeekNumber;
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
    public function index(Request $request)
    {
        $attachment_student_id = $request->session()->get('attachment_student_id');
        $weekly_reports = WeeklyReport::where('attachment_student_id', $attachment_student_id)->get();
        $weekly_events =
            $weekly_reports ->map(function ($event) {
                return [
                    'id' => $event->week_id,
                    'title' => $event->status,
                    'start' => $event->week_start_date,
                    'end' => Carbon::parse($event->week_end_date)->addDay()->toDateString(),
                    'status' => $event->status,
                    'weekly_report' => $event->weekly_report,
                    'industrial_supervisor_comment' => $event->industrial_supervisor_comment,
                    'lecturer_comment' => $event->lecturer_comment,
                    'type'=>'weekly',
                     'color' => '#28a745',
                ];
            });
        $daily_events = DailyReport::whereIn('weekly_report_id', $weekly_reports->pluck('id'))
            ->get()
            ->map(function ($event) {
            return [
                'id'          => $event->id,
                'title'       => $event->task_title,
                'start' =>$event->start_date,
                'end' => Carbon::parse($event->end_date)->addDay()->toDateString(),
                'tasks'       => $event->tasks,
                'skills_learned' => $event->skills_learned,
                'challenges'  => $event->challenges,
                'type'        => 'daily'
            ];
        });
        $events = $weekly_events->merge($daily_events);
        return view('daily_activities.index', compact('events'));

    }
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'daily_report_id' => 'nullable|exists:daily_reports,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'task_title' => 'required|string|max:255',
                'tasks' => 'required|string',
                'skills_learned' => 'required|string',
                'challenges' => 'nullable|string',
            ]);
            $weekGen = new GenerateWeekNumber();
            $uniqueWeekId = $weekGen->weekId($validated['start_date']);
            $weekly_report = WeeklyReport::where('week_id', $uniqueWeekId)
                ->where('attachment_student_id', $request->session()->get('attachment_student_id'))
                ->first();

            if (!$weekly_report) {

                $week_range = $weekGen->weekRangeFromId($uniqueWeekId);

                $weekly_report = new WeeklyReport();
                $weekly_report->attachment_student_id = $request->session()->get('attachment_student_id');
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
            $data = [
                [
                'id'             => $daily_report->id,
                'title'          => $daily_report->task_title,
                'start'          => $daily_report->start_date,
                'end'            => $daily_report->end_date,
                'tasks'          => $daily_report->tasks,
                'skills_learned' => $daily_report->skills_learned,
                'challenges'     => $daily_report->challenges,
                    ],
                [
                            'id' => $weekly_report->week_id,
                            'title' => $weekly_report->status,
                            'start' => $weekly_report->week_start_date,
                            'end' => Carbon::parse($weekly_report->week_end_date)->addDay()->toDateString(),
                            'status' => $weekly_report->status,
                            'weekly_report' => $weekly_report->weekly_report,
                            'industrial_supervisor_comment' => $weekly_report->industrial_supervisor_comment,
                            'lecturer_comment' => $weekly_report->lecturer_comment,
                            'type'=>'weekly',
                            'color' => '#28a745',
                ]
            ];



            return response()->json([
                'status'  => 'success',
                'message' => 'Calender entry created successfully.',
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
}
