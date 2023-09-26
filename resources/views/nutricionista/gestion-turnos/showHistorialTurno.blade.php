@extends('adminlte::page')

@section('title', 'Historial de Turnos')

@section('content_header')
    <h1>Historial de Turnos</h1>
@stop

@section('content')

    <div class="card card-dark">
        <div class="card-header">
            <h5>Historial de Turnos</h5>
        </div>

        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Paciente</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Tipo de consulta</th>
                        <th scope="col">Objetivo de salud</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($turnos as $turno)
                        @foreach ($pacientes as $paciente)
                            @if ($paciente->id == $turno->paciente_id)
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
                                        {{ $turno->estado }}
                                    </td>

                                    <td>
                                        @foreach ($tipoConsultas as $tipoConsulta)
                                            @if ($tipoConsulta->id == $turno->tipo_consulta_id)
                                                {{ $tipoConsulta->tipo_consulta }}
                                            @endif
                                        @endforeach
                                    </td>

                                    <td>
                                        @foreach ($historiasClinicas as $historiaClinica)
                                            @if ($historiaClinica->paciente_id == $paciente->id)
                                                {{ $historiaClinica->objetivo_salud }}
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach

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
