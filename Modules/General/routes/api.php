<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\General\Controllers\DocumentController;
/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

Route::middleware(['auth:api'])->group(function () {
    // Admin-only routes should be inside the authenticated group
    Route::middleware(['check.role:admin'])->group(function () {
        Route::prefix('general')->group(function () {
            Route::post('/documents', [DocumentController::class, 'upload']);
            Route::get('/documents/{id}', [DocumentController::class, 'view']);
            Route::get('/documents', [DocumentController::class, 'list']);
        });
    });
});