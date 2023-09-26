<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
//use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\User\StudentController;
use App\Http\Controllers\Api\NewPasswordController;
use App\Http\Controllers\Api\SocialLoginController;

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


Route::group(['prefix' => 'v1'], function () {
        
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    // student auth routh
    Route::post('/register', [StudentController::class, 'register']);
    Route::post('/login', [StudentController::class, 'login']);

    Route::post('password/forgot-password', [NewPasswordController::class, 'forgotPassword']);
    Route::post('password/reset', [NewPasswordController::class, 'reset']);

   // social login impimentation
    Route::get('login/{driver}', [SocialLoginController::class, 'redirectToProvider']);
    Route::get('login/{driver}/callback', [SocialLoginController::class, 'handleProviderCallback']);
    Route::get('/email/verify-email/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify');

});


 Route::group(  ['middleware'=> ['auth:sanctum'],  'prefix' => 'v1' ], function () {  
    Route::post('/logout', [AuthController::class, 'logout']);

     //user routes
     Route::get('/users', [UserController::class, 'index']);
     Route::get('/users/{id}', [UserController::class, 'show']);
     Route::post('/users/make-admin/{id}', [UserController::class, 'makeAdmin']);
     Route::post('/users/make-user/{id}', [UserController::class, 'makeUser']);
     Route::delete('/users/{id}', [UserController::class, 'delete']);
     
       //  organization route
    Route::get('/organization', [OrganizationController::class, 'index']);
    Route::get('/organization/{id}', [OrganizationController::class, 'show']);
    Route::post('organization', [OrganizationController::class, 'store']);
    Route::patch('/organization/{id}', [OrganizationController::class, 'update']);
    Route::delete('/organization/{id}', [OrganizationController::class, 'delete']);

       //  Role route
    Route::get('/roles', [RoleController::class, 'index']);
    Route::get('/roles/{id}', [RoleController::class, 'show']);
    Route::post('roles', [RoleController::class, 'store']);
    Route::patch('/roles/{id}', [RoleController::class, 'update']);
    Route::delete('/roles/{id}', [RoleController::class, 'delete']);

        // permission Route
    Route::get('/roles', [PermissionController::class, 'index']);
    Route::get('/premissions/{id}', [PermissionController::class, 'show']);
    Route::post('premissions', [PermissionController::class, 'store']);
    Route::post('/premissions/{id}', [PermissionController::class, 'update']);
    Route::delete('/premissions/{id}', [PermissionController::class, 'delete']);

    // student Route
    Route::get('/students', [StudentController::class, 'index']);
    Route::get('/students/{id}', [StudentController::class, 'show']);
    Route::post('students', [StudentController::class, 'store']);
    Route::patch('/students/{id}', [StudentController::class, 'update']);
    Route::delete('/students/{id}', [StudentController::class, 'delete']);

    // profile Route
    Route::get('/profiles', [ProfileController::class, 'index']);
    Route::get('/profiles/{id}', [ProfileController::class, 'show']);
    Route::post('profiles', [ProfileController::class, 'store']);
    Route::patch('/profiles/{id}', [ProfileController::class, 'update']);
    Route::delete('/profiles/{id}', [ProfileController::class, 'delete']);
    
      //winner routes
    // Route::get('/winner/{id}', [WinnerController::class, 'show']);
    // Route::post('winner/create', [WinnerController::class, 'store']);
    // Route::post('/winner/update/{id}', [WinnerController::class, 'update']);
    // Route::delete('/winner/delete/{id}', [WinnerController::class, 'delete']);
 });
      

Route::middleware('auth:sanctum','verified')->get('/user', function (Request $request) {
    return $request->user();
});
