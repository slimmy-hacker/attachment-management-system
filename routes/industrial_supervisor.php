<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndustrialSupervisorApprovalController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AttachmentAssessmentController;
use App\Http\Controllers\IndustrialSupervisorController;



Route::get('/portal', function () {
    return view('industry.portal');
})->name('industrial_supervisor.portal');


Route::get('/approvals', [IndustrialSupervisorApprovalController::class, 'index'])
    ->name('industrial_supervisor.approvals.index');

Route::post('/approvals/store', [IndustrialSupervisorApprovalController::class, 'store'])
    ->name('industrial_supervisor.approvals.store');
  
Route::get('/industrial-supervisor/assessment', 
    [AttachmentAssessmentController::class, 'createIndustrial'])->name('industrial_supervisor.assessment');



Route::post('/industrial-supervisor/assessment/store', 
    [AttachmentAssessmentController::class, 'storeIndustrial'])->name('industrial_supervisor.assessment.store');

   Route::get('/industrial-supervisor/assessment', 
        [AttachmentAssessmentController::class, 'listStudents'])
        ->name('industrial_supervisor.assessment.students_list');

    Route::get('/industrial-supervisor/assessment', 
        [AttachmentAssessmentController::class, 'createIndustrial'])
        ->name('industrial_supervisor.assessment');

    Route::post('/industrial-supervisor/assessment/store', 
        [AttachmentAssessmentController::class, 'storeIndustrial'])
        ->name('industrial_supervisor.assessment.store');
         
    Route::get('/industrial-supervisor/assessment/students', 
        [AttachmentAssessmentController::class, 'listStudents'])
        ->name('industrial_supervisor.assessment.students_list');
       // Route::get('/cal', [CalController::class, 'index'])->name('cal.index');
        Route::get('/industrial-supervisor/attaches', [IndustrialSupervisorController::class, 'attaches']) ->name('industrial_supervisor.attaches');
           
            