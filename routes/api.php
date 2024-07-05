<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\StatusController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/refresh', [AuthController::class, 'refresh']);


Route::middleware('auth:api')->group(function() {  
  Route::get('/users', [AuthController::class, 'getAll']);
});



// Route::get('/users', [UserController::class, 'getAll']);
// Route::get('/users/{id}', [UserController::class, 'findId']);
// Route::post('/users', [UserController::class, 'save']);
// Route::put('/users/{id}', [UserController::class, 'update']);
// Route::delete('/users/{id}', [UserController::class, 'delete']);

Route::get('/roles', [RolesController::class, 'getAll']);
Route::get('/roles/{id}', [RolesController::class, 'findId']);
Route::post('/roles', [RolesController::class, 'save']);
Route::put('/roles/{id}', [RolesController::class, 'update']);
Route::delete('/roles/{id}', [RolesController::class, 'delete']);

Route::get('/status', [StatusController::class, 'getAll']);
Route::get('/status/{id}', [StatusController::class, 'findId']);
Route::post('/status', [StatusController::class, 'save']);
Route::put('/status/{id}', [StatusController::class, 'update']);
Route::delete('/status/{id}', [StatusController::class, 'delete']);