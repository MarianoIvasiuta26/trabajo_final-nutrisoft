@extends('adminlte::page')

@section('title', 'Solicitar turno')

@section('content_header')

@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <h1>Confirmación de nuevo turno</h1>
        </div>
        <div class="card-body">
            <h5>¡Bienvenido, {{$pacienteTurnoNuevo->user->name}}! </h5>

            <p>Turno Anterior:</p>
            <table class="table table-striped" id="turnos">
                <thead>
                <tr>
                    <th scope="col">Fecha</th>
                    <th scope="col">Hora</th>
                </tr>
                </thead>
                <tbody>
                        <tr>
                            <td>{{ $turnoAdelantado->fecha }}</td>
                            <td>{{ $turnoAdelantado->hora }}</td>
                        </tr>
                </tbody>
            </table>

            <p>Turno Nuevo:</p>
            <table class="table table-striped" id="turnos">
                <thead>
                <tr>
                    <th scope="col">Fecha</th>
                    <th scope="col">Hora</th>
                </tr>
                </thead>
                <tbody>
                        <tr>
                            <td>{{ $turnoCancelado->fecha }}</td>
                            <td>{{ $turnoCancelado->hora }}</td>
                        </tr>
                </tbody>

            <p>¿Desea confirmar el nuevo turno?</p>
            <div class="row">
                <div class="col-md-6">
                    <form method="POST" action="{{ route('confirmar-adelantamiento-turno', $turnoTemporal->id) }}">
                        @csrf
                        <button class="btn btn-success" type="submit">Confirmar adelantamiento de turno</button>
                    </form>
                </div>

                <div class="col-md-6">
                    <form method="POST" action="{{ route('rechazar-adelantamiento-turno', $turnoTemporal->id) }}">
                        @csrf
                        <button class="btn btn-danger" type="submit">Rechazar adelantamiento de turno</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

    </script>
@stop
