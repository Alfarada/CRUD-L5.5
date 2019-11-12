
@extends('layout')

@section("title", " Crear Usuario") 

@section('content')
	<h1>Crear nuevo Usuario </h1>
	
	<form method="POST" action="{{ url('usuarios')}} ">
	
		{!! csrf_field() !!}
		

		<label for="name">Nombre:</label>
		<input type="text" name="name" placeholder="Bob">
		<br>

		<label for="email">Email:</label>
		<input type="email" name="email" placeholder="Bob@example.com">
		<br>
		
		<label for="password">Contraseña:</label>
		<input type="password" name="password" placeholder="Mayor a 6 caracteres">
		<br>

		<button type="submit">
			Crear Usuario
		</button>
	</form>
	<p>
		<a href="{{ route('users.index')}} ">Regresar a la lista de usuarios</a>
	</p>


@endsection







