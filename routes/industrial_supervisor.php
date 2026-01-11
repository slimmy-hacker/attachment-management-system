<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DailyReportController;
use App\Http\Controllers\AttachmentAssessmentController;
use App\Http\Controllers\IndustrialSupervisorController;



Route::get('/portal', function () {
    return view('industry.portal');
})->name('industrial_supervisor.portal');
Route::middleware(['ensure.attachment.selected'])->group(function () {

    Route::get('/assessment',
        [AttachmentAssessmentController::class, 'createIndustrial'])
        ->name('industrial_supervisor.assessment');

    Route::post('/assessment/store',
        [AttachmentAssessmentController::class, 'storeIndustrial'])
        ->name('industrial_supervisor.assessment.store');

    Route::get('/assessment/students',
        [AttachmentAssessmentController::class, 'listStudents'])
        ->name('industrial_supervisor.assessment.students_list');
    Route::get('/attaches', [IndustrialSupervisorController::class, 'attaches'])->name('industrial_supervisor.attaches');

    Route::post('weekly-activities-store', [DailyReportController::class, 'storeIndustrialSupervisorWeeklyReport'])->name('industrial_supervisor.weekly_activities.store');
    Route::get('/weekly-reports', [IndustrialSupervisorController::class, 'weeklyReports'])
        ->name('industrial_supervisor.weekly-reports');

    // Update a specific weekly report (comment and approval)
    Route::put('/weekly-reports/{report}', [IndustrialSupervisorController::class, 'update'])
        ->name('industrial_supervisor.weekly-reports.update');
});

