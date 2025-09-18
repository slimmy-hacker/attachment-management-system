
<?php
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalenderController;
use App\Http\Controllers\LogbookController;

Route::get('/portal', function () {
    return view('student.portal');
})->name('student.portal');

Route::name('student.')->group(function () {
Route::get('/attachment-form', [StudentController::class, 'showAttachmentForm'])
->name('attachment-form');

Route::post('/attachment-form', [StudentController::class, 'storeAttachmentForm'])
->name('attachment-form.store');
    Route::get('/student/attachment-form', [StudentController::class, 'showAttachmentForm'])->name('attachment.form');
    Route::post('/student/attachment-form', [StudentController::class, 'submitAttachmentForm'])->name('attachment.form.submit');
    Route::get('/student/reports', [StudentController::class, 'reports'])->name('reports');
    Route::get('/student/logbook', [StudentController::class, 'logbook'])->name('logbook');
    Route::get('/student/results', [StudentController::class, 'results'])->name('results');

});

Route::post('/logbook', [LogbookController::class, 'store'])->name('logbook.store');

// View all logbook entries
Route::get('/logbook/entries', [LogbookController::class, 'index'])->name('logbook.index');

Route::get('/calendar', [CalenderController::class, 'index'])->name('cal.index');
Route::post('/calendar/store', [CalenderController::class, 'store'])->name('cal.store');

