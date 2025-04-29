<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EbookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NodeJsAiPdfController;
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

Route::get('/test/ai', function () {
    return view('PDF.aitest');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'AdminRedirect',
])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});

#admin routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'admin',
])->group(function () {
    Route::get('/admin-view', [AdminController::class, 'index'])->name('admin.view');
    Route::get('/admin-add', [AdminController::class, 'AdminAdd'])->name('admin.add');
    Route::post('/admin-add', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin-edit/{id}', [AdminController::class, 'AdminEditPage'])->name('admin.EditPage');
    Route::patch('/admin-edit/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin-delete/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
});

// degreeEdit
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'teacher',
])->group(function () {
    Route::get('/degree-programmes-view', [AddSubjectDegController::class, 'show'])->name('degree.show');
    Route::get('/degree-programmes-add', [AddSubjectDegController::class, 'add'])->name('degree.add');
    Route::post('/degree-programmes-add', [AddSubjectDegController::class, 'store'])->name('degree.store');
    Route::post('/degree-programmes-subjects-add', [AddSubjectDegController::class, 'SubjectStore'])->name('degree.SubjectStore');

});


// pdf management routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'teacher',
])->group(function () {
    Route::get('/pdf-upload', [LearningMaterialsController::class, 'index'])->name('upload.view');
    Route::get('/pdf-view', [LearningMaterialsController::class, 'view'])->name('upload.viewPage');
    Route::post('/pdf-upload', [LearningMaterialsController::class, 'upload'])->name('upload.store');
    Route::get('/pdf-edit/{id}', [LearningMaterialsController::class, 'EditView'])->name('upload.EditPage');
    Route::patch('/pdf-edit/{id}', [LearningMaterialsController::class, 'update'])->name('upload.update');
    Route::delete('/upload/{id}', [LearningMaterialsController::class, 'destroy'])->name('upload.destroy');

    Route::post('/materials/approve/{id}', [LearningMaterialsController::class, 'approve'])->name('materials.approve');
    Route::post('/materials/reject/{id}', [LearningMaterialsController::class, 'reject'])->name('materials.reject');
    Route::post('/materials/pending/{id}', [LearningMaterialsController::class, 'pending'])->name('materials.pending');

    Route::post('/material/bulk-delete', [LearningMaterialsController::class, 'bulkDelete'])->name('material.bulkDelete');

    Route::post('/material/bulk-approve', [LearningMaterialsController::class, 'bulkApprove'])->name('material.bulkApprove');
    Route::post('/material/bulk-pending', [LearningMaterialsController::class, 'bulkPending'])->name('material.bulkPending');
    Route::post('/material/bulk-reject', [LearningMaterialsController::class, 'bulkReject'])->name('material.bulkReject');
});

// ebook routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'teacher',
])->group(function () {
    Route::get('/ebook-manage', [EbookController::class, 'ManageView'])->name('ebook.ManageView');
    Route::get('/ebook-upload', [EbookController::class, 'UploadView'])->name('ebook.UploadView');
    Route::post('/ebook', [EbookController::class, 'store'])->name('ebook.store');
    Route::delete('/ebook/{id}', [EbookController::class, 'destroy'])->name('ebook.destroy');
    Route::patch('/ebook/{id}', [EbookController::class, 'update'])->name('ebook.update');

    Route::get('/ebook/edit/{id}', [EbookController::class, 'EditView'])->name('ebook.EditPage');
    Route::post('/ebook/bulk-delete', [EbookController::class, 'bulkDelete'])->name('ebook.bulkDelete');

});


// Category management routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'admin',
])->group(function () {
    Route::get('/category-view', [CategoryController::class, 'index'])->name('category.view');
    Route::post('/category-add', [CategoryController::class, 'store'])->name('category.store');
    Route::put('/category-update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category-delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

    Route::post('/category/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('category.bulkDelete');
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

    Route::post('/ebookCategory/bulk-delete', [EbookCategoryController::class, 'bulkDelete'])->name('ebookCategory.bulkDelete');
});


// st controller
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/student/dashboard', [STLearningMaterialsController::class, 'stDashboard'])->name('student.dashboard');
    Route::get('/student/pdf', [STLearningMaterialsController::class, 'index'])->name('student.pdf');
    Route::get('/student-upload', [STLearningMaterialsController::class, 'view'])->name('student.upload');
    Route::post('/student-dashboard', [STLearningMaterialsController::class, 'upload'])->name('StUpload.store');
    Route::get('/ebook', [EbookController::class, 'index'])->name('ebook');
    Route::get('/ai', [EbookController::class, 'ai'])->name('ai');
});


// AI ROUTES
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/summarize-pdf', [NodeJsAiPdfController::class, 'index'])->name('summarize.pdf');
    Route::get('/chat', [NodeJsAiPdfController::class, 'chat'])->name('chat');
    Route::get('/summarize-pdf/{arg}', [NodeJsAiPdfController::class, 'arg']);
    // Route::get('/chat/{arg}', [NodeJsAiPdfController::class, 'chat']);
    Route::post('/summarize-pdf', [NodeJsAiPdfController::class, 'summarize'])->name('Summarize.pdf');
    Route::post('/openai-chat', [NodeJsAiPdfController::class, 'prompt'])->name('openai.chat');

    Route::post('/chat-bot', [NodeJsAiPdfController::class, 'chatBot'])->name('chat.bot');

});

// php artisan serve --host=0.0.0.0 --port=8000

