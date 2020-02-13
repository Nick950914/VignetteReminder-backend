<?php

use App\Http\Controllers\RemindersController;
use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::prefix('v1')->group(function () {
    // Route::prefix('auth')->group(function () {
        // Below mention routes are public, user can access those without any restriction.
        // Create New User
        Route::post('register', 'AuthController@register');
        // Login User
        Route::post('login', 'AuthController@login');
        
        // Refresh the JWT Token
        Route::get('refresh', 'AuthController@refresh');
        
        // Below mention routes are available only for the authenticated users.
        Route::middleware('auth:api')->group(function () {
            // Get user info
            Route::get('user/{id}', 'AuthController@user');
            // Logout user from application
            Route::post('logout', 'AuthController@logout');
        });
    // });
// });

// VEHICLES
Route::get('vehicles', 'VehiclesController@index');
Route::post('vehicles', 'VehiclesController@store');
// Route::get('/vehicles/create', 'VehiclesController@create');
Route::get('vehicles/{vehicle}', 'VehiclesController@show');
Route::get('vehicles/{vehicle}/reminders', 'VehiclesController@showVehicleReminders');
// Route::get('/vehicles/{vehicle}/edit', 'VehiclesController@edit');
Route::put('vehicles/{vehicle}', 'VehiclesController@update');
Route::delete('vehicles/{vehicle}', 'VehiclesController@destroy');

// REMINDERS
Route::post('reminders', 'RemindersController@store');
Route::put('reminders/{reminder}', 'RemindersController@update');
Route::delete('reminders/{reminder}', 'RemindersController@destroy');