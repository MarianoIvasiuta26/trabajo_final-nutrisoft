@extends('adminlte::page')

@section('title', 'Mi Historia Clínica')

@section('content_header')

@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Profile Widget -->
                <div class="card card-widget widget-user">
                    <div class="widget-user-header bg-gradient-dark">
                        <h3 class="widget-user-username">{{ Auth::user()->name}} {{Auth::user()->apellido}}</h3>
                        <h5 class="widget-user-desc">{{ Auth::user()->tipo_usuario}}</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle elevation-2" src="{{ asset('img/usuario.png') }}" alt="User Avatar">
                    </div>
                    <div class="card-footer">
                        <!-- Datos Personales -->
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">DNI</h5>
                                    <span class="description-text">{{ $paciente->dni }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">Teléfono</h5>
                                    <span class="description-text">{{ $paciente->telefono }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">Fecha de Nacimiento</h5>
                                    <span class="description-text">{{ $paciente->fecha_nacimiento }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3 ">
                            <div class="col-sm-6 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">Edad</h5>
                                    <span class="description-text">{{ $paciente->edad }}</span>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="description-block">
                                    <h5 class="description-header">Sexo</h5>
                                    <span class="description-text">{{ $paciente->sexo }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Profile Widget -->
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <!-- Días y Horas Fijos disponibles -->
            <div class="col-md-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <ul class="nav nav-tabs justify-content-center card-header-tabs">
                            <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#dias-horas">Días y Horas Fijos disponibles</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="#datos-fisicos">Datos Físicos</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="#datos-medicos">Datos Médicos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#historial-turnos">Historial de turnos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#planes">Planes</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div id="dias-horas" class="tab-pane active">
                                <!-- Mostrar los días y horas disponibles aquí -->
                                <p>Días disponibles:</p>
                                @foreach ($adelantamientos as $adelantamiento)
                                    @if ($adelantamiento->dias_fijos)
                                        <p>{{ $adelantamiento->dias_fijos }}</p>
                                    @else
                                        <p>No hay días disponibles</p>
                                    @endif

                                @endforeach

                                <p>Horas disponibles:</p>
                                @foreach ($adelantamientos as $adelantamiento)
                                    @if ($adelantamiento->horas_fijas)
                                        <p>{{ $adelantamiento->horas_fijas }}</p>
                                    @else
                                        <p>No hay horas disponibles</p>
                                    @endif

                                @endforeach
                            </div>

                            <!-- Datos Físicos -->
                            <div id="datos-fisicos" class="tab-pane">
                                <p>Peso: {{ $historiaClinica->peso }}</p>
                                <p>Altura: {{ $historiaClinica->altura }}</p>
                            </div>

                            <!-- Datos Médicos -->

                            <div id="datos-medicos" class="tab-pane">
                                <p>Anamnesis Alimentaria:</p>
                                <!-- Iterar y mostrar alimentos preferidos y no gustados -->
                                <ul>
                                    @foreach ($anamnesisAlimentaria as $anamnesis)
                                        <li>{{ $anamnesis->alimento }}</li>
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
                            <!-- Historial de turnos -->
                            <div id="historial-turnos" class="tab-pane">

                            </div>

                            <!-- Planes -->
                            <div id="planes" class="tab-pane">

                            </div>
                        </div>


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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Inicializa las pestañas al cargar la página
        $(document).ready(function () {
            $('.nav-tabs a').click(function () {
                $(this).tab('show');
            });
        });
    </script>

@stop
