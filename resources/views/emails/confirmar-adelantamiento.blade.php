<!DOCTYPE html>
<html>
<head>
    <title>Adelantamiento de turno</title>
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
                <h5>¡Hola!</h5>
                <p>¡Hemos encontrado la posibilidad de adelantar su turno!</p>
            </div>

            <div class="row mt-3 text-center">
                <div class="col-lg-12">
                    <h5>Turno nuevo:</h5>
                    <br>
                    <p><strong>Fecha:</strong> {{$fechaAdelantado}}</p>
                    <p><strong>Hora:</strong> {{$horaAdelantado}}</p>
                    <br>
                    <p class="text-center mt-3">¿Desea confirmar el nuevo turno?</p>
                    <a class="btn btn-success mt-3" href="{{ route('obtener-confirmacion-nuevo-turno', $turnoTemporalId) }}">Ir a NutriSoft</a>

                </div>

            </div>




        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
