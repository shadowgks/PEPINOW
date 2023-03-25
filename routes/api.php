<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Auth\ForgotPassword;
use App\Http\Controllers\Auth\Login as AuthLogin;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Profile;
use App\Http\Controllers\Auth\Refresh;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\Auth\ResetPassword;
use App\Http\Controllers\Auth\UpdateProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Authentication\Login;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\PlantController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Authentification
Route::post('/login', [AuthLogin::class , 'login']);
Route::post('/register', [Register::class , 'register']);
Route::post('/logout', [Logout::class , 'logout']);
Route::post('/refresh', [Refresh::class , 'refresh']);
Route::get('/me', [Profile::class , 'me']);
Route::post('/forgotPassword', [ForgotPassword::class , 'forgotPassword']);
Route::post('/resetPassword', [ResetPassword::class , 'resetPassword']);
Route::post('/updateProfilUser', [UpdateProfile::class , 'updateProfilUser']);

//Plant
Route::apiResource('/plant',PlantController::class);
Route::post('/plant/{plant}', [PlantController::class, 'addCategories']);

//Categorie
Route::apiResource('/categorie',CategorieController::class);

