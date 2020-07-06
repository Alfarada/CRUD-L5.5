<?php

namespace App\Http\Controllers;

use App\{Skill, User};
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Model\Profession;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    function index()
    {
        $users = User::all();

        $title = 'listado de usuarios';

        return view('users.index', compact('title', 'users'));
    }

    function welcome()
    {
        return view('welcome');
    }

    function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    function create()
    {
        $user = new User;
        return view('users.create', compact('user'));
    }

    function store(CreateUserRequest $request)
    {
        $request->createUser();

        return redirect()->route('users.index');
    }

    function edit(User $user)
    {   
        return view('users.edit', compact('user'));
    }

    function update( UpdateUserRequest $request,User $user)
    {
        $request->updateUser($user);

        return redirect()->route('users.show', ['user' => $user]);
    }

    function destroy(User $user)
    {

        $user->delete();

        return redirect()->route('users.index');
    }
}
