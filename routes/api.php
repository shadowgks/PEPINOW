<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RefreshController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UpdateProfileController;
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
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LogoutController::class, 'logout']);
Route::post('/refresh', [RefreshController::class, 'refresh']);
Route::post('/resetPassword', [ResetPasswordController::class, 'resetPassword']);
Route::post('/forgotPassword', [ForgotPasswordController::class, 'forgotPassword']);
Route::post('/resetForgotPassword', [ResetPasswordController::class, 'resetPassword'])->name('password.reset');
Route::patch('/updateProfilUser', [UpdateProfileController::class, 'updateProfilUser']);
Route::get('/me', [ProfileController::class, 'me']);



//PRIVETE
// Admin
Route::group(['middleware' => ['admin']], function () {
    //Categorie
    Route::apiResource('/categorie', CategorieController::class);
});

// Vendeur
Route::group(['middleware' => ['vendeur']], function () {
    //Plant
    Route::apiResource('/plant', PlantController::class);
    Route::post('/plant/{plant}', [PlantController::class, 'addCategories']);
});

//Utilisateur
Route::group(['middleware' => ['utilisateur']], function () {
    //Plant
    Route::apiResource('/plant', PlantController::class)->only('index');
});
