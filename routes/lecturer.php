<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LecturerController;
use App\Http\Controllers\AttachmentAssessmentController;

Route::get('portal', function () {
    return view('lecturer.portal');
})->name('lecturer.portal');


Route::middleware(['ensure.attachment.selected'])->name('lecturer.')->group(function () {
   


    Route::get('/reports', [LecturerController::class, 'reports'])
        ->name('reports');

    Route::get('/logbook', [LecturerController::class, 'logbook'])
        ->name('logbook');

    Route::get('/evaluate', [LecturerController::class, 'evaluate'])
        ->name('evaluate');
        Route::post('/assessment', [AttachmentAssessmentController::class, 'storeSchool'])->name('assessment');
         //Route::get('/lecturer/assessment/students', [AttachmentAssessmentController::class, 'listStudents'])->name('lecturer.assessment.students_list');
       
 

  Route::get('/my-students', [LecturerController::class, 'myStudents'])
        ->name('my-students');

    Route::get('/assessment/{studentId}', [AttachmentAssessmentController::class, 'createSchool'])
        ->name('lecturer.assessment.form');

    Route::post('/assessment', [AttachmentAssessmentController::class, 'storeSchool'])
        ->name('assessment.store');
       


});
