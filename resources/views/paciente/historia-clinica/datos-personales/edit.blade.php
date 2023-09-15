@extends('adminlte::page')

@section('title', 'Mi Historia Clínica')

@section('content_header')

@stop

@section('content')
    <div class="card card-dark">
        <div class="card-header">
            <button class="btn btn-link float-right" onclick="toggleCard('datosPersonales')">
                <i class="fa fa-minus"></i>
            </button>
            <h5>Datos Personales</h5>
        </div>
        <div id="datosPersonales" class="card-body">
            <form class="row g-3" action="{{route('datos-personales.update', $paciente->id)}}" method="POST">
            @csrf
                <div class="col-md-6">
                    <label for="dni" class="form-label">DNI</label>
                    <input type="text" class="form-control @error('dni') is-invalid @enderror" id="dni" name="dni" value="{{$paciente->dni}}">

                    @error('dni')
                        <div class="invalid-feedback">{{ $message}}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{$paciente->telefono}}">

                    @error('telefono')
                        <div class="invalid-feedback">{{ $message}}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="sexo" class="form-label">Sexo</label>
                    <select id="sexo" class="form-select @error('sexo') is-invalid @enderror" name="sexo">
                        <option value="" disabled>Elija una opción...</option>
                        <option value="Masculino" @if ($paciente->sexo == 'Masculino') selected @endif>Masculino</option>
                        <option value="Femenino" @if ($paciente->sexo == 'Femenino') selected @endif>Femenino</option>
                    </select>

                    @error('sexo')
                        <div class="invalid-feedback">{{ $message}}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="edad" class="form-label">Edad</label>
                    <input type="number" class="form-control @error('edad') is-invalid @enderror" id="edad" name="edad" value="{{$paciente->edad}}">

                    @error('edad')
                        <div class="invalid-feedback">{{ $message}}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                    <input type="date" value="{{$paciente->fecha_nacimiento}}" class="form-control @error('fecha_nacimiento') is-invalid @enderror" id="fecha_nacimiento" name="fecha_nacimiento">

                    @error('fecha_nacimiento')
                        <div class="invalid-feedback">{{ $message}}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <div class="float-right">
                        <button type="submit" class="btn btn-success">Guardar</button>
                        <a href="{{ route('historia-clinica.index') }}" class="btn btn-danger" tabindex="7">Cancelar</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


@stop
