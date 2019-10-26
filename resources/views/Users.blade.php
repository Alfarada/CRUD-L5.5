@include('header')
	 <h1>{{ $tittle }}</h1>
		@empty($users)
			<p>No hay usuarios registrados</p>
		@else
			<ul>
				@foreach ($users as $user)
					<li>{{ $user }}</li>
				@endforeach
			</ul>
		@endempty

@include('footer')