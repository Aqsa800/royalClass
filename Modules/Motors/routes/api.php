<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Motors\Controllers\DocumentController;
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

Route::prefix('motors')->group(function () {
    Route::post('/documents', [DocumentController::class, 'upload']);
    Route::get('/documents/{id}', [DocumentController::class, 'view']);
    Route::get('/documents', [DocumentController::class, 'list']);
});
