<?php

use App\Http\Controllers\InternController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
})->name('dashboard');

Route::get('/interns', [InternController::class, 'index'])->name('intern.index');
Route::post('/intern/store',[InternController::class, 'store'])->name('intern.store');

Route::get('/intern/{id}/edit', [InternController::class, 'edit'])->name('intern.edit');
Route::put('/intern/{id}/update', [InternController::class, 'update'])->name('intern.update');

// Route::resource('/news', InternController::class);