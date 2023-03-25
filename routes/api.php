<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Auth\Login as AuthLogin;
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
Route::controller(AuthController::class)->group(function () {
    // Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout');
    Route::post('/refresh', 'refresh');
    Route::get('/me', 'me');
    Route::post('/forgotPassword', 'forgotPassword');
    Route::post('/resetPassword', 'resetPassword')->name('password.reset');
    Route::post('/updateProfilUser', 'updateProfilUser');
});

//Plant && Categorie
Route::apiResource('/plant',PlantController::class);
Route::post('/plant/{plant}', [PlantController::class, 'addCategories']);

Route::apiResource('/categorie',CategorieController::class);

