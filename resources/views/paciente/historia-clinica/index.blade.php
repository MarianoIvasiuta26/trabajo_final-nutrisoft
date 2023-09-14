@extends('adminlte::page')

@section('title', 'Mi Historia Clínica')

@section('content_header')
    <h1>Mi Historia Clínica</h1>
@stop

@section('content')
    <div class="container mt-4">
        <div class="row">
            <!-- Datos Personales -->
            <div class="col-md-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <h5>Datos Personales</h5>
                    </div>
                    <div class="card-body">
                        <!-- Mostrar los datos personales aquí -->
                        <p>DNI: {{ $paciente->dni }}</p>
                        <p>Teléfono: {{ $paciente->telefono }}</p>
                        <p>Sexo: {{ $paciente->sexo }}</p>
                        <p>Edad: {{ $paciente->edad }}</p>
                        <p>Fecha de Nacimiento: {{ $paciente->fecha_nacimiento }}</p>
                        <!-- Agregar más campos según sea necesario -->
                    </div>
                </div>
            </div>

            <!-- Días y Horas Fijos disponibles -->
            <div class="col-md-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <h5>Días y Horas Fijos disponibles</h5>
                    </div>
                    <div class="card-body">
                        <!-- Mostrar los días y horas disponibles aquí -->
                        <p>Días disponibles:</p>
                        <ul>
                            @foreach ($diasDisponibles as $dia)
                                <li>{{ $dia }}</li>
                            @endforeach
                        </ul>
                        <p>Horas disponibles:</p>
                        <ul>
                            @foreach ($horasDisponibles as $hora)
                                <li>{{ $hora }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Datos Físicos -->
            <div class="col-md-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <h5>Datos Físicos</h5>
                    </div>
                    <div class="card-body">
                        <!-- Mostrar los datos físicos aquí -->
                        <p>Peso: {{ $historiaClinica->peso }}</p>
                        <p>Altura: {{ $historiaClinica->altura }}</p>
                        <!-- Agregar más campos según sea necesario -->
                    </div>
                </div>
            </div>

            <!-- Datos Médicos -->
            <div class="col-md-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <h5>Datos Médicos</h5>
                    </div>
                    <div class="card-body">
                        <!-- Mostrar los datos médicos aquí -->
                        <p>Anamnesis Alimentaria:</p>
                        <!-- Iterar y mostrar alimentos preferidos y no gustados -->
                        <ul>
                            @foreach ($anamnesisAlimentaria as $anamnesis)
                                <li>{{ $anamnesis->alimento }} - {{ $anamnesis->gusta ? 'Gusta' : 'No gusta' }}</li>
                            @endforeach
                        </ul>
                        <p>Alergias:</p>
                        <!-- Iterar y mostrar alergias -->
                        <ul>
                            @foreach ($alergias as $alergia)
                                <li>{{ $alergia->alergia }}</li>
                            @endforeach
                        </ul>
                        <p>Cirugías:</p>
                        <!-- Iterar y mostrar cirugías -->
                        <ul>
                            @foreach ($cirugias as $cirugia)
                                <li>{{ $cirugia->cirugia }} - {{ $cirugia->tiempo }} {{ $cirugia->unidad }}</li>
                            @endforeach
                        </ul>
                        <p>Patologías:</p>
                        <!-- Iterar y mostrar patologías -->
                        <ul>
                            @foreach ($patologias as $patologia)
                                <li>{{ $patologia->patologia }}</li>
                            @endforeach
                        </ul>
                        <p>Intolerancias:</p>
                        <!-- Iterar y mostrar intolerancias -->
                        <ul>
                            @foreach ($intolerancias as $intolerancia)
                                <li>{{ $intolerancia->intolerancia }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

@stop
