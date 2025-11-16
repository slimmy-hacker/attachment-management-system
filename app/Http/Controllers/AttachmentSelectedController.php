<?php

namespace App\Http\Controllers;

use App\Models\AttachmentSchedule;
use App\Models\AttachmentSchoolSupervisor;
use App\Models\AttachmentStudent;
use App\Models\Company;
use App\Models\IndurstrialSupervisor;
use App\Models\Lecturer;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttachmentSelectedController extends Controller
{
    public function index()
    {
        $attachments = [];
        switch (Auth::user()->role) {
            case 'student':
                $student = Student::where('user_id', Auth::id())->first();
              $attachment_students =  AttachmentStudent::with('attachment')
                                                        ->where('reg_no', $student->reg_no)
                                                        ->get();
                return view('attachment_selected.students', compact('attachment_students'));
                break;

            case 'school_supervisor':
                    $supevisor = Lecturer::where('user_id', Auth::id())->first();
                   $attachment_supervisors = AttachmentSchoolSupervisor::with('attachment')
                                                                        ->where('staff_no', $supevisor->staff_no)
                                                                        ->get();

                    return view('attachment_selected.lecturers', compact('attachment_supervisors'));
                break ;
            case 'industrial_supervisor':

                $supervisor = IndurstrialSupervisor::where('user_id', Auth::id())->first();

                $attachment_slugs = AttachmentStudent::where('industrial_supervisor_id', $supervisor->id)
                    ->distinct('attachment_slug')
                    ->pluck('attachment_slug');
                $attachments = AttachmentSchedule::whereIn('attachment_slug', $attachment_slugs)
                    ->get();

                break;

            case 'company' :

                $company = Company::where('user_id', Auth::id())->first();


                $studentIds = AttachmentStudent::where('company_id', $company->id)
                    ->distinct('attachment_slug')
                    ->pluck('attachment_slug');
                $attachments = AttachmentSchedule::whereIn('id', $studentIds)
                    ->distinct()
                    ->get();
                break;


            default:
                $attachments = AttachmentSchedule::all();
                break;
        }


        return view('attachment_selected.index', compact('attachments'));
    }

    public function store(Request $request)
    {
        try {
            if (Auth::user()->role == 'student') {
                $request->validate([
                    'attachment_student_id' => 'required|exists:attachment_students,id',
                    'attachment_id' => 'required|exists:attachment_schedule,id',
                ]);
                session(['attachment_student_id' => $request->attachment_student_id]);
            } else {
                $request->validate([
                    'attachment_id' => 'required|exists:attachment_schedule,id',
                ]);
            }

            // Proceed normally if validation passes


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
