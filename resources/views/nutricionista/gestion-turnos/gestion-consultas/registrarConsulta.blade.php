@extends('adminlte::page')

@section('title', 'Registrar Consulta')

@section('content_header')
    <h1>Registrar Consulta</h1>
@stop

@section('content')
    <div class="card card-dark">
        <div class="card-header">
            <h5>Paciente: {{$paciente->user->name}} {{$paciente->user->apellido}}</h5>
        </div>

        <div class="card-body">
            <form action="{{route('gestion-consultas.store', $turno->id)}}" method="post">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <label for="fecha">Fecha</label>
                        <input class="form-control" name="fecha" id="fecha" type="date" disabled value="{{$turno->fecha}}">
                    </div>

                    <div class="col-md-6">
                        <label for="hora">Hora</label>
                        <input class="form-control" name="hora" id="hora" type="time" disabled value="{{$turno->hora}}">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col">
                        <label for="tipo_consulta">Tipo de Consulta</label>
                        <select class="form-select" name="tipo_consulta" id="tipo_consulta">
                            @foreach ($tipoConsultas as $tipoConsulta)
                                <option value="{{$tipoConsulta->id}}" @if ($turno->tipo_consulta_id == $tipoConsulta->id)
                                    selected
                                @endif disabled>{{$tipoConsulta->tipo_consulta}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <label for="paciente">Paciente</label>
                        <input class="form-control" name="paciente" id="paciente" type="text" disabled value="{{$paciente->user->name}} {{$paciente->user->apellido}}">
                    </div>

                    <div class="col-md-4">
                        <label for="objetivo_salud">Objetivo de Salud</label>
                        <input class="form-control" name="objetivo_salud" id="objetivo_salud" type="text" disabled value="{{$historiaClinica->objetivo_salud}}">
                    </div>

                    <div class="col-md-4">
                        <label for="estilo_vida">Estilo de vida</label>
                        <input class="form-control" name="estilo_vida" id="estilo_vida" type="text" disabled value="{{$historiaClinica->estilo_vida}}">
                    </div>
                </div>

                <div class="row mt-3">
                    <h5>Datos Físicos del paciente</h5>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="peso_actual">Peso actual</label>
                        <div class="input-group">
                            <input class="form-control" name="peso_actual" id="peso_actual" type="number">
                            <div class="input-group-append">
                                <span class="input-group-text">cm</span>
                            </div>
                        </div>
                        @error('peso_actual')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="altura_actual">Altura actual</label>
                        <div class="input-group">
                            <input class="form-control" name="altura_actual" id="altura_actual" type="number">
                            <div class="input-group-append">
                                <span class="input-group-text">cm</span>
                            </div>
                        </div>
                        @error('altura_actual')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="circ_munieca_actual">Circunferencia de muñeca</label>
                        <div class="input-group">
                            <input class="form-control" name="circ_munieca_actual" id="circ_munieca_actual" type="number">
                            <div class="input-group-append">
                                <span class="input-group-text">cm</span>
                            </div>
                        </div>
                        @error('circ_munieca_actual')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="circ_cadera_actual">Circunferencia de cadera</label>
                        <div class="input-group">
                            <input class="form-control" name="circ_cadera_actual" id="circ_cadera_actual" type="number">
                            <div class="input-group-append">
                                <span class="input-group-text">cm</span>
                            </div>
                        </div>
                        @error('circ_cadera_actual')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="circ_cintura_actual">Circunferencia de cintura</label>
                        <div class="input-group">
                            <input class="form-control" name="circ_cintura_actual" id="circ_cintura_actual" type="number">
                            <div class="input-group-append">
                                <span class="input-group-text">cm</span>
                            </div>
                        </div>
                        @error('circ_cintura_actual')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="circ_pecho_actual">Circunferencia de pecho</label>
                        <div class="input-group">
                            <input class="form-control" name="circ_pecho_actual" id="circ_pecho_actual" type="number">
                            <div class="input-group-append">
                                <span class="input-group-text">cm</span>
                            </div>
                        </div>
                        @error('circ_pecho_actual')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col">
                        <label for="diagnostico">Diagnóstico</label>
                        <textarea class="form-control" name="diagnostico" id="diagnostico" cols="30" rows="5"></textarea>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="float-right">
                            <button type="submit" class="btn btn-success">Guardar</button>
                            <a href="{{ route('gestion-turnos-nutricionista.index') }}" class="btn btn-danger" tabindex="7">Cancelar</a>
                        </div>
                    </div>
                </div>

            </form>
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
