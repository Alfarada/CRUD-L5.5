
@extends('layout')

@section("title", " Crear Usuario") 

@section('content')

	<div class="card">
		<h2 class="card-header">
			Crear Usuario
		</h2>
		<div class="card-body">
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
				
				<form method="POST" action="{{ url('usuarios') }} ">
				
					{!! csrf_field() !!}
			
					<div class="form-group">
						<label for="name">Nombre:</label>
						<input type="text" class="form-control" name="name" placeholder="Bob Rank" >
					</div>
					<div class="form-group">
						<label for="email" >Email:</label>
						<input type="email" class="form-control" name="email" placeholder="Bob@example.com" value=" {{ old('email') }}">
					</div>
					<div class="form-group">
						<label for="password" >Contraseña:</label>
						<input type="password" class="form-control" name="password" placeholder="Mayor a 6 caracteres">
					</div>
				
					<button type="submit" class="btn btn-primary">
						Crear Usuario
					</button>
			
					<a class="btn btn-link" href="{{ route('users.index')}} ">Regresar a la lista de usuarios</a>
				</form>
		</div>
	</div>	

@endsection







