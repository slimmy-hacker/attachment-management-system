<?php

namespace App\Http\Controllers;

use App\GenerateWeekNumber;
use App\Models\Calender;
use Illuminate\Http\Request;
use App\Models\Logbook;
use Illuminate\Support\Facades\Auth;

class LogbookController extends Controller
{
    /**
     * Show the user's logbook entries.
     * @return \Illuminate\View\View
     */

    public function index()
    {
        // Get the ID of the currently authenticated user
        $userId = Auth::id();

        // Fetch all logbook entries for this user from the database.
        // We order them by creation date so the newest entries are at the top.
        $logbooks = Logbook::where('registration_number', $student->registration_number)
                    ->orderBy('created_at', 'desc')
                    ->get();


        // Pass the fetched data to the logbook view.
        // The `compact('logbooks')` is a shortcut for ['logbooks' => $logbooks].
        return view('logbooks.index', compact('logbooks'));
    }

    /**
     * Store a new logbook entry.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function calender()
    {
        $my_indurstrial_supervisor_id = 5;
        $events = Calender::all()->map(function ($event) {
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



            $calender = Calender::create($validated);

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
