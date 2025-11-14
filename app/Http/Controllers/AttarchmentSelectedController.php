<?php

namespace App\Http\Controllers;

use App\Models\AttachmentSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttarchmentSelectedController extends Controller
{
    public function index()
    {
        $periods = AttachmentSchedule::orderBy('start_date', 'desc')->get();
        return view('attarchment_selected.index', compact('periods'));
    }

    public function store(Request $request)
    {
        try {
            if (Auth::user()->role == 'student') {
                $request->validate([
                    'period_id' => 'required|exists:attachment_students,id',
                ]);
            } else {
                $request->validate([
                    'period_id' => 'required|exists:attachment_schedule,id',
                ]);
            }

            // Proceed normally if validation passes
            session(['selected_period_id' => $request->period_id]);

            return redirect()->route('dashboard')->with([
                'notification' => [
                    'icon' => 'success',
                    'title' => 'Success',
                    'message' => 'Attachment period selected successfully.'
                ]
            ]);

        } catch (ValidationException $e) {
            // Validation failed
            return redirect()->back()->withInput()->with([
                'notification' => [
                    'icon' => 'error',
                    'title' => 'Something went wrong',
                    'message' => 'Please ensure you selected a valid attachment period.'
                ]
            ]);
        } catch (\Exception $e) {
            // Catch any other unexpected errors
            return redirect()->back()->with([
                'notification' => [
                    'icon' => 'error',
                    'title' => 'Error',
                    'message' => 'Something went wrong. Please try again later.'
                ]
            ]);
        }
    }

    public function change()
    {
        session()->forget('selected_period_id');
        return redirect()->route('period.select');
    }

    public function dashboard()
    {
        $period = AttachmentPeriod::find(session('selected_period_id'));
        return view('dashboard', compact('period'));
    }
}
