<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\aiPDFController;
use App\Http\Controllers\EbookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AddSubjectDegController;
use App\Http\Controllers\EbookCategoryController;
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

Route::redirect('/', destination: 'login');
// Route::get('/dash', function () {
//     return view('layouts.auth');
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'AdminRedirect',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

#admin routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'admin',
])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.view');
    Route::get('/admin-add', [AdminController::class, 'AdminAdd'])->name('admin.add');
    Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin-edit/{id}', [AdminController::class, 'AdminEditPage'])->name('admin.EditPage');
    Route::patch('/admin-edit/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
});

// degreeEdit
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'admin',
])->group(function () {
    Route::get('/degree-programmes', [AddSubjectDegController::class, 'show'])->name('degree.show');
    Route::get('/degree-programmes/add', [AddSubjectDegController::class, 'add'])->name('degree.add');
    Route::post('/degree-programmes', [AddSubjectDegController::class, 'store'])->name('degree.store');
    Route::post('/degree-programmes-subjects', [AddSubjectDegController::class, 'SubjectStore'])->name('degree.SubjectStore');

});


// pdf management routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'admin',
])->group(function () {
    Route::get('/upload', [LearningMaterialsController::class, 'index'])->name('upload.view');
    Route::get('/view', [LearningMaterialsController::class, 'view'])->name('upload.viewPage');
    Route::post('/upload', [LearningMaterialsController::class, 'upload'])->name('upload.store');
    Route::get('/view/edit/{id}', [LearningMaterialsController::class, 'EditView'])->name('upload.EditPage');
    Route::patch('/view/edit/{id}', [LearningMaterialsController::class, 'update'])->name('upload.update');
    Route::delete('/upload/{id}', [LearningMaterialsController::class, 'destroy'])->name('upload.destroy');

    Route::post('/materials/approve/{id}', [LearningMaterialsController::class, 'approve'])->name('materials.approve');
    Route::post('/materials/reject/{id}', [LearningMaterialsController::class, 'reject'])->name('materials.reject');
    Route::post('/materials/pending/{id}', [LearningMaterialsController::class, 'pending'])->name('materials.pending');
});

// ebook routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'admin',
])->group(function () {
    Route::get('/ebook.manageview', [EbookController::class, 'ManageView'])->name('ebook.ManageView');
    Route::get('/ebook.uploadview', [EbookController::class, 'UploadView'])->name('ebook.UploadView');
    Route::post('/ebook', [EbookController::class, 'store'])->name('ebook.store');
    Route::delete('/ebook/{id}', [EbookController::class, 'destroy'])->name('ebook.destroy');
    Route::patch('/ebook/{id}', [EbookController::class, 'update'])->name('ebook.update');

    Route::get('/ebook/edit/{id}', [EbookController::class, 'EditView'])->name('ebook.EditPage');
});


// Category management routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'admin',
])->group(function () {
    Route::get('/category', [CategoryController::class, 'index'])->name('category.view');
    Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
    Route::put('/category/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
});

// EBOOK Category management routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'admin',
])->group(function () {
    Route::get('/ebook-category', [EbookCategoryController::class, 'index'])->name('ebook-category.view');
    Route::post('/ebook-category', [EbookCategoryController::class, 'store'])->name('ebook-category.store');
    Route::put('/ebook-category/{id}', [EbookCategoryController::class, 'update'])->name('ebook-category.update');
    Route::delete('/ebook-category/{id}', [EbookCategoryController::class, 'destroy'])->name('ebook-category.destroy');
});


// st controller
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/student-dashboard', [STLearningMaterialsController::class, 'index'])->name('student.dashboard');
    Route::get('/student-upload', [STLearningMaterialsController::class, 'view'])->name('student.upload');
    Route::post('/student-dashboard', [STLearningMaterialsController::class, 'upload'])->name('StUpload.store');
    Route::get('/ebook', [EbookController::class, 'index'])->name('ebook');
});


// routes/web.php
Route::get('/upload-ai-pdf', [aiPDFController::class, 'index']);
Route::post('/upload-ai-pdf', [aiPDFController::class, 'upload'])->name('ai.pdf');


