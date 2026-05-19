<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\IndustrialSupervisorController;

use App\Http\Controllers\OpportunityController;

Route::name('company.')->group(function () {
    Route::get('/portal', [CompanyController::class, 'portal'])->name('portal');
    Route::get('/students', [CompanyController::class, 'students'])->name('students');
    Route::get('/documents', [CompanyController::class, 'documents'])->name('documents');
    Route::get('/students', [CompanyController::class, 'students'])->name('students');
    Route::get('/opportunities', [CompanyController::class, 'opportunities'])->name('opportunities');
    Route::get('/opportunities/create', [CompanyController::class, 'createOpportunity'])
    ->name('opportunities.create');


Route::post('/opportunities', [CompanyController::class, 'storeOpportunity'])
    ->name('opportunities.store');


Route::get('/opportunities/{id}/edit', [CompanyController::class, 'editOpportunity'])
    ->name('opportunities.edit');


Route::put('/opportunities/{id}', [CompanyController::class, 'updateOpportunity'])
    ->name('opportunities.update');
Route::delete('/opportunities/{id}', [CompanyController::class, 'destroy'])
    ->name('opportunities.destroy');

Route::get('/documents', [CompanyController::class, 'documents'])->name('documents');

;


    Route::get('/reports', [CompanyController::class, 'reports'])->name('reports');

    Route::get('/supervisors', [IndustrialSupervisorController::class, 'index'])->name('is.index');
    Route::post('/supervisors/store', [IndustrialSupervisorController::class, 'store'])->name('is.store');
});



Route::get('/opportunities', [OpportunityController::class, 'index'])->name('company.opportunities.index');
    
    Route::post('/opportunities', [OpportunityController::class, 'store'])->name('opportunities.store');
    Route::get('/my-opportunities', [OpportunityController::class, 'myOpportunities'])->name('opportunities.my');
    Route::delete('/opportunities/{opportunity}', [OpportunityController::class, 'destroy'])->name('opportunities.destroy');
