<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::redirect('/', '/login');
// Route::view('/home', 'layouts.app');
Route::redirect('/home', '/dashboard');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource("/users", UserController::class);
    Route::put('/users/{user}/restore', [UserController::class, "restore"])->name('restore');

    Route::resource("/accounts", AccountController::class);
    Route::put('/accounts/{account}/restore', [AccountController::class, "restore"])->name('restore');

    Route::resource("/roles", RoleController::class);
    Route::put('/roles/{role}/restore', [RoleController::class, "restore"])->name('restore');

    Route::resource("/permissions", PermissionController::class);
    Route::put('/permissions/{permission}/restore', [PermissionController::class, "restore"])->name('restore');

});
