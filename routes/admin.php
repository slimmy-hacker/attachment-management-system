<?php
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Admin\AttachmentController;
use App\Http\Controllers\AttachmentLecturerController;
use App\Http\Controllers\AttachmentStudentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\AdministrativeUnitController;
use Illuminate\Support\Facades\Route;



Route::get('portal', function () {
    return view('admin.portal');
})->name('admin.portal');

Route::get('attarchment-schedules/index', [AttachmentController::class, 'index'])->name('admin.attachment_schedules.index');


Route::post('attarchment-schedules/store', [AttachmentController::class, 'store'])->name('admin.attachment_schedule.store');
   Route::get('/locations', [LocationController::class, 'index'])->name('locations');

    Route::post('/locations/upload', [LocationController::class, 'upload'])->name('admin.locations.upload');
Route::get('/locations', [LocationController::class, 'index'])->name('admin.locations.index');

Route::get('attarchment-schedules-supervisors/index', [AttachmentLecturerController::class, 'index'])->name('admin.attachment_schedules.supervisors.index');

Route::post('attachment-schedules-supervisors/upload', [AttachmentLecturerController::class, 'upload'])->name('admin.attachment_schedules.supervisors.upload');

Route::get('attarchment-schedules-students/index', [AttachmentStudentController::class, 'index'])->name('admin.attachment_student.index');

Route::post('attachment-schedules-students/upload', [AttachmentStudentController::class, 'upload'])->name('admin.attachment_student.upload');
Route::get('budgets', [AdminController::class, 'budgets'])->name('admin.budgets');
Route::post('budgets', [AdminController::class, 'storeBudget'])->name('admin.budgets.store');

Route::get('budgets/{id}', [AdminController::class, 'showBudget'])
    ->name('admin.budgets.show');

Route::get('students', [StudentController::class, 'index'])
    ->name('admin.student.index');

Route::post('upload-students', [StudentController::class, 'upload'])
    ->name('admin.student.upload');

Route::get('/lecturers', [LecturerController::class, 'index'])
    ->name('admin.lecturers.index');

Route::post('upload-lecturers', [LecturerController::class, 'upload'])
    ->name('admin.lecturers.upload');

  
    Route::post('/administrative-units/upload', [AdministrativeUnitController::class, 'upload'])->name('admin.administrative-units.upload');


Route::post('/administrative-units/upload', [AdministrativeUnitController::class, 'upload'])->name('admin.administrative-units.upload');

Route::get('/administrative-units', [AdministrativeUnitController::class, 'index'])->name('admin.administrative-units.index');

    Route::delete('budgets/{id}', [AdminController::class, 'destroyBudget'])->name('admin.budgets.destroy');

Route::post('admin/locations/add', [LocationController::class, 'add'])->name('admin.locations.add');
Route::post('attachment-student/add', [AttachmentStudentController::class, 'add'])
    ->name('admin.attachment_student.add');
    Route::get('administrative-units', [AdministrativeUnitController::class, 'index'])->name('admin.administrative-units.index');
    Route::post('administrative-units', [AdministrativeUnitController::class, 'store'])->name('admin.administrative-units.store');
    Route::post('/administrative-units/store', [AdministrativeUnitController::class, 'store'])
    ->name('admin.administrative-units.store');
    // routes/web.php
Route::post('/admin/attachment-lecturers/add', [AttachmentLecturerController::class, 'store'])
    ->name('admin.attachment_lecturers.add');
