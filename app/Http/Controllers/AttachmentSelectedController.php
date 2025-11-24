<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\AttachmentLecturer;
use App\Models\AttachmentStudent;
use App\Models\Company;
use App\Models\IndustrialSupervisor;
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
                $attachment_students = AttachmentStudent::with('attachment')
                    ->join('attachments', 'attachments.id', '=', 'attachment_students.attachment_id')
                    ->where('attachment_students.student_id', $student->id)
                    ->orderBy('attachments.start_date', 'DESC')
                    ->select('attachment_students.*')
                    ->get();

                return view('attachment_selected.students', compact('attachment_students'));
                break;

            case 'lecturer':
                    $lecturer = Lecturer::where('user_id', Auth::id())->first();
                   $attachment_lecturers = AttachmentLecturer::with('attachment')
                                                                        ->where('lecturer_id', $lecturer->id)
                                                                        ->get();

                    return view('attachment_selected.lecturers', compact('attachment_lecturers'));
                break ;
            case 'industrial_supervisor':

                $supervisor = IndustrialSupervisor::where('user_id', Auth::id())->first();

                $attachment_ids = AttachmentStudent::where('industrial_supervisor_id', $supervisor->id)
                    ->distinct('attachment_id')
                    ->pluck('attachment_id');
                $attachments = Attachment::whereIn('attachment_id', $attachment_ids)
                    ->get();

                break;

            case 'company' :

                $company = Company::where('user_id', Auth::id())->first();


                $attachment_ids = AttachmentStudent::where('company_id', $company->id)
                    ->distinct('attachment_id')
                    ->pluck('attachment_id');
                $attachments = Attachment::whereIn('id', $attachment_ids)
                    ->distinct()
                    ->get();
                break;


            default:
                $attachments = Attachment::orderBy('start_date', 'desc')->get();
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
                    'attachment_id' => 'required|exists:attachments,id',
                    'attachment_name' => 'required',
                ]);
                session(['attachment_student_id' => $request->get('attachment_student_id'), 'attachment_id'=> $request->get('attachment_id'), 'attachment_name'=> $request->get('attachment_name')]);
            }
            elseif (Auth::user()->role == 'lecturer') {
                $request->validate([
                    'attachment_lecturer_id' => 'required|exists:attachment_lecturers,id',
                    'attachment_id' => 'required|exists:attachments,id',
                    'attachment_name' => 'required',
                ]);
                session(['attachment_lecturer_id' => $request->get('attachment_lecturer_id'), 'attachment_id'=> $request->get('attachment_id'), 'attachment_name'=> $request->get('attachment_name')]);
            }
            else {
                $request->validate([
                    'attachment_id' => 'required|exists:attachments,id',
                ]);
            }

            // Proceed normally if validation passes

            return redirect()->back()->withInput()->with([
                'notification' => [
                    'icon' => 'success',
                    'title' => 'Success',
                    'message' => 'Attachment period selected successfully.'
                ]
            ]);

        } catch (ValidationException $e) {
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
       dd('Mkenya');
    }
}
