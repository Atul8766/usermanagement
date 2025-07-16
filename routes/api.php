<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::controller(AuthController::class)->group(function () {
    Route::prefix('auth')->name('auth.')->group(
        function () {
            #Auth Routes
            Route::post('/register', 'register')->name('register');
            Route::post('/login', 'login')->name('login');

            Route::get('logout', 'logout')->name('logout')->middleware('auth:api');

            #Auth superadmin Middleware Routes
            Route::middleware(['auth:api', 'role:superadmin'])->group(function () {
                Route::delete('/users/{id}', 'delete');
                // other high-permission routes
            });

            #Auth List Api
            Route::get('/list', 'usersList')->name('list')->middleware('auth:api');

            #Auth superadmin,admin Middleware Routes
            Route::middleware(['auth:api', 'role:superadmin,admin'])->group(function () {
                Route::post('/store ',  'createUsers');
                Route::patch('/update/{id}', 'updateUsers');
            });

            #Auth User Middleware Routes
            Route::middleware(['auth:api', 'role:user'])->group(function () {
                Route::get('profile', 'userProfile')->name('profile');
            });
        }
    );
});
