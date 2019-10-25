<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    function index()
    {
        $users = [
            'Sabrina',
            'Alfredo',
            'Bob',
            'Ted',
            'Ellie',
            '<script>alert("Clicker")</script>'
        ];

    	return view('Users',[
            'users' => $users, 
            'tittle'=> 'Listado de usuarios'
        ]);
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
