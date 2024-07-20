<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DegreeProgrammeController;
use App\Http\Controllers\LearningMaterialsController;
use App\Http\Controllers\STLearningMaterialsController;

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

Route::get('/dash', function () {
    return view('layouts.auth');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.view');
});







// pdf management
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/upload', [LearningMaterialsController::class, 'index'])->name('upload.view');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/view', [LearningMaterialsController::class, 'view'])->name('upload.viewPage');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::post('/upload', [LearningMaterialsController::class, 'upload'])->name('upload.store');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::delete('/upload/{id}', [LearningMaterialsController::class, 'destroy'])->name('upload.destroy');
});

Route::post('/materials/approve/{id}', [LearningMaterialsController::class, 'approve'])->name('materials.approve');
Route::post('/materials/reject/{id}', [LearningMaterialsController::class, 'reject'])->name('materials.reject');
Route::post('/materials/pending/{id}', [LearningMaterialsController::class, 'pending'])->name('materials.pending');

// Degree API
Route::get('/degree-programmes/{id}/subjects', [DegreeProgrammeController::class, 'getSubjects']);



Route::get('/student-dashboard', [STLearningMaterialsController::class, 'index']);
Route::get('/student-view', [STLearningMaterialsController::class, 'view']);
Route::post('/student-dashboard', [STLearningMaterialsController::class, 'upload'])->name('StUpload.store');

// Category management
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/category', [CategoryController::class, 'index'])->name('category.view');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::put('/category/{id}', [CategoryController::class, 'update'])->name('category.update');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
});

