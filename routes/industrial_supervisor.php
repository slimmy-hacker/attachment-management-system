<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndurstrialSupervisorApprovalController;
Route::get('/portal', function () {
return view('industry.portal');
})->name('industrial_supervisor.portal');

Route::get('/ind-sup/approval/index', [IndurstrialSupervisorApprovalController::class, 'index'])->name('indur.student.calender');
Route::post('/ind-sup/approval/store', [IndurstrialSupervisorApprovalController::class, 'store'])->name('in.sup.store');
