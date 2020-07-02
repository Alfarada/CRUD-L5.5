@extends('layout')

@section("title", " Crear Usuario")

@section('content')

	@component('shared._card')
	
	@slot('header', 'Crear usuario')
	
	@include('shared._errors')	{{-- errors_list --}}

	<form method="POST" action="{{ url('usuarios') }} ">
		@include('users._fields')	{{-- Fields--}}
		<div class="form-group mt-4">
			<button type="submit" class="btn btn-primary">
				Crear Usuario
			</button>
			<a class="btn btn-link" href="{{ route('users.index')}} ">Ir a la lista de usuarios </a>
		</div>
	</form>

	@endcomponent

@endsection