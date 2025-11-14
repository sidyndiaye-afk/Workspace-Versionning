<?php

use App\Http\Controllers\Admin\OnasProjectController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OnasController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', [OnasController::class, 'dashboard'])->name('onas.dashboard');

Route::prefix('onas')->name('onas.')->group(function (): void {
    Route::redirect('/', '/');
    Route::get('/projets/{slug}', [OnasController::class, 'project'])->name('projects.show');
});

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/projects', [ProjectController::class, 'publicIndex'])->name('projects.public.index');
Route::get('/projects/{project:slug}', function (App\Models\Project $project) {
    return redirect()->route('onas.projects.show', $project->slug);
})->name('projects.public.show');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function (): void {
    Route::resource('projects', ProjectController::class)->except(['show']);
    Route::resource('onas-projects', OnasProjectController::class)->except(['show']);
});
