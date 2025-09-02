<?php

use App\Http\Controllers\Api\V1\EducationController;
use App\Http\Controllers\Api\V1\ExperienceController;
use App\Http\Controllers\Api\V1\MessageController;
use App\Http\Controllers\Api\V1\ProjectCategoryController;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\ServiceController;
use App\Http\Controllers\Api\V1\SkillCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('projects', ProjectController::class);
Route::apiResource('skill-categories', SkillCategoryController::class);
Route::apiResource('services', ServiceController::class);
Route::apiResource('experiences', ExperienceController::class);
Route::apiResource('educations', EducationController::class);
Route::apiResource('project-categories', ProjectCategoryController::class);
Route::apiResource('messages', MessageController::class);
