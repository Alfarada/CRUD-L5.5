<?php

namespace App\Http\Controllers;

//use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function index()
    {
            //$users = DB::table('users')->get();

            $users = User::all();
        

        $title = 'listado de usuarios';

    	return view('users.index',compact('title','users'));
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
