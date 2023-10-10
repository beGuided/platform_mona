<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\OrganizationController;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NewPasswordController;
use App\Http\Controllers\Api\StudentAuthController;
use App\Http\Controllers\Api\SocialLoginController;

use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\StudentController;
use App\Http\Controllers\User\DepartmentController;
use App\Http\Controllers\User\SemesterController;
use App\Http\Controllers\User\UserController;

use App\Http\Controllers\Student\CourseController;

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
        
    Route::post('/register-staff', [AuthController::class, 'registerStaff']);
    Route::post('/login-staff', [AuthController::class, 'loginStaff']);
    // student auth routh
    Route::post('/register-student', [StudentAuthController::class, 'registerStudent']);
    Route::post('/login-student', [StudentAuthController::class, 'loginStudent']);

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
    Route::get('/organizations', [OrganizationController::class, 'index']);
    Route::get('/organizations/{id}', [OrganizationController::class, 'show']);
    Route::post('organizations', [OrganizationController::class, 'store']);
    Route::patch('/organizations/{id}', [OrganizationController::class, 'update']);
    Route::delete('/organizations/{id}', [OrganizationController::class, 'delete']);

       //  Role route
    Route::get('/roles', [RoleController::class, 'index']);
    Route::get('/roles/{id}', [RoleController::class, 'show']);
    Route::post('roles', [RoleController::class, 'store']);
    Route::patch('/roles/{id}', [RoleController::class, 'update']);
    Route::delete('/roles/{id}', [RoleController::class, 'delete']);
        
    // departments result
    Route::get('/departments', [DepartmentController::class, 'index']);
    Route::get('/departments/{id}', [DepartmentController::class, 'show']);
    Route::post('departments', [DepartmentController::class, 'store']);
    Route::patch('/departments/{id}', [DepartmentController::class, 'update']);
    Route::delete('/departments/{id}', [DepartmentController::class, 'delete']);

        // role Route
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
    Route::get('/staff-profiles/{id}', [ProfileController::class, 'staffProfile']);
    Route::get('/student-profiles/{id}', [ProfileController::class, 'studentProfile']);
    Route::post('profiles', [ProfileController::class, 'store']);
    Route::patch('/profiles/{id}', [ProfileController::class, 'update']);
    Route::delete('/profiles/{id}', [ProfileController::class, 'delete']);
    
    //  course route
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/{id}', [CourseController::class, 'show']);
    Route::get('/courses/{id}', [CourseController::class, 'filter']);
    Route::post('courses', [CourseController::class, 'store']);
    Route::patch('/courses/{id}', [CourseController::class, 'update']);
    Route::delete('/courses/{id}', [CourseController::class, 'delete']);
     // semester route
     Route::get('/semesters', [SemesterController::class, 'index']);
     Route::get('/semesters/{id}', [SemesterController::class, 'show']);
     Route::get('/semesters/{id}', [SemesterController::class, 'filter']);
     Route::post('semesters', [SemesterController::class, 'store']);
     Route::patch('/semesters/{id}', [SemesterController::class, 'update']);
     Route::delete('/semesters/{id}', [SemesterController::class, 'delete']);
     
    // prererofile result
    Route::get('/results', [ResultController::class, 'index']);
    Route::get('/results/{id}', [ResultController::class, 'show']);
    Route::get('/results/{id}', [ResultController::class, 'filter']);
    Route::post('results', [ResultController::class, 'store']);
    Route::patch('/results/{id}', [ResultController::class, 'update']);
    Route::delete('/results/{id}', [ResultController::class, 'delete']);

    
    
      //winner routes
    // Route::get('/winner/{id}', [WinnerController::class, 'show']);
    // Route::post('winner/create', [WinnerController::class, 'store']);
    // Route::post('/winner/update/{id}', [WinnerController::class, 'update']);
    // Route::delete('/winner/delete/{id}', [WinnerController::class, 'delete']);
 });
      

Route::middleware('auth:sanctum','verified')->get('/user', function (Request $request) {
    return $request->user();
});
