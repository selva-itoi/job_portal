<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\ProfileController;

Route::get('/', [Controllers\JobsController::class, 'index'])
    ->name('jobs.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/new', [Controllers\JobsController::class, 'create'])
    ->name('jobs.create');

Route::post('/new', [Controllers\JobsController::class, 'store'])
    ->name('jobs.store');

Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
    return view('dashboard', [
        'jobs' => $request->user()->jobs
    ]);
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::get('/{jobs}', [Controllers\JobsController::class, 'show'])
    ->name('jobs.show');

Route::get('/{jobs}/apply', [Controllers\JobsController::class, 'apply'])
    ->name('jobs.apply');

Route::post('token', [Controllers\JobsController::class, 'saveToken'])
    ->name('save.token');
