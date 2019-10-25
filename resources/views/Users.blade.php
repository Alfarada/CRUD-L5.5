<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Listado de Usuarios Styde.net</title>
</head>
<body>
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
</body>
</html>