<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/profile', function (Request $request) {
        return response()->json([
            'message' => 'This is a protected route.',
            'user' => $request->user(),
        ]);
    });
    
    Route::post('/logout', [AuthController::class, 'logout']);

   //Admin-only route using the CheckRole or role alias to check the role of users
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function (Request $request) {
            return response()->json([
                'message' => 'Welcome to the admin dashboard. Using the CheckRoleMiddleware to check the role of users.',
                'user' => $request->user(),
            ]);
        });
    });

    Route::middleware('role:student')->group(function () {
        Route::get('/student/dashboard', function (Request $request) {
            return response()->json([
                'message' => 'Welcome to the student dashboard. Using the CheckRoleMiddleware to check the role of users.',
                'user' => $request->user(),
            ]);
        });
    });
});

// Admin-only route using the 'admin' Middleware mannually checking the role of users
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/admin', function (Request $request) {
        return response()->json([
            'message' => 'This is an admin-only route. Using the AdminMiddleware to check the role of users.',
            'user' => $request->user(),
        ]);
    });
});


// Sample Route for Testing
Route::get('/sample', function () {
    return response()->json([
        'message' => 'This is a sample route.',
    ]);
});