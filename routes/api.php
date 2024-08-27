<?php

use App\Http\Controllers\JobController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get('/api-jobs', [JobController::class, 'getJobs']);
Route::get('/api-jobs/{id}', [JobController::class, 'getJobById']);
Route::delete('/api-jobs/{id}', [JobController::class, 'deleteJobById']);
Route::patch('/api-jobs/{id}', [JobController::class, 'updateJobById']);
