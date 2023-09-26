@extends('adminlte::page')

@section('title', 'Turnos Pendientes')

@section('content_header')
    <h1>Turnos pendientes</h1>
@stop

@section('content')

    <div class="card card-dark">
        <div class="card-header">
            <h5>Turnos Pendientes</h5>
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
                    @foreach ($turnos as $turno)
                        @if ($turno->estado == 'Pendiente')
                            <tr>
                                <td>
                                {{ $turno->fecha }}
                                </td>
                                <td>
                                    {{ $turno->hora }}
                                </td>
                                <td>

                                    @foreach ($pacientes as $paciente)
                                        @if ($paciente->id == $turno->paciente_id && $turno->estado == 'Pendiente')
                                            {{ $paciente->user->name }} {{ $paciente->user->apellido }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>

                                    <a class="btn btn-success" href="{{route('gestion-turnos-nutricionista.create')}}">Iniciar consulta</a>
                                    <a class="btn btn-danger" href="{{route('gestion-turnos-nutricionista.create')}}">No asistió</a>

                                </td>
                            </tr>
                        @endif
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
