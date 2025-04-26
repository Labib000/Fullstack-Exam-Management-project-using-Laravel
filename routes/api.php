<?php

use App\Http\Middleware\CheckRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\authController;
use App\Http\Controllers\Api\userController;
use App\Http\Controllers\Api\ModeratorController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');





Route::post('signup', [authController::class,'signUp']);
Route::post('login', [authController::class,'login']);
Route::middleware('auth:sanctum')->post('/logout', [authController::class, 'signOut']);
Route::middleware('auth:sanctum')->post('/students/logout', [userController::class, 'stdlogout']);



Route::post('students', [userController::class, 'store']);
Route::post('students/login', [userController::class, 'login']);


Route::get('login', [authController::class,'login'])->name('login');




Route::post('/moderators', [ModeratorController::class, 'store']);
Route::post('/moderators/login', [ModeratorController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/moderators', [ModeratorController::class, 'index']);

    Route::post('/moderators/logout', [ModeratorController::class, 'logout']);
    Route::get('/moderators/show/{id}', [ModeratorController::class, 'show']);
    Route::put('/moderators/edit/{id}', [ModeratorController::class, 'update']);
    Route::delete('/moderators/delete/{id}', [ModeratorController::class, 'destroy']); // PUT by ID
    
});

Route::middleware(['auth:sanctum','checkrole:admin'])->group(function () {
    Route::get('students', [userController::class, 'index']);
        Route::get('students/{id}', [userController::class, 'show']);
        Route::put('students/edit/{id}', [userController::class, 'update']);
        Route::delete('students/{id}/delete', [userController::class, 'destroy']);
        Route::get('/admins', [authController::class, 'adminIndex']);


});








// Route::group(['middleware'=>["auth:sanctum","checkrole:admin"]],function(){
//     Route::get('students', [userController::class, 'index']);
//     Route::get('students/{id}', [userController::class, 'show']);
//     Route::put('students/edit/{id}', [userController::class, 'update']);
//     Route::delete('students/{id}/delete', [userController::class, 'destroy']);
//     // Route::post('students/logout', [userController::class, 'logout']);
  
// });
