<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\GroupController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('lobby');
});

//this route is only for testing purpose :)
Route::get('/testout', function () {
    return view('/licenses/testout');
});

Route::get('/dashboard', function () {
    return view('counter');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/licenses', [LicenseController::class, 'index'])->name('licenses.index');
    Route::get('/licenses/create', [LicenseController::class, 'create']);
    Route::post('/licenses', [LicenseController::class, 'store']);
    Route::delete('/licenses/{license_id}', [LicenseController::class, 'destroy']);
    Route::get('/licenses/{license_id}/edit', [LicenseController::class, 'edit']);
    Route::put('/licenses/{license_id}', [LicenseController::class, 'update']);
    Route::get('/licenses/export/{format}', [LicenseController::class, 'exportListLicense'])->name('exportListLicense');
    Route::delete('licenses/{license}/force-delete', [LicenseController::class, 'destroy'])->name('licenses.force-delete');
    Route::get('licenses/restore/{license}', [LicenseController::class, 'restore'])->name('licenses.restore');
    Route::resource('licenses', LicenseController::class);


    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [ProjectController::class, 'create']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::delete('/projects/{project_id}', [ProjectController::class, 'destroy']);
    Route::get('/projects/{project_id}/edit', [ProjectController::class, 'edit']);
    Route::put('/projects/{project_id}', [ProjectController::class, 'update']);
    Route::get('/projects/export/{format}', [ProjectController::class, 'exportList'])->name('exportList');
    Route::delete('projects/{project}/force-delete', [ProjectController::class, 'destroy'])->name('projects.force-delete');
    Route::get('projects/restore/{project}', [ProjectController::class, 'restore'])->name('projects.restore');
    Route::resource('projects', ProjectController::class);


    Route::resource('groups', GroupController::class);
    Route::get('/groups/{group}/restore', [GroupController::class, 'restore'])->name('groups.restore');
    //Route::get('groups/restore/{group}', [GroupController::class, 'restore'])->name('groups.restore');
    Route::get('/groups/export/{format}', [GroupController::class, 'exportListGroup'])->name('exportListGroup');


    Route::get('/counter', function () {return view('counter');});

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';