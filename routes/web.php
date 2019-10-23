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

Route::get('/', function () {
    return view('welcome');
});

/*Route::get('/', function () {
    return 'Hola mundo!';
});*/

Route::get('/usuarios', function(){
	return 'Usuarios';
}); 

Route::get('/usuarios/{id}', function($id){
	return "Mostrando detalle de el usuario: {$id} ";
})->where('id','[0-9]+');

Route::get('/usuarios/nuevo', function (){
	return 'Creando nuevo usuario';
});

Route::get('saludo/{name}/{nickname?}', function ($name, $nickname = null){
	
	$name = ucfirst($name);

	if ($nickname) {
			return "Bienvenido {$name}, tu apodo es {$nickname} ";		
	}
	return "Bienvenido {$name}";
});

