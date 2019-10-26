<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    function index()
    {

        //Mostrar lista de usuarios, unicamente si tenemos usuarios
        
        if (request()->has('empty')) {
            $users = [];
        } else {

            $users = [
                'Sabrina','Alfredo','Bob','Ted','Ellie',
            ];
        }
        $tittle = 'listado de usuarios';

    	return view('Users',compact('users','tittle'));
    }
    
    function welcome()
    {
    	return view('welcome');
    }

    function show($id)
    {
    	return "Mostrando detalle de el usuario: {$id} ";
    }

    function create()
    {
    	return 'Creando nuevo usuario';
    }
}
