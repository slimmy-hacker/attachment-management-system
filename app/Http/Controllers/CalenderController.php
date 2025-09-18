<?php

namespace App\Http\Controllers;

use App\GenerateWeekNumber;
use App\Models\Logbook;
use Illuminate\Http\Request;


class CalenderController extends Controller
{
    public function index()
    {
        $my_indurstrial_supervisor_id = 5;
        $events = Logbook::all()->map(function ($event) {
            return [
                'id'          => $event->id,
                'title'       => $event->task_title,   // FullCalendar uses this
                'start'       => $event->start_date,   // FullCalendar uses this
                'end'         => $event->end_date,     // FullCalendar uses this

                // 👇 These will show up in extendedProps
                'tasks'       => $event->tasks,
                'skills_learned' => $event->skills_learned,
                'challenges'  => $event->challenges,
                'status'      => $event->status ?? null,
                'indurstrial_supervisor_id'  => $event->indurstrial_supervisor_id
            ];
        });
        return view('calendar.index', compact('events', 'my_indurstrial_supervisor_id'));

    }
    public function store(Request $request)
    {
        try {
            // ✅ Validate only form fields
            $validated = $request->validate([
                'start_date'     => 'required|date',
                'end_date'       => 'required|date|after_or_equal:start_date',
                'task_title'     => 'required|string|max:255',
                'tasks'          => 'required|string',
                'skills_learned' => 'required|string',
                'challenges'     => 'nullable|string',
                'indurstrial_supervisor_id' => 'required|integer',
            ]);
            $week = $weekGen = new GenerateWeekNumber();
            $uniqueWeekId = $weekGen->weekId($validated['start_date']);


            $validated['student_id'] = 1;
            $validated['attachment_id'] = 1;
            $validated['week_id'] = $uniqueWeekId;



            $calender = Logbook::create($validated);

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
