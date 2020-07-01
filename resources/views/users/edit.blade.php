
@extends('layout')

@section("title", " Crear Usuario") 

@section('content')
	<h1>Editar Usuario</h1>

	{{-- errors_list --}}
		@include('shared._errors')
	{{-- errors_list --}}
	
	<form method="POST" action="{{ url("usuarios/{$user->id}") }} ">
		{{ method_field('PUT') }}

			@include('users._fields')

		<div class="form-group mt-4">
			<button type="submit" class="btn btn-primary">
				Actualizar Usuario
			</button>
		</div>
	</form>
	<p>
		<a href="{{ route('users.index')}} ">Regresar a la lista de usuarios</a>
	</p>
@endsection







