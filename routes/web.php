<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\InternController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/login', function () {
//     return view('auth.login');
// })->name('login');

// Authentication Routes
Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.dashboard');
    })->name('dashboard');

    Route::get('/interns', [InternController::class, 'index'])->name('intern.index');
    Route::post('/intern/store',[InternController::class, 'store'])->name('intern.store');

    Route::get('/intern/{id}/edit', [InternController::class, 'edit'])->name('intern.edit');
    Route::put('/intern/{id}/update', [InternController::class, 'update'])->name('intern.update');
    Route::get('intern/{id}', [InternController::class, 'show'])->name('intern.show');
    Route::delete('/intern/{id}/delete', [InternController::class, 'destroy'])->name('intern.delete');

    // Route::resource('/news', InternController::class);

    Route::get('interns/export', [InternController::class, 'export'])->name('interns.export');
    Route::get('interns/export/pdf', [InternController::class, 'exportPdf'])->name('interns.export.pdf');
    Route::get('intern/{id}/attendance/export', [AttendanceController::class, 'export'])->name('intern.attendance.export');
});
