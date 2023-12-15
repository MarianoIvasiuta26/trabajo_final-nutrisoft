@extends('adminlte::page')

@section('title', 'Mi Historia Clínica')

@section('content_header')

@stop

@section('content')
    @if(auth()->user()->tipo_usuario === 'Paciente' && !app('App\Http\Controllers\PacienteController')->hasCompletedHistory())

    <div class="alert alert-warning mt-3" role="alert">
        Parece que aún no has completado su registro. <br>
        Haga click en el siguiente enlace para completar su registro:
        <a href="{{ route('historia-clinica.create') }}" class="alert-link">Completar registro</a>
    </div>
    @else
        @if(auth()->user()->tipo_usuario === 'Paciente' && app('App\Http\Controllers\PacienteController')->hasCompletedHistory())
            @if (!app('App\Http\Controllers\PacienteController')->hasCompletedDatosMedicos() || !app('App\Http\Controllers\PacienteController')->hasCompletedCirugias() || !app('App\Http\Controllers\PacienteController')->hasCompletedAnamnesis())
                <div class="alert alert-warning mt-3" role="alert">
                    Parece que aún no has terminado de completar su registro. Recuerda que es importante que lo completes para tener acceso a todas las funcionalidades del sistema.<br>
                    Haga click en el siguiente enlace para completarlo:
                    <a href="{{ route('historia-clinica.create') }}" class="alert-link">Continuar completando registro</a>
                </div>
            @else
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

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
                                            <a class="nav-link active" aria-current="page" href="#datos-personales" id="tab-datos-personales">Datos Personales</a>
                                            </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#dias-horas" id="tab-dias-horas">Días y Horas Fijos disponibles</a>
                                        </li>
                                        <li class="nav-item">
                                        <a class="nav-link" href="#datos-fisicos" id="tab-datos-fisicos">Datos Físicos</a>
                                        </li>
                                        <li class="nav-item">
                                        <a class="nav-link" href="#datos-medicos" id="tab-datos-medicos">Datos Médicos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#historial-turnos" id="tab-historial-turnos">Historial de turnos</a>
                                        </li>
                                        <!--
                                        <li class="nav-item">
                                            <a class="nav-link" href="#planes" id="tab-planes">Planes</a>
                                        </li>
                                    -->
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
                                                        <span class="description-text">{{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->format('d-m-Y') }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3 ">
                                                <div class="col-sm-6 border-right">
                                                    <div class="description-block">
                                                        <h5 class="description-header">Edad</h5>
                                                        <span class="description-text">{{ $paciente->edad }}</span> <span>años</span>
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
                                            <a href="{{route('adelantamiento-turno.create', $paciente->id)}}" class="btn btn-warning">
                                                Agregar
                                            </a>

                                            <div class="mt-3">
                                                <table class="table table-striped mt-4" id="tabla-dias-horas">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Días libres</th>
                                                            <th scope="col">Horas libres</th>
                                                            <th scope="col">Acciones</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($adelantamientos as $adelantamiento)
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
                                                                    <div class="btn-group">{{--
                                                                        <a class="btn btn-info" href="{{ route('adelantamiento-turno.edit', $paciente->id) }}">Editar</a>--}}
                                                                        <form action="{{ route('adelantamiento-turno.destroy', $adelantamiento->id) }}" method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button class="btn btn-danger ml-2 delete-button" type="button">Eliminar</button>
                                                                        </form>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>

                                        <!-- Datos Físicos -->
                                        <div id="datos-fisicos" class="tab-pane">
                                            <div class="row">
                                                <div class="col-sm-6 border-right">
                                                    <div class="description-block">
                                                        <h5 class="description-header">Peso</h5>
                                                        <span class="description-text">{{ $historiaClinica->peso }}</span> <span>kg</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="description-block">
                                                        <h5 class="description-header">Altura</h5>
                                                        <span class="description-text">{{ $historiaClinica->altura }}</span> <span>cm</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-sm-3 border-right">
                                                    <div class="description-block ">
                                                        <h5 class="description-header">Cirunferencia de Muñeca</h5>
                                                        <span class="description-text">{{ $historiaClinica->circunferencia_munieca}}</span> <span>cm</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 border-right">
                                                    <div class="description-block">
                                                        <h5 class="description-header">Cirunferencia de Cintura</h5>
                                                        <span class="description-text">{{ $historiaClinica->circunferencia_cintura}}</span> <span>cm</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 border-right">
                                                    <div class="description-block">
                                                        <h5 class="description-header">Cirunferencia de Cadera</h5>
                                                        <span class="description-text">{{ $historiaClinica->circunferencia_cadera}}</span> <span>cm</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="description-block">
                                                        <h5 class="description-header">Circunferencia de Pecho</h5>
                                                        <span class="description-text">{{ $historiaClinica->circunferencia_pecho}}</span> <span>cm</span>
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
                                            <div class="row">
                                                <div class="col-9 mb-3">
                                                    <h5>Gustos alimenticios</h5>
                                                </div>
                                                {{--
                                                <div class="col-3">
                                                    <a href="{{route('datos-medicos.create', $paciente->id)}}" class="btn btn-warning float-right">
                                                        Agregar
                                                    </a>
                                                </div>
                                                --}}
                                                <!-- Pestañas desplegables para anamnesis -->
                                                <div class="accordion" id="alimentosPrefTabs">
                                                    <!-- Alimentos Preferidos -->
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="alimentosPrefHeading">
                                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#alimentosPrefCollapse" aria-expanded="true" aria-controls="alimentosPrefCollapse">
                                                                Alimentos Preferidos
                                                            </button>
                                                        </h2>
                                                        <div id="alimentosPrefCollapse" class="accordion-collapse collapse" aria-labelledby="alimentosPrefHeading">
                                                            <div class="accordion-body">
                                                                <table class="table table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Alimento</th>
                                                                            <th>Opciones</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($alimentos as $alimento)
                                                                            @forelse ($anamnesisAlimentaria as $anamnesis)
                                                                                @if ($anamnesis->alimento_id == $alimento->id)
                                                                                    @if ($anamnesis->gusta == 1)
                                                                                        <tr>
                                                                                            <td>{{ $alimento->alimento }}</td>
                                                                                            <td>
                                                                                                @if ($alimento->alimento != 'Sin Alimento')
                                                                                                    <div class="btn-group">
                                                                                                        {{--<a class="btn btn-info" href="{{ route('datos-medicos.edit', $anamnesis->id) }}">Editar</a>--}}
                                                                                                        <form action="{{ route('datos-medicos.destroy', $anamnesis->id) }}" method="POST">
                                                                                                            @csrf
                                                                                                            @method('DELETE')
                                                                                                            <button class="btn btn-danger ml-2" type="submit">Eliminar</button>
                                                                                                        </form>
                                                                                                    </div>
                                                                                                @endif
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endif
                                                                                @endif
                                                                            @empty
                                                                                <h5>No se encontraron anamnesis alimentarias registradas.</h5>
                                                                            @endforelse
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item mb-3" id="alimentosNoPrefTabs">
                                                        <!-- Alimentos No Preferidos -->
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="alimentosNoPrefHeading">
                                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#alimentosNoPrefCollapse" aria-expanded="true" aria-controls="alimentosNoPrefCollapse">
                                                                    Alimentos No Preferidos
                                                                </button>
                                                            </h2>
                                                            <div id="alimentosNoPrefCollapse" class="accordion-collapse collapse" aria-labelledby="alimentosNoPrefHeading">
                                                                <div class="accordion-body">
                                                                    <table class="table table-striped">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Alimento</th>
                                                                                <th>Opciones</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($alimentos as $alimento)
                                                                                @forelse ($anamnesisAlimentaria as $anamnesis)
                                                                                    @if ($anamnesis->alimento_id == $alimento->id)
                                                                                        @if ($anamnesis->gusta == 0)
                                                                                            <tr>
                                                                                                <td>{{ $alimento->alimento }}</td>
                                                                                                <td>
                                                                                                    @if ($alimento->alimento != 'Sin Alimento')
                                                                                                        <div class="btn-group">
                                                                                                            {{--<a class="btn btn-info" href="{{ route('datos-medicos.edit', $anamnesis->id) }}">Editar</a>--}}
                                                                                                            <form action="{{ route('datos-medicos.destroy', $anamnesis->id) }}" method="POST">
                                                                                                                @csrf
                                                                                                                @method('DELETE')
                                                                                                                <button class="btn btn-danger ml-2" type="submit">Eliminar</button>
                                                                                                            </form>
                                                                                                        </div>
                                                                                                    @endif
                                                                                                </td>
                                                                                            </tr>
                                                                                        @endif
                                                                                    @endif
                                                                                @empty
                                                                                    <h5>No se encontraron anamnesis alimentarias registradas.</h5>
                                                                                @endforelse
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <!-- Fin de pestañas desplegables -->
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-9 mb-3">
                                                    <h5>Alergias</h5>
                                                </div>
                                                {{--
                                                <div class="col-3">
                                                    <a href="{{route('datos-medicos.create', $paciente->id)}}" class="btn btn-warning float-right">
                                                        Agregar
                                                    </a>
                                                </div>--}}
                                                <!-- Pestañas desplegables para anamnesis -->
                                                <div class="accordion" id="alergiaTabs">
                                                    <!-- Alimentos Preferidos -->
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="alergiaHeading">
                                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#alergiaCollapse" aria-expanded="true" aria-controls="alergiaCollapse">
                                                                Alergias
                                                            </button>
                                                        </h2>
                                                        <div id="alergiaCollapse" class="accordion-collapse collapse" aria-labelledby="alergiaHeading">
                                                            <div class="accordion-body">
                                                                <table class="table table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Alergia</th>
                                                                            <th>Grupo de Alergia</th>
                                                                            <th>Opciones</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($alergias as $alergia)
                                                                            @if ($alergia->alergia != 'Ninguna')
                                                                                <tr>
                                                                                    <td>{{ $alergia->alergia }}</td>
                                                                                    <td>{{ $alergia->grupo_alergia}}</td>
                                                                                    <td>
                                                                                        <div class="btn-group">
                                                                                            <a class="btn btn-info" href="{{ route('datos-medicos.edit', $alergia->id) }}">Editar</a>
                                                                                            <form action="{{ route('datos-medicos.destroy', $alergia->id) }}" method="POST">
                                                                                                @csrf
                                                                                                @method('DELETE')
                                                                                                <button class="btn btn-danger ml-2" type="submit">Eliminar</button>
                                                                                            </form>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            @else
                                                                                <tr>
                                                                                    <td colspan="3"> {{$alergia->alergia}} </td>
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Fin de pestañas desplegables -->
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-9 mb-3">
                                                    <h5>Cirugías</h5>
                                                </div>
                                                {{--
                                                <div class="col-3">
                                                    <a href="{{route('datos-medicos.create', $paciente->id)}}" class="btn btn-warning float-right">
                                                        Agregar
                                                    </a>
                                                </div>--}}
                                                <!-- Pestañas desplegables para anamnesis -->
                                                <div class="accordion" id="alergiaTabs">
                                                    <!-- Alimentos Preferidos -->
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="cirugiaHeading">
                                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#cirugiaCollapse" aria-expanded="true" aria-controls="cirugiaCollapse">
                                                                Cirugías
                                                            </button>
                                                        </h2>
                                                        <div id="cirugiaCollapse" class="accordion-collapse collapse" aria-labelledby="cirugiaHeading">
                                                            <div class="accordion-body">
                                                                <table class="table table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Cirugía</th>
                                                                            <th>Grupo de Cirugía</th>
                                                                            <th>Tiempo Cirugía</th>
                                                                            <th>Unidad de Tiempo</th>
                                                                            <th>Opciones</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @forelse ($cirugiasPaciente as $cirugiaPaciente)
                                                                            @if ($cirugiaPaciente->cirugia->cirugia != 'Ninguna')
                                                                                <tr>
                                                                                    <td>{{ $cirugiaPaciente->cirugia->cirugia }}</td>
                                                                                    <td>{{ $cirugiaPaciente->cirugia->grupo_cirugia }}</td>
                                                                                    <td>{{ $cirugiaPaciente->tiempo }}</td>
                                                                                    <td>
                                                                                        @if ($cirugiaPaciente->unidad_tiempo == 'anios')
                                                                                            @if ($cirugiaPaciente->tiempo == 1)
                                                                                                Año
                                                                                            @else
                                                                                                Años
                                                                                            @endif
                                                                                        @else
                                                                                            {{ $cirugiaPaciente->unidad_tiempo }}
                                                                                        @endif
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="btn-group">
                                                                                            <!--<a class="btn btn-info" href="{{ route('datos-medicos.edit', $cirugiaPaciente->id) }}">Editar</a>-->
                                                                                            <form action="{{ route('datos-medicos.destroy', $cirugiaPaciente->id) }}" method="POST">
                                                                                                @csrf
                                                                                                @method('DELETE')
                                                                                                <button class="btn btn-danger ml-2" type="submit">Eliminar</button>
                                                                                            </form>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            @else
                                                                                <tr>
                                                                                    <td colspan="5">{{$cirugiaPaciente->cirugia->cirugia}}</td>
                                                                                </tr>
                                                                            @endif
                                                                        @empty
                                                                            <tr>
                                                                                <td colspan="5">No se encontraron cirugías seleccionadas por el paciente.</td>
                                                                            </tr>
                                                                        @endforelse
                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Fin de pestañas desplegables -->
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-9 mb-3">
                                                    <h5>Patologías</h5>
                                                </div>
                                                {{--
                                                <div class="col-3">
                                                    <a href="{{route('datos-medicos.create', $paciente->id)}}" class="btn btn-warning float-right">
                                                        Agregar
                                                    </a>
                                                </div>
                                                --}}
                                                <!-- Pestañas desplegables para anamnesis -->
                                                <div class="accordion" id="patologiaTabs">
                                                    <!-- Alimentos Preferidos -->
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="patologiaHeading">
                                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#patologiaCollapse" aria-expanded="true" aria-controls="patologiaCollapse">
                                                                Patologías
                                                            </button>
                                                        </h2>
                                                        <div id="patologiaCollapse" class="accordion-collapse collapse" aria-labelledby="patologiaHeading">
                                                            <div class="accordion-body">
                                                                <table class="table table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Patología</th>
                                                                            <th>Grupo de Patología</th>
                                                                            <th>Opciones</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($patologias as $patologia)
                                                                            @if ($patologia->patologia != 'Ninguna')
                                                                                <tr>
                                                                                    <td>{{ $patologia->patologia }}</td>
                                                                                    <td>{{ $patologia->grupo_patologia}}</td>
                                                                                    <td>
                                                                                        <div class="btn-group">
                                                                                            <!--<a class="btn btn-info" href="{{ route('datos-medicos.edit', $patologia->id) }}">Editar</a>-->
                                                                                            <form action="{{ route('datos-medicos.destroy', $patologia->id) }}" method="POST">
                                                                                                @csrf
                                                                                                @method('DELETE')
                                                                                                <button class="btn btn-danger ml-2" type="submit">Eliminar</button>
                                                                                            </form>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            @else
                                                                                <tr>
                                                                                    <td colspan="3"> {{$patologia->patologia}} </td>
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Fin de pestañas desplegables -->
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-9 mb-3">
                                                    <h5>Intolerancias</h5>
                                                </div>
                                                {{--x
                                                <div class="col-3">
                                                    <a href="{{route('datos-medicos.create', $paciente->id)}}" class="btn btn-warning float-right">
                                                        Agregar
                                                    </a>
                                                </div>
                                                --}}
                                                <!-- Pestañas desplegables para anamnesis -->
                                                <div class="accordion" id="intoleranciaTabs">
                                                    <!-- Alimentos Preferidos -->
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="intoleranciaHeading">
                                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#intoleranciaCollapse" aria-expanded="true" aria-controls="patologiaCollapse">
                                                                Intolerancias
                                                            </button>
                                                        </h2>
                                                        <div id="intoleranciaCollapse" class="accordion-collapse collapse" aria-labelledby="intoleranciaHeading">
                                                            <div class="accordion-body">
                                                                <table class="table table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Intolerancia</th>
                                                                            <th>Opciones</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($intolerancias as $intolerancia)
                                                                            @if ($intolerancia->intolerancia != 'Ninguna')
                                                                                <tr>
                                                                                    <td>{{ $intolerancia->intolerancia }}</td>
                                                                                    <td>
                                                                                        <div class="btn-group">
                                                                                            <!--<a class="btn btn-info" href="{{ route('datos-medicos.edit', $intolerancia->id) }}">Editar</a>-->
                                                                                            <form action="{{ route('datos-medicos.destroy', $intolerancia->id) }}" method="POST">
                                                                                                @csrf
                                                                                                @method('DELETE')
                                                                                                <button class="btn btn-danger ml-2" type="submit">Eliminar</button>
                                                                                            </form>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            @else
                                                                                <tr>
                                                                                    <td colspan="3"> {{$intolerancia->intolerancia}} </td>
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Fin de pestañas desplegables -->
                                            </div>
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
                                            <table id="tabla-mis-turnos" class="table table-striped" id="turnos">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Fecha</th>
                                                        <th scope="col">Hora</th>
                                                        <th scope="col">Tipo de consulta</th>
                                                        <th scope="col">Estado</th>
                                                        <th scope="col">Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                @forelse($turnos as $turno)
                                                    @if ($turno->paciente_id == $paciente->id)
                                                        <tr>
                                                            <td>{{ $turno->fecha }}</td>
                                                            <td>{{ $turno->hora }}</td>
                                                            <td>
                                                                @foreach ($tipo_consultas as $tipoConsulta)
                                                                    @if ($tipoConsulta->id == $turno->tipo_consulta_id)
                                                                        {{ $tipoConsulta->tipo_consulta }}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>{{ $turno->estado }}</td>
                                                            <td>
                                                                <button class="btn btn-primary ver-detalles btn-sm" data-bs-toggle="modal" data-bs-target="#detalleTurno{{$turno->id}}">Ver detalles</button>
                                                                {{--
                                                                @if ($turno->estado == 'Pendiente')
                                                                    <a href="{{ route('turnos.edit', $turno->id) }}" class="btn btn-warning">Editar</a>
                                                                @endif--}}
                                                                @if ($turno->estado == 'Pendiente')
                                                                    <form action="{{ route('turnos.destroy', $turno->id) }}" method="POST" style="display: inline-block;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger">Cancelar</button>
                                                                    </form>
                                                                @endif
                                                            </td>
                                                        </tr>

                                                    @endif
                                                @empty

                                                @endforelse

                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Detalle de turno -->
                                        @forelse($turnos as $turno)
                                            @if ($turno->paciente_id == $paciente->id)
                                                <div class="modal fade" id="detalleTurno{{$turno->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detalleTurno{{$turno->id}}Label" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="detalleTurno{{$turno->id}}Label">Detalle de turno</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table class="table">
                                                                    <tbody>

                                                                        <tr>
                                                                            <th scope="col">Paciente</th>
                                                                            <td>{{ $paciente->user->name }} {{$paciente->user->apellido}}</td>
                                                                        </tr>

                                                                        <tr>
                                                                            <th scope="col">Objetivo de salud</th>
                                                                            <td>{{ $historiaClinica->objetivo_salud }}</td>
                                                                        </tr>

                                                                        <tr>
                                                                            <th scope="col">Estilo de vida</th>
                                                                            <td>{{ $historiaClinica->estilo_vida }}</td>
                                                                        </tr>

                                                                        <tr>
                                                                            <th scope="col">Profesional</th>
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

                                                                        <tr>
                                                                            @if ($turno->estado == 'Cancelado' || $turno->estado == 'Inasistencia')
                                                                                <th>Detalles de la consulta</th>
                                                                                <td>Sin consulta.</td>
                                                                            @else
                                                                                <th scope="col">Detalles de la consulta</th>
                                                                                <td><a href="{{route('turnos.show-detalles-consulta', $turno->id)}}">Ver detalles</a></td>
                                                                            @endif
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @empty

                                        @endforelse


                                        <!-- Planes -->
                                        <div id="planes" class="tab-pane">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    @endif


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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        // Inicializa las pestañas al cargar la página
        $(document).ready(function () {
            $('.nav-tabs a').click(function () {
                $(this).tab('show');
            });
        });

        //desplegar detalles de cada turno en la pestaña de Turnos
        $(document).ready(function() {
            $('.ver-detalles').click(function() {
                var filaTurno = $(this).closest('tr');
                var filaDetalles = filaTurno.next('.detalles-turno');

                if (filaDetalles.is(':visible')) {
                    filaDetalles.hide();
                } else {
                    filaDetalles.show();
                }
            });
        });

        //SweetAlert para botón eliminar
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-button');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    Swal.fire({
                        title: '¿Estás seguro de eliminar?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, eliminarlo'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            //Envia el form
                            const form = this.closest('form');
                            form.submit();
                        }
                    })
                });
            });
        });

        //Datatable días y horas libres
        $(document).ready(function(){
            $('#tabla-dias-horas').DataTable({
                responsive: true,
                autoWidth: false,
                "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ días y horas por página",
                    "zeroRecords": "No se encontró ningún día y hora.",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay días y horas existentes.",
                    "infoFiltered": "(filtrado de _MAX_ días y horas totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                },
                "order": [[ 0, "asc" ]],
            });
        });

        $(document).ready(function(){
            $('#tabla-mis-turnos').DataTable({
                responsive: true,
                autoWidth: false,
                "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ turnos por página",
                    "zeroRecords": "No se encontró ningún turno.",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay turnos existentes.",
                    "infoFiltered": "(filtrado de _MAX_ turnos totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                },
                "order": [[ 0, "asc" ]],
            });
        });

    </script>

@stop
