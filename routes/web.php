<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TrackerController;
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
    Route::get('/licenses/exportList/{format}', [LicenseController::class, 'exportListLicense'])->name('exportListLicense');
    Route::delete('licenses/{license}/force-delete', [LicenseController::class, 'destroy'])->name('licenses.force-delete');
    Route::get('licenses/restore/{license}', [LicenseController::class, 'restore'])->name('licenses.restore');
    Route::resource('licenses', LicenseController::class);
    Route::get('/licenses/exportLog/{format}', [LicenseController::class, 'exportLogLicense'])->name('exportLogLicense');
    Route::get('/searchLicense', [LicenseController::class, 'searchLicense'])->name('searchLicense');



    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [ProjectController::class, 'create']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::delete('/projects/{project_id}', [ProjectController::class, 'destroy']);
    Route::get('/projects/{project_id}/edit', [ProjectController::class, 'edit']);
    Route::put('/projects/{project_id}', [ProjectController::class, 'update']);
    Route::get('/projects/exportList/{format}', [ProjectController::class, 'exportListProject'])->name('exportListProject');
    Route::delete('projects/{project}/force-delete', [ProjectController::class, 'destroy'])->name('projects.force-delete');
    Route::get('projects/restore/{project}', [ProjectController::class, 'restore'])->name('projects.restore');
    Route::resource('projects', ProjectController::class);
    Route::get('/projects/exportLog/{format}', [ProjectController::class, 'exportLogProject'])->name('exportLogProject');
    Route::get('/searchProject', [ProjectController::class, 'searchProject'])->name('searchProject');

    Route::resource('groups', GroupController::class);
    Route::get('/groups/{group}/restore', [GroupController::class, 'restore'])->name('groups.restore');
    Route::get('/groups/exportList/{format}', [GroupController::class, 'exportListGroup'])->name('exportListGroup');
    Route::get('/groups/exportLog/{format}', [GroupController::class, 'exportLogGroup'])->name('exportLogGroup');
    Route::get('groups/{group}/show_staff', [GroupController::class, 'show_staff'])->name('groups.show_staff');
    Route::get('/searchGroup', [GroupController::class, 'searchGroup'])->name('searchGroup');

    Route::post('/staffs/exportList', [StaffController::class, 'exportListStaff'])->name('exportListStaff');
    Route::get('/staffs/exportLog/{format}', [StaffController::class, 'exportLogStaff'])->name('exportLogStaff');
    Route::get('/staffs/no_group_staff', [StaffController::class, 'noGroupStaff'])->name('noGroupStaff');
    Route::resource('staffs', StaffController::class);
    Route::post('/staff', [StaffController::class, 'importStaff'])->name('staff.import');
    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
    Route::get('/searchStaff', [StaffController::class, 'searchStaff'])->name('searchStaff');

    Route::get('/tracker/form', [StaffController::class, 'showUploadForm'])->name('tracker.form');
    Route::post('/tracker/results', [StaffController::class, 'compareColumn'])->name('tracker.results');
    Route::get('/tracker/export/status/{format}', [StaffController::class, 'exportStatus'])->name('exportStatus');
    Route::get('/tracker/export/dept/{format}', [StaffController::class, 'exportDept'])->name('exportDept');

    Route::get('/counter', function () {return view('counter');});

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';