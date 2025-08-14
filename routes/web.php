<?php

use App\Http\Controllers\InternController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});




Route::get('/scan-devices', function () {
    $command = "arp -a";  // Ping scan in grepable format

    $output = shell_exec($command);

    return $output;
});



Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
})->name('dashboard');

Route::get('/interns', [InternController::class, 'index'])->name('intern.index');
Route::post('/intern/store',[InternController::class, 'store'])->name('intern.store');

// Route::resource('intern', InternController::class);