<!DOCTYPE html>
<html>
<head>
    <title>Adelantamiento de turno</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />

</head>
<body>
    <p>¡Hola!</p>
    <p>¡Hemos encontrado la posibilidad de adelantar su turno!</p>
    <p>Turno nuevo:</p>
    <p>Fecha: {{$fechaAdelantado}}</p>
    <p>Hora: {{$horaAdelantado}}</p>
    <p>¿Desea confirmar el nuevo turno?</p>

    <div class="row mt-3">
        <div class="col-md-6">
            <a href="{{ route('obtener-confirmacion-nuevo-turno', $turnoTemporalId) }}">Confirmar adelantamiento de turno</a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('obtener-confirmacion-nuevo-turno', $turnoTemporalId) }}">Rechazar adelantamiento de turno</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
