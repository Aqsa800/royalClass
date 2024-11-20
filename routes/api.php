<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

// Public routes
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register']);



// Protected routes with role-based access
Route::middleware(['auth:api'])->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout']);

    // Admin-only routes
    Route::middleware(['check.role:admin'])->group(function () {
        
        $modules = ['General', 'Motors', 'Jobs'];
        
        foreach ($modules as $module) {
            $routePath = base_path("Modules/{$module}/routes/api.php");
            if (file_exists($routePath)) {
                require $routePath;
            }
        }
    });
});


