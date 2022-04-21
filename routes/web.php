<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    abort(403);
    //return view('welcome');
});

Route::post('/test/api-form-data', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Log::info($request->all());

    return $request->all();
});
