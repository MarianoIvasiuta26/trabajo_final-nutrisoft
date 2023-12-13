<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Completa tu registro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />

    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        #header{
            position: fixed;
            top: -3cm;
            left: 0cm;
            width: 100%;
        }

        .infoHeader{
            float: left;
            margin-left: 1cm;
            margin-top: 0.5cm;
            width: 100%;
        }


        .imgHeader{
            float: center;
            width: 5cm;
        }
    </style>
</head>
<body>
    <div class="header text-center">
        <img class="imgHeader" src="{{asset('img/logo.jpeg')}}" alt="logo">
        <div class="infoHeader">
            <h1 class="text-center">NutriSoft - Sistema de Gestión Nutricional </h1>
        </div>
    </div>

    <div class="container">
        <div class="hijo">
            <div class="row mt-3 text-center">
                <div class="col-lg-12">
                    <h3>¡Bienvenido/a a NutriSoft!</h3>
                    <h5>Complete su registro como nutricionista</h5>
                    <br>
                    <p>Para completar tu registro y configurar tu contraseña, haz clic en el siguiente enlace:</p>
                    <br>
                    <a class="btn btn-success" href="{{ route('mostrar-completar-registro', $userId) }}">Completar Registro</a>

                    <br>
                    <p>Inicie sesión con estos datos temporales: </p>
                    <div class="alert alert-warning mt-3 text-center" role="alert">
                        <strong>Email:</strong> {{ $email }}<br>
                        <strong>Contraseña:</strong> {{ $passwordTemporal }} <br>
                        <p>Este enlace caducará en 24 horas.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
