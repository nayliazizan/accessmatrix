<?php

use App\Http\Controllers\LicenseController;
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
    return view('welcome');
});
 
Route::get('/licenses', [LicenseController::class, 'index']);
Route::get('/licenses/create', [LicenseController::class, 'create']);
Route::post('/licenses', [LicenseController::class, 'store']);
Route::get('/licenses/{license_id}', [LicenseController::class, 'show']);
Route::delete('/licenses/{license_id}', [LicenseController::class, 'destroy']);

Route::get('/licenses/{license_id}/edit', [LicenseController::class, 'edit']);
Route::put('/licenses/{license_id}', [LicenseController::class, 'update']);


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
