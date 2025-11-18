
<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\IndurstrialSupervisorController;
use App\Http\Controllers\CompanyController;
<<<<<<< HEAD
use App\Http\Controllers\AttachmentSelectedController;
use App\Http\Controllers\AttarchmentSelectedController;

=======
use App\Http\Controllers\AttarchmentSelectedController;
>>>>>>> eeabcf49eea11f93c231154f3b5393a922c9a347


use App\Http\Controllers\OpportunityController;

Route::get('/', function () {
    if (Auth::check() && Auth::user()->role) {
        return redirect()->route(Auth::user()->role . '.portal');
    }
    return view('welcome');
})->name('welcome');


require __DIR__.'/auth.php';


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/companies', [CompanyController::class, 'companies'])->name('companies');
    Route::post('/companies', [CompanyController::class, 'storeCompany'])->name('companies.store');

    Route::get('get-company-industrial-supervisors/{id}', [IndurstrialSupervisorController::class, 'getCompanyIndustrialSupervisors'])->name('get_company_industrial_supervisors');


<<<<<<< HEAD

=======
>>>>>>> eeabcf49eea11f93c231154f3b5393a922c9a347
    Route::get('/select-attarchment', [AttarchmentSelectedController::class, 'index'])->name('attachment.select');
    Route::post('/attachment/select', [AttarchmentSelectedController::class, 'store'])->name('attachment.store');
    Route::post('/attachment/change', [AttarchmentSelectedController::class, 'change'])->name('attachment.change');

    Route::middleware(['ensure.period.selected'])->group(function () {
        Route::get('/dashboard', [AttarchmentSelectedController::class, 'dashboard'])->name('dashboard');
<<<<<<< HEAD

=======
>>>>>>> eeabcf49eea11f93c231154f3b5393a922c9a347
    });

});

Route::middleware(['auth'])->get('/opportunities', [OpportunityController::class, 'index'])->name('opportunities.index');

Route::middleware(['portal:student'])
    ->prefix('students')
    ->group(base_path('routes/student.php'));


Route::middleware(['portal:admin'])
    ->prefix('admin')
    ->group(base_path('routes/admin.php'));

    Route::middleware('guest')->group(function () {
        Route::get('/register/select-portal', function () {
            return view('auth.select-portal');
        })->name('register.select.portal');

        Route::get('/register/{portal}', [RegisteredUserController::class, 'showPortalForm'])
            ->where('portal', 'student|supervisor|industry|company')
            ->name('register.portal');

        Route::post('/student/register', [RegisteredUserController::class, 'storeStudent'])
                        ->name('register.portal.student');

        Route::post('/register/{portal}', [RegisteredUserController::class, 'storePortal'])
            ->where('portal', 'student|supervisor|industry|company')
            ->name('register.portal.store');


        // --- Test route ---
        Route::get('/test-tailwind', function () {
            return view('test-tailwind');
        });
        Route::get('/login/{portal}', [AuthenticatedSessionController::class, 'create'])
    ->name('portal.login');
    });

    Route::get('/opportunities/{opportunity}/apply', [OpportunityController::class, 'showApplyForm'])->name('opportunities.apply');
Route::post('/opportunities/{opportunity}/apply', [OpportunityController::class, 'submitApplication'])->name('opportunities.apply');
Route::post('/opportunities/{opportunity}/apply', [OpportunityController::class, 'submitApplication'])->name('opportunities.apply.submit');
Route::get('/opportunities/{opportunity}/applications', [OpportunityController::class, 'showApplications']) ->name('opportunities.applications');
