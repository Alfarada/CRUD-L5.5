@extends('layout')

@section("title", " Crear Usuario")

@section('content')

<div class="card">
	<h4 class="card-header">
		Crear usuario
	</h4>
	<div class="card-body">

		{{-- errors_list --}}
			@include('shared._errors')
		{{-- errors_list --}}

		<form method="POST" action="{{ url('usuarios') }} ">

			@include('users._fields')

			<div class="form-group mt-4">
				<button type="submit" class="btn btn-primary">
					Crear Usuario
				</button>
				<a class="btn btn-link" href="{{ route('users.index')}} ">Regresar a la lista de usuarios</a>
			</div>
		</form>
	</div>
</div>

@endsection