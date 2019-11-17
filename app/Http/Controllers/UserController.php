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

    function show(User $user)
    {
        //$user = User::findOrFail($id);



        return view('users.show', compact('user')); 
    }

    function create()
    {
    	return view('users.create');
    }

    function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => 'required',
        ],[
            'name.required' => 'El campo  name obligatorio',
        ]);

        //dd($data);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        return redirect()->route('users.index');
    }

    function edit(User $user)
    {
        return view('users.edit' , ['user' => $user]);
    }

    function update(User $user)
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => '',
        ]);

        if ($data['password'] != null) {
            $data['password'] = bcrypt($data['password']);  
        } else {
            unset($data['password']);
        }

        $user->update($data);
        
        return redirect("usuarios/{$user->id}");
    }
}
