<?php
use Illuminate\Support\Facades\Route;


Route::get('portal', function () {
    return view('supervisor.portal');
})->name('school_supervisor.portal');

Route::name('supervisor.')->group(function () {
    Route::get('/students-assigned', [SupervisorController::class, 'studentsAssigned'])
        ->name('students-assigned');

    Route::get('/reports', [SupervisorController::class, 'reports'])
        ->name('reports');

    Route::get('/logbook', [SupervisorController::class, 'logbook'])
        ->name('logbook');

    Route::get('/evaluate', [SupervisorController::class, 'evaluate'])
        ->name('evaluate');
});
