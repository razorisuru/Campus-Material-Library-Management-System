<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\DegreeProgrammeController;
use App\Http\Controllers\PdfApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response()->noContent();
});

// Degree API
Route::get('/degree-programmes/{id}/subjects', [DegreeProgrammeController::class, 'getSubjects']);

Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/register', [AuthApiController::class, 'register']);


Route::get('/degree/category', [PdfApiController::class, 'degreeCategory']);
Route::get('/pdf/category', [PdfApiController::class, 'pdfCategory']);
Route::get('/ebook/category', [PdfApiController::class, 'ebookCategory']);
Route::get('/ebooks', [PdfApiController::class, 'ebooks']);
Route::get('/ebook/{id}', [PdfApiController::class, 'ebook']);

