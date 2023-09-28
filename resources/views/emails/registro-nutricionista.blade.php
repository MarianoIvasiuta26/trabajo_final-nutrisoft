<!DOCTYPE html>
<html>
<head>
    <title>Completa tu registro</title>
</head>
<body>
    <h1>Completa tu registro como nutricionista</h1>
    <p>Hola</p>
    <p>Para completar tu registro y configurar tu contraseña, haz clic en el siguiente enlace:</p>
    <a href="{{ route('mostrar-completar-registro', $userId) }}">Completar Registro</a>
    <p>Este enlace caducará en 24 horas.</p>
</body>
</html>
