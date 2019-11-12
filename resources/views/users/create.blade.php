
@extends('layout')

@section("title", " Crear Usuario") 

@section('content')
	<h1>Crear nuevo Usuario </h1>
	
	<form method="POST" action="{{ url('usuarios/crear')}} ">
	
		{!! csrf_field() !!}

		<button type="submit">
			Crear Usuario
		</button>
	</form>
	<p>
		<a href="{{ route('users')}} ">Regresar a la lista de usuarios</a>
	</p>


@endsection







