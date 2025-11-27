<?php

namespace App\Http\Controllers;

use App\Models\Calender;
use App\Models\WeeklyReport;
use App\Models\DailyReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\GenerateWeekNumber;

class IndustrialSupervisorApprovalController extends Controller
{
    public function index()
    {
        $weekGen = new GenerateWeekNumber();
        $uniqueWeekId = $weekGen->weekId(Carbon::now());

        $events = DailyReport::all()->map(function ($event) {
            return [
                'id'          => $event->id,
                'title'       => $event->task_title,   // FullCalendar uses this
                'start'       => $event->start_date,   // FullCalendar uses this
                'end'         => $event->end_date,     // FullCalendar uses this
                'week_id'     => 1,
            ];
        });
        return view('industrial_supervisor.index', compact('events' ));

    }
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'week_id'     => 'required|integer',
                'attarchee_id' => 'required|integer',
                'status'     => 'nullable|string',
                'Comments' => 'required|string',
            ]);


            $validated['start'] = 1;
            $validated['end'] = 1;


            $calender = WeeklyReport::create($validated);

            return response()->json([
                'status'  => 'success',
                'message' => 'Calender entry created successfully.',
                'data'    => $calender
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
