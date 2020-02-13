<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// use App\Http\Controllers\VehiclesController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return "asdfg";
})->middleware('admin');

// Route::get('/vehicles', 'VehiclesController@index');
// Route::post('/vehicles', 'VehiclesController@store');
// Route::post('/test', function () {
//     return "zdrkpr";
// });
// Route::get('/test', function () {
//     return "zdrkpr";
// });
// // Route::get('/vehicles/create', 'VehiclesController@create');
// Route::get('/vehicles/{vehicle}', 'VehiclesController@show');
// // Route::get('/vehicles/{vehicle}/edit', 'VehiclesController@edit');
// Route::put('/vehicles/{vehicle}', 'VehiclesController@update');
// Route::delete('/vehicles/{vehicle}', 'VehiclesController@destroy');