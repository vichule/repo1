<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; 
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
    return view('welcome');
});

Route::get('/formulario', function () {
    return view('vista2');
})->name("formulario-web");

Route::match(['get', 'post'],'/greeting', function () {
    return 'Hello World';
});


Route::post('/leerformulario', function (Request $request) {

	$dato = $request->input('dato');
	
	return view('datoformulario', ["lectura"=> $dato]);
});

Route::redirect('/mal', 'greeting');