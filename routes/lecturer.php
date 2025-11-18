<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LecturerController;

Route::get('portal', function () {
    return view('lecturer.portal');
})->name('lecturer.portal');

Route::name('lecturer.')->group(function () {
   Route::get('/students-assigned', [LecturerController::class, 'studentsAssigned'])
        ->name('students-assigned');


    Route::get('/reports', [LecturerController::class, 'reports'])
        ->name('reports');

    Route::get('/logbook', [LecturerController::class, 'logbook'])
        ->name('logbook');

    Route::get('/evaluate', [LecturerController::class, 'evaluate'])
        ->name('evaluate');
});
