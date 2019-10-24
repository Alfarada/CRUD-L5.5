<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    function index()
    {
    	return 'Usuarios';
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
