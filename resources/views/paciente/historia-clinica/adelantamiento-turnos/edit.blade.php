@extends('adminlte::page')

@section('title', 'Mi Historia Clínica')

@section('content_header')

@stop

@section('content')
    <div class="col-md-12">
        <div class="card card-dark">
            <div class="card-header">
                <h5>Días y Horas Fijos disponibles</h5>
            </div>
            <div id="diasYHoras" class="card-body">
                <form action="{{route('adelantamiento-turno.update', $paciente->id)}}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <h5>Seleccione los días que tiene disponibles:</h5>
                            @foreach ($horarios as $horario)
                                @foreach ($dias as $dia)
                                    @if ($dia->id == $horario->dia_atencion_id)
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
                                    @foreach ($adelantamientos as $adelantamiento)
                                        @php
                                            $horaSeleccionada = '08:00'; // La hora que deseas buscar
                                            $horasFijas = $adelantamiento->horas_fijas; // Obtén la cadena de tiempo desde la base de datos

                                            // Verifica si la hora seleccionada está presente en la cadena de tiempo
                                            $selected = strpos($horasFijas, $horaSeleccionada) !== false ? 'selected' : '';
                                        @endphp
                                        <option value="8:00" {{ $selected }}>8:00</option>
                                        @php
                                            $horaSeleccionada = '08:30'; // La hora que deseas buscar
                                            $horasFijas = $adelantamiento->horas_fijas; // Obtén la cadena de tiempo desde la base de datos

                                            // Verifica si la hora seleccionada está presente en la cadena de tiempo
                                            $selected = strpos($horasFijas, $horaSeleccionada) !== false ? 'selected' : '';
                                        @endphp
                                        <option value="8:30" {{ $selected }}>8:30</option>
                                        @php
                                            $horaSeleccionada = '09:00'; // La hora que deseas buscar
                                            $horasFijas = $adelantamiento->horas_fijas; // Obtén la cadena de tiempo desde la base de datos

                                            // Verifica si la hora seleccionada está presente en la cadena de tiempo
                                            $selected = strpos($horasFijas, $horaSeleccionada) !== false ? 'selected' : '';
                                        @endphp
                                        <option value="9:00" {{ $selected }}>9:00</option>
                                        @php
                                            $horaSeleccionada = '09:30'; // La hora que deseas buscar
                                            $horasFijas = $adelantamiento->horas_fijas; // Obtén la cadena de tiempo desde la base de datos

                                            // Verifica si la hora seleccionada está presente en la cadena de tiempo
                                            $selected = strpos($horasFijas, $horaSeleccionada) !== false ? 'selected' : '';
                                        @endphp
                                        <option value="9:30" {{ $selected }}>9:30</option>
                                        @php
                                            $horaSeleccionada = '10:00'; // La hora que deseas buscar
                                            $horasFijas = $adelantamiento->horas_fijas; // Obtén la cadena de tiempo desde la base de datos

                                            // Verifica si la hora seleccionada está presente en la cadena de tiempo
                                            $selected = strpos($horasFijas, $horaSeleccionada) !== false ? 'selected' : '';
                                        @endphp
                                        <option value="10:00" {{ $selected }}>10:00</option>
                                        @php
                                            $horaSeleccionada = '10:30'; // La hora que deseas buscar
                                            $horasFijas = $adelantamiento->horas_fijas; // Obtén la cadena de tiempo desde la base de datos

                                            // Verifica si la hora seleccionada está presente en la cadena de tiempo
                                            $selected = strpos($horasFijas, $horaSeleccionada) !== false ? 'selected' : '';
                                        @endphp
                                        <option value="10:30" {{ $selected }}>10:30</option>
                                        @php
                                            $horaSeleccionada = '11:00'; // La hora que deseas buscar
                                            $horasFijas = $adelantamiento->horas_fijas; // Obtén la cadena de tiempo desde la base de datos

                                            // Verifica si la hora seleccionada está presente en la cadena de tiempo
                                            $selected = strpos($horasFijas, $horaSeleccionada) !== false ? 'selected' : '';
                                        @endphp
                                        <option value="11:00" {{ $selected }}>11:00</option>
                                        @php
                                            $horaSeleccionada = '11:30'; // La hora que deseas buscar
                                            $horasFijas = $adelantamiento->horas_fijas; // Obtén la cadena de tiempo desde la base de datos

                                            // Verifica si la hora seleccionada está presente en la cadena de tiempo
                                            $selected = strpos($horasFijas, $horaSeleccionada) !== false ? 'selected' : '';
                                        @endphp
                                        <option value="11:30" {{ $selected }}>11:30</option>
                                        @php
                                            $horaSeleccionada = '12:00'; // La hora que deseas buscar
                                            $horasFijas = $adelantamiento->horas_fijas; // Obtén la cadena de tiempo desde la base de datos

                                            // Verifica si la hora seleccionada está presente en la cadena de tiempo
                                            $selected = strpos($horasFijas, $horaSeleccionada) !== false ? 'selected' : '';
                                        @endphp
                                        <option value="12:00" {{ $selected }}>12:00</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row">
                                <select name="horasFijas[]" class="selectpicker mt-4" data-style="btn-success" multiple title="Seleccione las horas de la tarde disponibles..." data-width="fit" data-size="5" data-live-search="true">
                                    @foreach ($adelantamientos as $adelantamiento)
                                        @php
                                            $horaSeleccionada = '16:30'; // La hora que deseas buscar
                                            $horasFijas = $adelantamiento->horas_fijas; // Obtén la cadena de tiempo desde la base de datos

                                            // Verifica si la hora seleccionada está presente en la cadena de tiempo
                                            $selected = strpos($horasFijas, $horaSeleccionada) !== false ? 'selected' : '';
                                        @endphp
                                        <option value="16:30" {{ $selected }}>16:30</option>
                                        @php
                                            $horaSeleccionada = '17:00'; // La hora que deseas buscar
                                            $horasFijas = $adelantamiento->horas_fijas; // Obtén la cadena de tiempo desde la base de datos

                                            // Verifica si la hora seleccionada está presente en la cadena de tiempo
                                            $selected = strpos($horasFijas, $horaSeleccionada) !== false ? 'selected' : '';
                                        @endphp
                                        <option value="17:00" {{ $selected }}>17:00</option>
                                        @php
                                            $horaSeleccionada = '17:30'; // La hora que deseas buscar
                                            $horasFijas = $adelantamiento->horas_fijas; // Obtén la cadena de tiempo desde la base de datos

                                            // Verifica si la hora seleccionada está presente en la cadena de tiempo
                                            $selected = strpos($horasFijas, $horaSeleccionada) !== false ? 'selected' : '';
                                        @endphp
                                        <option value="17:30" {{ $selected }}>17:30</option>
                                        @php
                                            $horaSeleccionada = '18:00'; // La hora que deseas buscar
                                            $horasFijas = $adelantamiento->horas_fijas; // Obtén la cadena de tiempo desde la base de datos

                                            // Verifica si la hora seleccionada está presente en la cadena de tiempo
                                            $selected = strpos($horasFijas, $horaSeleccionada) !== false ? 'selected' : '';
                                        @endphp
                                        <option value="18:00" {{ $selected }}>18:00</option>
                                        @php
                                            $horaSeleccionada = '18:30'; // La hora que deseas buscar
                                            $horasFijas = $adelantamiento->horas_fijas; // Obtén la cadena de tiempo desde la base de datos

                                            // Verifica si la hora seleccionada está presente en la cadena de tiempo
                                            $selected = strpos($horasFijas, $horaSeleccionada) !== false ? 'selected' : '';
                                        @endphp
                                        <option value="18:30" {{ $selected }}>18:30</option>
                                        @php
                                            $horaSeleccionada = '19:00'; // La hora que deseas buscar
                                            $horasFijas = $adelantamiento->horas_fijas; // Obtén la cadena de tiempo desde la base de datos

                                            // Verifica si la hora seleccionada está presente en la cadena de tiempo
                                            $selected = strpos($horasFijas, $horaSeleccionada) !== false ? 'selected' : '';
                                        @endphp
                                        <option value="19:00" {{ $selected }}>19:00</option>
                                        @php
                                            $horaSeleccionada = '19:30'; // La hora que deseas buscar
                                            $horasFijas = $adelantamiento->horas_fijas; // Obtén la cadena de tiempo desde la base de datos

                                            // Verifica si la hora seleccionada está presente en la cadena de tiempo
                                            $selected = strpos($horasFijas, $horaSeleccionada) !== false ? 'selected' : '';
                                        @endphp
                                        <option value="19:30" {{ $selected }}>19:30</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="float-right">
                                <button type="submit" class="btn btn-success">Guardar</button>
                                <a href="{{ route('historia-clinica.index') }}" class="btn btn-danger" tabindex="7">Cancelar</a>
                            </div>
                        </div>
                    </div>

                </form>
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


    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
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

@stop
