<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/ihbar', [\App\Http\Controllers\CitizenReportController::class, 'create'])->name('citizen.create');
Route::post('/ihbar', [\App\Http\Controllers\CitizenReportController::class, 'store'])->name('citizen.store');
Route::get('/ihbar/basarili/{trackingCode}', [\App\Http\Controllers\CitizenReportController::class, 'success'])->name('citizen.success');
Route::get('/ihbar/sorgula', [\App\Http\Controllers\CitizenReportController::class, 'trackForm'])->name('citizen.track-form');
Route::post('/ihbar/sorgula', [\App\Http\Controllers\CitizenReportController::class, 'track'])->name('citizen.track');

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('departments', \App\Http\Controllers\Admin\DepartmentController::class)
            ->except('show');

        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)
            ->except('show');
    });

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/tasks', [\App\Http\Controllers\TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [\App\Http\Controllers\TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [\App\Http\Controllers\TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}', [\App\Http\Controllers\TaskController::class, 'show'])->name('tasks.show');
    Route::patch('/tasks/{task}/status', [\App\Http\Controllers\TaskController::class, 'updateStatus'])->name('tasks.update-status');
    Route::delete('/tasks/{task}', [\App\Http\Controllers\TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::patch('/tasks/{task}/assign', [\App\Http\Controllers\TaskController::class, 'assign'])->name('tasks.assign');
    Route::get('/tasks/{task}/edit', [\App\Http\Controllers\TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [\App\Http\Controllers\TaskController::class, 'update'])->name('tasks.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';