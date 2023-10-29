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

            <div class="accordion accordion-flush mt-3" id="detallesConsulta">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            <h5>Detalles de la consulta</h5>
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <table class="table table-striped" id="consultas">
                                <tbody>
                                    <tr>
                                        <th scope="col">Peso Actual</th>
                                        <td>{{ $turno->consulta->peso_actual }} (kg)</td>
                                    </tr>

                                    <tr>
                                        <th scope="col">Altura Actual</th>
                                        <td>{{ $turno->consulta->altura_actual }} (cm)</td>
                                    </tr>

                                    <tr>
                                        <th scope="col">Circunferencia de Muñeca Actual</th>
                                        <td>{{ $turno->consulta->circunferencia_munieca_actual }} (cm)</td>
                                    </tr>
                                        <th scope="col">Circunferencia de Cintura Actual</th>
                                        <td>{{ $turno->consulta->circunferencia_cintura_actual }} (cm)</td>
                                    </tr>

                                    <tr>
                                        <th scope="col">Circunferencia de Cadera Actual</th>
                                        <td>{{ $turno->consulta->circunferencia_cadera_actual }} (cm)</td>
                                    </tr>

                                    <tr>
                                        <th scope="col">Circunferencia de Pecho Actual</th>
                                        <td>{{ $turno->consulta->circunferencia_pecho_actual }} (cm)</td>
                                    </tr>

                                </tbody>
                            </table>

                            <div class="card mt-3">
                                <div class="card-header">
                                    <h5>Diagnóstico</h5>
                                </div>
                                <div class="card-body">
                                    <p>{{ $turno->consulta->diagnostico->descripcion_diagnostico }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


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
