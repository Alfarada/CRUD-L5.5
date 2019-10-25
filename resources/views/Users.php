<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Listado de Usuarios Styde.net</title>
</head>
<body>
	<h1><?= e($tittle) ?></h1>

	<ul>
		<?php foreach ($users as $user):?>
			<li><?= e($user) ?></li>
		<?php endforeach; ?> 
	</ul>
</body>
</html>