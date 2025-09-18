<?php
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StudentController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\CalenderController;
use App\Http\Controllers\IndurstrialSupervisorApprovalController;
use Illuminate\Support\Facades\Auth;
Route::get('/', function () {
    $user = Auth::user();
    if ($user) {
        return redirect()->route($user->role . '.portal');
    }
    return view('welcome');
})->name('welcome');
Route::get('/dash', function () {
    $user = Auth::user();

    return $user;
})->name('dashboard');

Route::get('/check-token', function () {
    return csrf_token();
});
//Route::middleware('guest')->group(function () {

//    Route::get('/register/{portal}', [RegisteredUserController::class, 'showRegisterForm'])
//        ->name('register.portal');
//
//// Handle registration form submission
//    Route::post('/register/{portal}', [RegisteredUserController::class, 'store'])
//        ->name('register.portal.store');
//
//    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
//        ->name('login');
//
//    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
//        ->name('login.portal.store');


//});
//Auth routes
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});


Route::middleware(['portal:student'])
    ->prefix('students')
    ->group(base_path('routes/student.php'));

Route::middleware(['portal:admin'])
    ->prefix('admin')
    ->group(base_path('routes/admin.php'));
require __DIR__.'/auth.php';
