@extends('adminlte::page')

@section('title', 'Mi Historia Clínica')

@section('content_header')

@stop

@section('content')

    {{-- Perfil de la HC --}}
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Profile Widget -->
                <div class="card card-widget widget-user">
                    <div class="widget-user-header bg-success bg-gradient">
                        <h3 class="widget-user-username">{{ Auth::user()->name}} {{Auth::user()->apellido}}</h3>
                        <h5 class="widget-user-desc">{{ Auth::user()->tipo_usuario}}</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle elevation-2" src="{{ asset('img/usuario.png') }}" alt="User Avatar">
                    </div>

                    <div class="card-footer">
                        <!-- Datos Personales -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="description-block">
                                    <h5 class="description-header">Estilo de Vida</h5>
                                    <span class="description-text">{{$historiaClinica->estilo_vida}}</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="description-block">
                                    <h5 class="description-header">Objetivo de Salud</h5>
                                    <span class="description-text">{{$historiaClinica->objetivo_salud}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Profile Widget -->
            </div>
        </div>
    </div>

    {{-- Datos del paciente --}}
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-dark">
                    <div class="card-header bg-success">
                        <ul class="nav nav-tabs justify-content-center card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#datos-personales">Datos Personales</a>
                                </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#dias-horas">Días y Horas Fijos disponibles</a>
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
                            <div id="datos-personales" class="tab-pane active">
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

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="float-right">
                                            <a href="{{route('datos-personales.edit', $paciente->id)}}" class="btn btn-warning float-right">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                </svg>
                                                Editar
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div id="dias-horas" class="tab-pane">

                                <table class="table table-striped mt-4">
                                    <thead>
                                        <tr>
                                            <th scope="col">Días libres</th>
                                            <th scope="col">Horas libres</th>
                                            <th scope="col">Acciones</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($adelantamientos as $adelantamiento)
                                            <tr>
                                                <td>
                                                    @if(is_array($adelantamiento->dias_fijos))
                                                        @foreach ($adelantamiento->dias_fijos as $dia)
                                                            {{ $dia }}
                                                        @endforeach
                                                    @else
                                                        {{ $adelantamiento->dias_fijos }}
                                                    @endif
                                                </td>

                                                <td>
                                                    @if(is_array($adelantamiento->horas_fijas))
                                                        @foreach ($adelantamiento->horas_fijas as $hora)
                                                            {{ $hora }}
                                                        @endforeach
                                                    @else
                                                        {{ $adelantamiento->horas_fijas }}
                                                    @endif
                                                </td>

                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-info" href="{{ route('adelantamiento-turno.edit', $paciente->id) }}">Editar</a>
                                                        <form action="{{ route('adelantamiento-turno.destroy', $adelantamiento->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger ml-2" type="submit">Eliminar</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2">No se encontraron registros de días y horarios de atención.</td>
                                                <td colspan="1">
                                                    <a href="{{route('adelantamiento-turno.edit', $paciente->id)}}" class="btn btn-warning">
                                                        Agregar
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforelse
                                        <tr>
                                            <td colspan="3">
                                                <a href="{{route('adelantamiento-turno.create', $paciente->id)}}" class="btn btn-warning">
                                                    Agregar
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Datos Físicos -->
                            <div id="datos-fisicos" class="tab-pane">
                                <div class="row">
                                    <div class="col-sm-6 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">Peso</h5>
                                            <span class="description-text">{{ $historiaClinica->peso }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="description-block">
                                            <h5 class="description-header">Altura</h5>
                                            <span class="description-text">{{ $historiaClinica->altura }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-sm-3 border-right">
                                        <div class="description-block ">
                                            <h5 class="description-header">Cirunferencia de Muñeca</h5>
                                            <span class="description-text">{{ $historiaClinica->circunferencia_munieca}}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">Cirunferencia de Cintura</h5>
                                            <span class="description-text">{{ $historiaClinica->circunferencia_cintura}}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">Cirunferencia de Cadera</h5>
                                            <span class="description-text">{{ $historiaClinica->circunferencia_cadera}}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="description-block">
                                            <h5 class="description-header">Circunferencia de Pecho</h5>
                                            <span class="description-text">{{ $historiaClinica->circunferencia_pecho}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="float-right">
                                            <a href="{{route('historia-clinica.edit', $historiaClinica->id)}}" class="btn btn-warning float-right">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                </svg>
                                                Editar
                                            </a>
                                        </div>
                                    </div>
                                </div>
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

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="float-right">
                                            <a href="{{route('datos-medicos.edit', $historiaClinica->id)}}" class="btn btn-warning float-right">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                </svg>
                                                Editar
                                            </a>
                                        </div>
                                    </div>
                                </div>
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
    @if (session('info'))
        <div class="alert alert-info">
            {{ session('info') }}
            <a href="{{ route('historia-clinica.create') }}" class="btn btn-primary">Completar Historia Clínica</a>
        </div>
    @else
        <!-- Resto de tu contenido aquí... -->
    @endif

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

    <script>
        // Inicializa las pestañas al cargar la página
        $(document).ready(function () {
            $('.nav-tabs a').click(function () {
                $(this).tab('show');
            });
        });
    </script>

@stop
