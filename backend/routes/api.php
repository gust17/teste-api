<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('tasks', TaskController::class)->middleware('auth:sanctum');
Route::post('/reports', [ReportController::class, 'generate']);

Route::post('/login', [AuthController::class, 'login']);

Route::get('files/{fileName}', [TaskController::class,'getFileReport']);


Route::middleware('auth:sanctum')->post('/generate-report', [TaskController::class, 'generateReport']);
