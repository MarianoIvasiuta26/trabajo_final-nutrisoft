@extends('adminlte::page')

@section('title', 'Mi Historia Clínica')

@section('content_header')
    <h1 style="text-align:center;">Completar Historia Clínica</h1>
@stop

@section('content')

    <div class="container mt-4">
        <div class="row">
            {{-- Obtener el paciente autenticado --}}
            @if ($paciente->dni != NULL && $paciente->telefono != NULL && $paciente->sexo != NULL && $paciente->fecha_nacimiento != NULL)
                <div class="col-md-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <button class="btn btn-link float-right" onclick="toggleCard('datosPersonalesRegistrados')">
                                <i class="fa fa-minus"></i>
                            </button>
                            <h5>Datos Personales</h5>
                        </div>
                        <div id="datosPersonalesRegistrados" class="card-body">
                            <div class="col-md-12">
                                <div class="alert alert-success" role="alert">
                                    <h4 class="alert-heading">¡Bienvenido/a {{$paciente->user->name}}!</h4>
                                    <p>Ya completaste tus datos personales, ahora puedes completar el resto de tu historia clínica.</p>
                                    <hr>
                                    <p class="mb-0">Recuerda que puedes completar tu historia clínica en cualquier momento, pero que será necesario que lo completes para acceder a todas las funcionalidades del sistema.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!--Form datos personales-->
                <div class="col-md-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <button class="btn btn-link float-right" onclick="toggleCard('datosPersonales')">
                                <i class="fa fa-minus"></i>
                            </button>
                            <h5>Datos Personales</h5>
                        </div>
                        <div id="datosPersonales" class="card-body">
                            <form class="row g-3" action="{{route('datos-personales.store')}}" method="POST">
                            @csrf

                                <div class="col-md-6">
                                    <label for="dni" class="form-label">DNI(*)</label>
                                    <input type="text" class="form-control @error('dni') is-invalid @enderror" id="dni" name="dni" value="{{old('dni')}}{{ session('dni') }}">

                                    @error('dni')
                                        <div class="invalid-feedback">{{ $message}}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="telefono" class="form-label">Teléfono(*)</label>
                                    <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{old('telefono')}}{{ session('telefono') }}">

                                    @error('telefono')
                                        <div class="invalid-feedback">{{ $message}}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="sexo" class="form-label">Sexo biológico(*)</label>
                                    <select id="sexo" class="form-select @error('sexo') is-invalid @enderror" name="sexo">
                                        <option value="" disabled selected>Elija una opción...</option>
                                        <option value="Masculino" @if (old('sexo') == 'Masculino' || session('sexo') == 'Masculino') selected @endif>
                                            Masculino
                                        </option>
                                        <option value="Femenino" @if (old('sexo') == 'Femenino' || session('sexo') == 'Femenino') selected @endif>
                                            Femenino
                                        </option>
                                    </select>

                                    @error('sexo')
                                        <div class="invalid-feedback">{{ $message}}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento(*)</label>
                                    <input type="date" value="{{old('fecha_nacimiento')}}{{ session('fecha_nacimiento') }}" class="form-control @error('fecha_nacimiento') is-invalid @enderror" id="fecha_nacimiento" name="fecha_nacimiento">

                                    @error('fecha_nacimiento')
                                        <div class="invalid-feedback">{{ $message}}</div>
                                    @enderror
                                </div>
                                <div class="alert alert-warning mt-3" role="alert">
                                    Los campos marcados con un (*) son obligatorios.
                                </div>
                                <div class="col-12">
                                    <div class="float-right">
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                        <a href="{{ route('gestion-usuarios.index') }}" class="btn btn-danger" tabindex="7">Cancelar</a>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            @endif

            @php
                if (!$paciente->historiaClinica) {
                    // Si no hay Historia Clínica, inicializa las variables vacías o como desees.
                    $datosMedicos = [];
                    $anamnesis = [];
                    $cirugiasPaciente = [];
                    $adelantamientoTurnos = [];
                }

            @endphp

            @if (count($adelantamientoTurnos) > 0)
                <div class="col-md-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <button class="btn btn-link float-right" onclick="toggleCard('diasYHorasRegistradas')">
                                <i class="fa fa-plus"></i>
                            </button>
                            <h5>Días y Horas Fijos disponibles</h5>
                        </div>
                        <div id="diasYHorasRegistradas" class="card-body" style="display: none;">
                            <div class="col-md-12">
                                <div class="alert alert-success" role="alert">
                                    <h5 class="alert-heading">Días y horas registradas</h5>
                                    <p>Ya registraste los días y horas disponibles para adelantamientos de turno.</p>
                                    <p>Puedes registrar más días y horas en tu historia clínica una vez completado todo el fomrulario.</p>
                                    <hr>
                                    <p class="mb-0">Recuerda que puedes completar tu historia clínica en cualquier momento, pero que será necesario que lo completes para acceder a todas las funcionalidades del sistema.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!--Form días y horas disponibles para adelantamiento de turnos -->
                <div class="col-md-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <button class="btn btn-link float-right" onclick="toggleCard('diasYHoras')">
                                <i class="fa fa-plus"></i>
                            </button>
                            <h5>Días y Horas Fijos disponibles</h5>
                        </div>
                        <div id="diasYHoras" class="card-body" style="display: none;">
                            <form action="{{route('adelantamiento-turno.store')}}" method="POST">
                                @csrf
                                <div class="alert alert-warning mt-3" role="alert">
                                    <h5 class="alert-heading">¡Atención!</h5>
                                    <p>Este formulario no es obligatorio completarlo.</p>
                                    <hr>
                                    <p>En caso de no poseer ningún día y hora libre, puede prescindir de completar este formulario.</p>
                                </div>
                            {{--
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <h5>Seleccione los días que tiene disponibles:</h5>
                                                                @foreach ($horarios as $horario)
                                                                    @foreach ($dias as $dia)
                                                                        @if ($dia->id == $horario->dia_atencion_id && $dia->seleccionado == true)
                                                                            <div class="col-md-2">
                                                                                <div class="icheck-primary">
                                                                                    <input value="{{$dia->dia}}" type="checkbox" id="diasFijos-{{$dia->dia}}" name="diasFijos[]"/>
                                                                                    <label for="diasFijos-{{$dia->dia}}">{{$dia->dia}}</label>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                @endforeach
                                                            </div>
                                                            <!-- Horas -->
                                                            <div class="col-md-6">
                                                                <h5>Seleccione las horas disponibles:</h5>
                                                                <div class="row">
                                                                    <select name="horasFijas[]" class="selectpicker" multiple title="Seleccione las horas de la mañana disponibles..." data-style="btn-success" data-width="fit" data-live-search="true" data-size="5">
                                                                        <option value="8:00">8:00</option>
                                                                        <option value="8:30">8:30</option>
                                                                        <option value="9:00">9:00</option>
                                                                        <option value="9:30">9:30</option>
                                                                        <option value="10:00">10:00</option>
                                                                        <option value="10:30">10:30</option>
                                                                        <option value="11:00">11:00</option>
                                                                        <option value="11:30">11:30</option>
                                                                        <option value="12:00">12:00</option>
                                                                    </select>
                                                                </div>

                                                                <div class="row">
                                                                    <select name="horasFijas[]" class="selectpicker mt-4" data-style="btn-success" multiple title="Seleccione las horas de la tarde disponibles..." data-width="fit" data-size="5" data-live-search="true">
                                                                        <option value="16:30">16:30</option>
                                                                        <option value="17:00">17:00</option>
                                                                        <option value="17:30">17:30</option>
                                                                        <option value="18:00">18:00</option>
                                                                        <option value="18:30">18:30</option>
                                                                        <option value="19:00">19:00</option>
                                                                        <option value="19:30">19:30</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mt-3">
                                                            <div class="col-12">
                                                                <div class="float-right">
                                                                    <button type="submit" class="btn btn-success">Guardar</button>
                                                                    <a href="{{ route('gestion-usuarios.index') }}" class="btn btn-danger" tabindex="7">Cancelar</a>
                                                                </div>
                                                            </div>
                                                        </div>
                            --}}
                                <div class="row">
                                    <div class="col">
                                        <label class="form-label " for="profesional">Seleccione el profesional del que recibe atenciones</label>
                                        <select name="profesional" id="profesional" class="form-select">
                                            <option value="">Seleccione un profesional</option>
                                            @foreach($profesionales as $profesional)
                                                <option value="{{$profesional->id}}">{{$profesional->user->name}} {{$profesional->user->apellido}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-12" id="dias-consultas">

                                    </div>

                                    <!-- Horas -->
                                    <div class="col-md-12" id="horas-disponibles">

                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="float-right">
                                            <button type="submit" class="btn btn-success">Guardar</button>
                                            <a href="{{ route('gestion-usuarios.index') }}" class="btn btn-danger" tabindex="7">Cancelar</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            @if (count($datosMedicos) > 0 && count($anamnesis) > 0 && count($cirugiasPaciente) > 0)
                <div class="col-md-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <button class="btn btn-link float-right" onclick="toggleCard('datosMedicos')">
                                <i class="fa fa-plus"></i>
                            </button>
                            <h5>Datos Médicos</h5>
                        </div>
                        <div id="datosMedicos" class="card-body" style="display: none;">
                            <div class="col-md-12">
                                <div class="alert alert-success" role="alert">
                                    <h5 class="alert-heading">Datos médicos registrados</h5>
                                    <p>Ya registraste tus datos médicos.</p>
                                    <p>Puedes modificarlos en tu historia clínica una vez completado todo el formulario.</p>
                                    <hr>
                                    <p class="mb-0">Recuerda que puedes completar tu historia clínica en cualquier momento, pero que será necesario que lo completes para acceder a todas las funcionalidades del sistema.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!--Form datos médicos-->
                <div class="col-md-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <button class="btn btn-link float-right" onclick="toggleCard('datosMedicos')">
                                <i class="fa fa-plus"></i>
                            </button>
                            <h5>Datos Médicos</h5>
                        </div>
                        <div id="datosMedicos" class="card-body" style="display: none;">
                            <form action="{{route('datos-medicos.store')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <h5>Anamnesis Alimentaria</h5>
                                    <div class="col-md-6">
                                        <label for="gustos" class="form-label">Seleccione sus alimentos preferidos</label>
                                        <select name="alimentos_gustos[]" class="form-select" id="gustos" data-placeholder="Alimentos preferidos..." multiple>
                                            <option value="">Ninguna</option>
                                            @foreach ($alimentos->groupBy('grupo_alimento') as $grupo_alimento => $alimentos_del_grupo)
                                                <optgroup label="{{$grupo_alimento}}">
                                                    @foreach ($alimentos_del_grupo as $alimento)
                                                        <option value="{{$alimento->id}}">{{$alimento->alimento}}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="no_gustos" class="form-label">Seleccione los alimentos que no le guste</label>
                                        <select name="alimentos_no_gustos[]" class="form-select" id="no_gustos" data-placeholder="Alimentos que no guste..." multiple>
                                            <option value="">Ninguna</option>
                                            @foreach ($alimentos->groupBy('grupo') as $grupo_alimento => $alimentos_del_grupo)
                                                <optgroup label="{{$grupo_alimento}}">
                                                    @foreach ($alimentos_del_grupo as $alimento)
                                                        <option value="{{$alimento->id}}">{{$alimento->alimento}}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <h5>Alergias</h5>
                                    <div class="col-md-12">
                                        <label for="alergias" class="form-label">Seleccione las alergias que posee</label>
                                        <select name="alergias[]" class="form-select" id="alergias" data-placeholder="Alergias..." multiple>
                                            <option value="">Ninguna</option>
                                            @foreach ($alergias->groupBy('grupo_alergia') as $grupo_alergia => $alergias_del_grupo)
                                                <optgroup label="{{$grupo_alergia}}">
                                                    @foreach ($alergias_del_grupo as $alergia)
                                                        <option value="{{$alergia->id}}">{{$alergia->alergia}}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mt-3" id="cirugias-container">
                                    <h5>Cirugías</h5>
                                    <div class="cirugia-entry">
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <select name="cirugias[]" class="form-select">
                                                    <option value="">Seleccione una cirugía</option>
                                                    @foreach ($cirugias->groupBy('grupo_cirugia') as $grupo_cirugia => $cirugias_del_grupo)
                                                        <optgroup label="{{$grupo_cirugia}}">
                                                            @foreach ($cirugias_del_grupo as $cirugia)
                                                                <option value="{{$cirugia->id}}">{{$cirugia->cirugia}}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="number" name="tiempos[]" class="form-control tiempo-input" placeholder="Tiempo">
                                                    <select name="unidades_tiempo[]" class="form-select unidad-select">
                                                        <option value="dias">Días</option>
                                                        <option value="semanas">Semanas</option>
                                                        <option value="meses">Meses</option>
                                                        <option value="anios">Años</option>
                                                    </select>
                                                    <button type="button" id="agregar-cirugia"  class="btn btn-primary btn-sm add-cirugia">+</button>
                                                    <button type="button" class="btn btn-danger btn-sm remove-cirugia">x</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <h5>Patologías</h5>
                                    <div class="col-md-12">
                                        <label for="patologias" class="form-label">Seleccione las patologías que posee</label>
                                        <select name="patologias[]" class="form-select" id="patologias" data-placeholder="Patologías..." multiple>
                                            <option value="">Ninguna</option>
                                            @foreach ($patologias->groupBy('grupo_patologia') as $grupo_patologia => $patologias_del_grupo)
                                                <optgroup label="{{$grupo_patologia}}">
                                                    @foreach ($patologias_del_grupo as $patologia)
                                                        <option value="{{$patologia->id}}">{{$patologia->patologia}}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <h5>Intolerancias</h5>
                                    <div class="col-md-12">
                                        <label for="intolerancias" class="form-label">Seleccione las intolerancias que posee</label>
                                        <select name="intolerancias[]" class="form-select" id="intolerancias" data-placeholder="Intolerancias..." multiple>
                                            <option value="">Ninguna</option>
                                            @foreach ($intolerancias as $intolerancia)
                                                <option value="{{$intolerancia->id}}">{{$intolerancia->intolerancia}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="float-right">
                                            <button type="submit" class="btn btn-success">Guardar</button>
                                            <a href="{{ route('dashboard') }}" class="btn btn-danger" tabindex="7">Cancelar</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            <!--Form datos físicos-->
            <div class="col-md-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <button class="btn btn-link float-right" onclick="toggleCard('datosFisicos')">
                            <i class="fa fa-plus"></i>
                        </button>
                        <h5>Datos Físicos</h5>
                    </div>
                    <div id="datosFisicos" class="card-body" style="display: none;">
                        <form action="{{route('historia-clinica.store')}}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="peso" class="form-label">Peso</label>
                                    <input type="number" class="form-control" id="peso">
                                </div>
                                <div class="col-md-6">
                                    <label for="altura" class="form-label">Altura</label>
                                    <input type="number" class="form-control" id="altura">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label for="circ_munieca" class="form-label">Circunferencia de Muñeca</label>
                                    <input type="number" class="form-control" id="circ_munieca">
                                </div>

                                <div class="col-md-3">
                                    <label for="circ_cintura" class="form-label">Circunferencia de Cintura</label>
                                    <input type="number" class="form-control" id="circ_cintura">
                                </div>

                                <div class="col-md-3">
                                    <label for="circ_cadera" class="form-label">Circunferencia de Cadera</label>
                                    <input type="number" class="form-control" id="circ_cadera">
                                </div>

                                <div class="col-md-3">
                                    <label for="circ_pecho" class="form-label">Circunferencia de Pecho</label>
                                    <input type="number" class="form-control" id="circ_pecho">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="estilo_vida" class="form-label">Estilo de vida actual(*)</label>
                                    <select id="estilo_vida" class="form-select @error('estilo_vida') is-invalid @enderror" name="estilo_vida">
                                        <option value="">Elija una opción...</option>
                                        <option value="Sedentario" {{ old('estilo_vida') == 'Sedentario' ? 'selected' : '' }}>Sedentario</option>
                                        <option value="Ligeramente activo" {{ old('estilo_vida') == 'Ligeramente activo' ? 'selected' : '' }}>Ligeramente activo</option>
                                        <option value="Moderadamente activo" {{ old('estilo_vida') == 'Moderadamente activo' ? 'selected' : '' }}>Moderadamente activo</option>
                                        <option value="Muy activo" {{ old('estilo_vida') == 'Muy activo' ? 'selected' : '' }}>Muy activo</option>
                                        <option value="Extra activo" {{ old('estilo_vida') == 'Extra activo' ? 'selected' : '' }}>Extra activo</option>
                                    </select>

                                    @error('estilo_vida')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="objetivo_salud" class="form-label">Objetivo de salud(*)</label>
                                    <select name="objetivo_salud" id="objetivo_salud" class="form-select @error('objetivo_salud') is-invalid @enderror">
                                        <option value="" disabled>Elija una opción...</option>
                                        <option value="Adelgazar" {{ old('objetivo_salud') == 'Adelgazar' ? 'selected' : '' }}>Adelgazar</option>
                                        <option value="Ganar masa muscular" {{ old('objetivo_salud') == 'Ganar masa muscular' ? 'selected' : '' }}>Ganar masa muscular</option>
                                        <option value="Nutrición deportiva" {{ old('objetivo_salud') == 'Nutrición deportiva' ? 'selected' : '' }}>Nutrición deportiva</option>
                                        <option value="Nutrición por enfermedad" {{ old('objetivo_salud') == 'Nutrición por enfermedad' ? 'selected' : '' }}>Nutrición por enfermedad</option>
                                    </select>

                                    @error('objetivo_salud')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="alert alert-warning mt-3" role="alert">
                                Los campos marcados con un (*) son obligatorios.
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="float-right">
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                        <a href="{{ route('gestion-usuarios.index') }}" class="btn btn-danger" tabindex="7">Cancelar</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>



@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/css/bootstrap-select.min.css" rel="stylesheet">

    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <style>
        .card-body {
            display: none;
        }

    </style>



@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        function toggleCard(cardId) {
            const card = document.getElementById(cardId);
            const icon = card.previousElementSibling.querySelector("i.fa");

            if (card.style.display === "none" || card.style.display === "") {
                card.style.display = "block";
                icon.classList.remove("fa-plus");
                icon.classList.add("fa-minus");
            } else {
                const form = card.querySelector("form");
                if (form.checkValidity()) {
                   // form.submit();
                    card.style.display = "none";
                    icon.classList.remove("fa-minus");
                    icon.classList.add("fa-plus");
                }else{
                    card.style.display = "none";
                    icon.classList.remove("fa-minus");
                    icon.classList.add("fa-plus");
                    form.reportValidity();
                }
            }
        }

        // Abrir el primer card al cargar la página
        document.addEventListener("DOMContentLoaded", function () {
            const primerCard = document.getElementById("datosPersonales");
            const iconPrimerCard = primerCard.previousElementSibling.querySelector("i.fa");

            @if ($formularioCompletado)
                primerCard.style.display = "none";
                iconPrimerCard.classList.remove("fa-minus");
                iconPrimerCard.classList.add("fa-plus");
            @else
                primerCard.style.display = "block";
                iconPrimerCard.classList.remove("fa-plus");
                iconPrimerCard.classList.add("fa-minus");
            @endif
        });

        //SELECT2
        $( '#gustos' ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            closeOnSelect: false,
        } );

        $( '#no_gustos' ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            closeOnSelect: false,
        } );

        $( '#alergias' ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            closeOnSelect: false,
        } );

        $( '#cirugias' ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            closeOnSelect: false,
        } );

        $( '#patologias' ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            closeOnSelect: false,
        } );

        $( '#intolerancias' ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            closeOnSelect: false,
        } );

        //Función para agregar y eliminar cirugías
        $(document).ready(function() {
            // Manejar clic en el botón "Agregar Cirugía"
            $('#agregar-cirugia').click(function() {
                var nuevaCirugia = $('.cirugia-entry:first').clone();
                nuevaCirugia.find('select').val('');
                nuevaCirugia.find('input').val('');
                nuevaCirugia.appendTo('#cirugias-container');
            });

            // Manejar clic en el botón "x" para eliminar una entrada de cirugía
            $('#cirugias-container').on('click', '.remove-cirugia', function() {
                $(this).closest('.cirugia-entry').remove();
            });
        });

        //Función para saber que card minimizar al completar registro
        document.addEventListener("DOMContentLoaded", function(){
            if(sessionStorage.getItem('datos_personales')){
                toggleCard('datosPersonales');
            }

            if(sessionStorage.getItem('datos_fisicos')){
                toggleCard('datosFisicos');
            }

            if(sessionStorage.getItem('datos_medicos')){
                toggleCard('datosMedicos');
            }

            if(sessionStorage.getItem('dias_y_horas_fijas')){
                toggleCard('diasYHoras');
            }

            //Marcar los campos completados con verde y un icono de verificación
            const camposCompletados = document.querySelectorAll('.campo-completado');
            camposCompletados.forEach(function (campo){
                campo.classList.add('text-success');
                campo.innerHTML = '<i class="fas fa-check"></i>';
            });

        });

        //Funciones para obtener días y horas fijos
        $(document).ready(function() {
            $('#profesional').on('change', function () {
                var profesionalSeleccionado = this.value;

                if (profesionalSeleccionado) {
                    cargarDiasDisponibles(profesionalSeleccionado);
                } else {
                    // Si no se selecciona un profesional, vacía el contenedor de días y horas
                    $('#dias-consultas').empty();
                    $('#horas-disponibles').empty();
                }
                // Función para cargar los días disponibles
            function cargarDiasDisponibles(profesionalSeleccionado) {
                // Realiza una solicitud Ajax para obtener los días disponibles
                $.ajax({
                    url: "{{ route('adelantamiento-turno.obtener-dias') }}",
                    type: "POST",
                    data: {
                        profesional: profesionalSeleccionado,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (diasDisponibles) {
                        var diasContainer = $('#dias-consultas');
                        diasContainer.empty();
                        var indicacion = '<h5>Seleccione los días que tiene disponibles:</h5>'
                        diasContainer.append(indicacion);
                        $.each(diasDisponibles.diasFijos, function (index, dia) {
                            // Agrega los checkboxes de días disponibles al contenedor

                            var checkbox = '<div class="col-md-2">' +
                                '<div class="icheck-primary">' +
                                '<input value="' + dia + '" type="checkbox" id="diasFijos-' + dia + '" name="diasFijos[]"/>' +
                                '<label for="diasFijos-' + dia + '">' + dia + '</label>' +
                                '</div>' +
                                '</div>';
                            diasContainer.append(checkbox);
                        });
                        console.log(diasDisponibles);
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }

            // Agrega un evento de cambio a los checkboxes de días
            $(document).on('change', 'input[name="diasFijos[]"]', function() {
                if (this.checked) {
                    var diaSeleccionado = $(this).val();
                    console.log('Día seleccionado: ' + diaSeleccionado);
                    cargarHorasDisponibles(profesionalSeleccionado, diaSeleccionado);
                } else {
                    console.log('Se ha desmarcado el día.');
                    // Si se desmarca el día, borra las horas correspondientes
                    $('#horas-disponibles').empty();
                }
            });

            // Función para cargar las horas disponibles
            function cargarHorasDisponibles(profesionalSeleccionado, diaSeleccionado) {
                console.log('La función cargarHorasDisponibles se ha activado.');
                // Realiza una solicitud Ajax para obtener las horas disponibles
                $.ajax({
                    url: "{{ route('adelantamiento-turno.obtener-horas') }}",
                    type: "POST",
                    data: {
                        profesional: profesionalSeleccionado,
                        dia: diaSeleccionado,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (horasDisponibles) {
                        var horasContainer = $('#horas-disponibles');
                        var indicacion = '<h5>Seleccione las horas disponibles:</h5>'
                        horasContainer.append(indicacion);

                        $.each(horasDisponibles.horas, function (index, hora) {
                            // Agrega los checkboxes de horas disponibles al contenedor
                            var checkbox = '<div class="col-md-2">' +
                                '<div class="icheck-primary">' +
                                '<input value="' + hora + '" type="checkbox" id="horasFijas-' + hora + '" name="horasFijas[]"/>' +
                                '<label for="horasFijas-' + hora + '">' + hora + '</label>' +
                                '</div>' +
                                '</div>';
                            horasContainer.append(checkbox);
                        });
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
        const formulario = document.querySelector('form'); // Obtén el formulario

        formulario.addEventListener('submit', function(event) {
        event.preventDefault(); // Evita la presentación del formulario por defecto

        // Valida los campos y aplica las clases apropiadas
        const dniInput = document.getElementById('dni');
        const telefonoInput = document.getElementById('telefono');
        const sexoSelect = document.getElementById('sexo');
        const fechaNacimientoInput = document.getElementById('fecha_nacimiento');

        // Función para agregar la clase is-valid o is-invalid según la validación
        function validarCampo(input, condicion) {
            if (condicion) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            } else {
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
            }
        }

        // Valida el campo DNI
        validarCampo(dniInput, dniInput.value.trim() !== '');

        // Valida el campo Teléfono
        validarCampo(telefonoInput, telefonoInput.value.trim() !== '');

        // Valida el campo Sexo
        validarCampo(sexoSelect, sexoSelect.value !== '');

        // Valida el campo Fecha de Nacimiento (puedes personalizar la validación según tus necesidades)
        validarCampo(fechaNacimientoInput, fechaNacimientoInput.value.trim() !== '');

        // Si todos los campos son válidos, puedes enviar el formulario
        if (dniInput.classList.contains('is-valid') &&
            telefonoInput.classList.contains('is-valid') &&
            sexoSelect.classList.contains('is-valid') &&
            fechaNacimientoInput.classList.contains('is-valid')) {
            formulario.submit(); // Envía el formulario
        }
        });
    });

    </script>

@stop
