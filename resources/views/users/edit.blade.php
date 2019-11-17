
@extends('layout')

@section("title", " Crear Usuario") 

@section('content')
	<h1>Editar Usuario</h1>
	@if($errors->any())
	<div class="alert alert-danger">
		<p><h6>Corrige los siguientes errores</h6></p>
		<ul>
			@foreach($errors->all() as $error)
				<li> {{ $error }} </li>
			@endforeach
		</ul>
	</div>
	@endif 
	
	<form method="POST" action="{{ url("usuarios/{$user->id}") }} ">
		{{ method_field('PUT') }}
		{!! csrf_field() !!}
		

		<label for="name">Nombre:</label>
		<input type="text" name="name" placeholder="Bob" value=" {{ old('name', $user->name) }} ">
		<br>

		<label for="email">Email:</label>
		<input type="email" name="email" placeholder="Bob@example.com" value=" {{ old('email', $user->email) }}">
		<br>
		
		<label for="password">Contraseña:</label>
		<input type="password" name="password" placeholder="Mayor a 6 caracteres">
		<br>

		<button type="submit">
			Actualizar Usuario
		</button>
	</form>
	<p>
		<a href="{{ route('users.index')}} ">Regresar a la lista de usuarios</a>
	</p>


@endsection







