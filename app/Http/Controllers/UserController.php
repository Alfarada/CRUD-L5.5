<?php

namespace App\Http\Controllers;

use App\{User};
use App\Http\Requests\CreateUserRequest;
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
        return view('users.create');
    }

    function store(CreateUserRequest $request)
    {
        $request->createUser();

        return redirect()->route('users.index');
    }

    function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    function update(User $user)
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
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

    function destroy(User $user)
    {

        $user->delete();

        return redirect()->route('users.index');
    }
}
