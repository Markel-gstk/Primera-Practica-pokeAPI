<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
</head>
<body>
    <h1>Hola, {{ auth()->user()->name }}</h1>
    <p>Este es tu perfil.</p>
</body>
</html>
