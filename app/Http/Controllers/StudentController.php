<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{

    public function showAttachmentForm()
    {
        return view('student.attachment-form');
    }

    public function storeAttachmentForm(Request $request)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'reg_no' => 'required|string|max:100',
            'course' => 'required|string|max:100',
            'student_phone' => 'required|string|max:20',
            'student_email' => 'required|email',

            'organization' => 'required|string|max:255',
            'date_commenced' => 'required|date',
            'date_finished' => 'required|date|after_or_equal:date_commenced',
            'town' => 'required|string|max:100',
            'street' => 'required|string|max:100',
            'building' => 'required|string|max:100',
            'supervisor_name' => 'required|string|max:255',
            'supervisor_phone' => 'required|string|max:20',
            'supervisor_email' => 'required|email',
        ]);


        return redirect()->back()->with('success', 'Attachment form submitted successfully!');
    }

    public function reports()
{
    return view('student.reports');
}
  public function logbook()
   {

    return view ('student.logbook');
   }
}
