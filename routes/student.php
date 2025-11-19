
<?php
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalenderController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\AttachmentDetailsController;


Route::get('/portal', function () {
    return view('student.portal');
})->name('student.portal');
Route::middleware(['ensure.attachment.selected'])->group(function () {
    Route::name('student.')->group(function () {
        Route::get('/attachment-form', [AttachmentDetailsController::class, 'edit'])
            ->name('attachment-form');

        Route::post('/attachment-form', [AttachmentDetailsController::class, 'update'])
            ->name('attachment-form.store');
        Route::post('/register/student', [RegisteredUserController::class, 'student'])
            ->name('register.student');
        Route::get('/student/reports', [StudentController::class, 'reports'])->name('reports');
        Route::get('/student/logbook', [StudentController::class, 'logbook'])->name('logbook');
        Route::get('/student/results', [StudentController::class, 'results'])->name('results');
        Route::get('/student/companies', [StudentController::class, 'companies'])->name('companies');
        Route::post('/student/companies', [StudentController::class, 'storeCompany'])->name('companies.store');

    });

    Route::post('/logbook', [LogbookController::class, 'store'])->name('logbook.store');

// View all logbook entries
    Route::get('/logbook/entries', [LogbookController::class, 'index'])->name('student.logbook.index');

    Route::get('/calendar', [CalenderController::class, 'index'])->name('cal.index');
    Route::post('/calendar/store', [CalenderController::class, 'store'])->name('cal.store');
});
Route::get('reports', [StudentController::class, 'reportForm'])->name('student.reports.form');
Route::post('reports', [StudentController::class, 'storeReport'])->name('student.reports.store');
Route::get('final-report', [StudentController::class, 'finalReportForm'])->name('student.finalReport.form');
Route::post('final-report', [StudentController::class, 'storeFinalReport'])->name('student.finalReport.store');
Route::get('/opportunities', [OpportunityController::class, 'index'])->name('opportunities.index');
