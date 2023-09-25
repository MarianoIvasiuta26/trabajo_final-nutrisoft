@extends('adminlte::page')

@section('title', 'Mis turnos')

@section('content_header')
    <h1>Turno - {{$paciente->user->name}}</h1>
@stop

@section('content')


    <div class="card card-dark">
        <div class="card-header">
            <h5>Turno {{$turno->id}}</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="turnos">
                <thead>
                <tr>
                    <th scope="col">Paciente</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Objetivo de salud</th>
                    <th scope="col">Tipo de consulta</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Profesional</th>
                </tr>
                </thead>
                <tbody>

                        <tr>
                            <td>{{ $paciente->user->name }}</td>
                            <td>{{ $turno->fecha }}</td>
                            <td>{{ $turno->hora }}</td>
                            <td>
                                @foreach ($historias_clinicas as $hitoriaClinica)
                                    @if ($hitoriaClinica->paciente_id == $paciente->id)
                                        {{ $hitoriaClinica->objetivo_salud }}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach ($tipo_consultas as $tipoConsulta)
                                    @if ($tipoConsulta->id == $turno->tipo_consulta_id)
                                        {{ $tipoConsulta->tipo_consulta }}
                                    @endif
                                @endforeach
                            </td>
                            <td>{{ $turno->estado }}</td>
                            <td>
                                @foreach ($profesionales as $profesional)
                                    @foreach ($horarios as $horario)
                                        @if ($horario->id == $turno->horario_id)
                                            @if ($horario->nutricionista_id == $profesional->id)
                                                {{ $profesional->user->name}} {{ $profesional->user->apellido}}
                                            @endif
                                        @endif
                                    @endforeach
                                @endforeach
                            </td>
                        </tr>


                </tbody>
            </table>

            <a href="{{route('turnos.index')}}" class="btn btn-danger mt-3 float-right">Volver</a>

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
