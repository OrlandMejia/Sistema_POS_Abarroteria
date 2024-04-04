<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//RUTA PRINCIPAL DE LA PAGINA QUE CARGA POR DEFAULT HASTA EL MOMENTO
Route::get('/', function () {
    return view('template');
});

//RUTA DE LA VISTA PARA QUE MUESTRE EL PANEL PRINCIPAL y podamos usarla con el nombre de panel para los route
Route::view('/panel','panel.index')->name('panel');



//RUTA DEL LOGIN lo que esté dentro de login es lo que debemos colocar en la barra de navegación osea www.algo.com/login
Route::get('/login', function () {
    // aqui lo que hace es que  carga la vista login.blade.php
    return view('auth.login');
});

//RUTA 401
Route::get('/401', function (){
    return view('pages.401');
});

//RUTA 404
Route::get('/404', function(){
    return view('pages.404');
});

//RUTA 500
Route::get('/500', function(){
    return view('pages.500');
});
