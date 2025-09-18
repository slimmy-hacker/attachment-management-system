<?php
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('portal', function () {
    return view('admin.portal');
})->name('admin.portal');
