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
        $title = 'listado de usuarios';

    	return view('users.index',compact('users','title'));
    }
    
    function welcome()
    {
    	return view('welcome');
    }

    function show($id)
    {
        return view('users.show', compact('id')); 
    }

    function create()
    {
    	return 'Creando nuevo usuario';
    }
}
