@extends('adminlte::page')

@section('title', 'Turnos Pendientes')

@section('content_header')
    <h1>Turnos pendientes</h1>
@stop

@section('content')

    <div class="card card-dark">
        <div class="card-header">
            <h5>Turnos del día</h5>
        </div>

        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Paciente</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $turnosPendientesEncontrados = false;
                    @endphp

                    @foreach ($turnos as $turno)
                        @if ($turno->fecha == $fechaActual && $turno->estado == 'Pendiente')
                            @foreach ($pacientes as $paciente)
                                @if ($paciente->id == $turno->paciente_id && $turno->estado == 'Pendiente')
                                    @php
                                        $turnosPendientesEncontrados = true;
                                    @endphp
                                    <tr>
                                        <td>
                                        {{ $turno->fecha }}
                                        </td>
                                        <td>
                                            {{ $turno->hora }}
                                        </td>
                                        <td>
                                            {{ $paciente->user->name }} {{ $paciente->user->apellido }}
                                        </td>
                                        <td>
                                            <a class="btn btn-success" href="{{route('gestion-turnos-nutricionista.iniciarConsulta', $turno->id)}}">Iniciar consulta</a>
                                            <form action="{{ route('gestion-turnos-nutricionista.confirmarInasistencia', $turno->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">No asistió</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                    @if (!$turnosPendientesEncontrados)
                        <tr>
                            <td colspan="4"><h5>No hay turnos pendientes para el día de hoy</h5></td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="card card-dark">
        <div class="card-header">
            <h5>Turnos de la semana</h5>
        </div>

        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Paciente</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $turnosPendientesEncontrados = false;
                    @endphp

                    @foreach ($turnosSemanaPendiente as $turnoSemana)
                        @if ($turnoSemana->fecha != $fechaActual && $turnoSemana->estado == 'Pendiente')
                            @foreach ($pacientes as $paciente)
                                @if ($paciente->id == $turnoSemana->paciente_id && $turnoSemana->estado == 'Pendiente')
                                    @php
                                        $turnosPendientesEncontrados = true;
                                    @endphp
                                    <tr>
                                        <td>
                                        {{ $turnoSemana->fecha }}
                                        </td>
                                        <td>
                                            {{ $turnoSemana->hora }}
                                        </td>
                                        <td>
                                            {{ $paciente->user->name }} {{ $paciente->user->apellido }}
                                        </td>
                                        <td>
                                            <a class="btn btn-success" href="{{route('gestion-turnos-nutricionista.iniciarConsulta', $turno->id)}}">Iniciar consulta</a>
                                            <form action="{{ route('gestion-turnos-nutricionista.confirmarInasistencia', $turno->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">No asistió</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                    @if (!$turnosPendientesEncontrados)
                        <tr>
                            <td colspan="4"><h5>No hay turnos pendientes para esta semana</h5></td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@stop
