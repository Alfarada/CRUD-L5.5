@extends('layout')
@section("title", " Crear Usuario")
@section('content')

	@component('shared._card')

		@slot('header','Editar usuario')
		
		@include('shared._errors')	{{-- errors_list --}}

		<form method="POST" action="{{ url("usuarios/{$user->id}") }} ">
			{{ method_field('PUT') }}

			@include('users._fields')

			<div class="form-group mt-4">
				<button type="submit" class="btn btn-primary">
					Actualizar Usuario
				</button>
			</div>
		</form>
	@endcomponent

@endsection