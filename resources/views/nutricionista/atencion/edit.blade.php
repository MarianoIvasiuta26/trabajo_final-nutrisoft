@extends('adminlte::page')

@section('title', 'Editar horario de atención')

@section('content_header')
@stop

@section('content')
    <form action="{{ route('gestion-atencion.update', $horario->id) }}" method="POST">
        @csrf

        <input type="hidden" name="id" value="{{ $horario->id }}">

        <!-- Días y horarios generales -->
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h5>Editar horario de atención - {{$dia->dia}}</h5>
                        </div>

                        <div class="card-body">

                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{session('success')}}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{session('error')}}
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Día de consulta:</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="dias_atencion[]" value="{{$dia->dia}}" id="lunes" checked disabled>
                                                <label class="form-check-label" for="lunes">{{$dia->dia}}</label>
                                            </div>
                                    </div>
                                </div>

                                <div class="col-md-9">
                                    <label class="form-label">Seleccione las horas que realiza consultas:</label>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <label for="hora_inicio" class="form-label">Hora de Apertura</label>
                                            <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" value="{{$hora->hora_inicio}}">
                                            @error('hora_inicio')
                                                <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>

                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="hora_fin" class="form-label">Hora de Cierre</label>
                                                <input type="time" name="hora_fin" id="hora_fin" class="form-control" value="{{$hora->hora_fin}}">
                                                @error('hora_fin')
                                                    <small class="text-danger">{{$message}}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="etiqueta">Seleccione la etiqueta del horario</label><br>
                                            <select name="etiqueta" class="selectpicker" data-style="btn-primary" title="Etiqueta del Horario...">
                                                <option value="Maniana"
                                                    @if ($hora->etiqueta == 'Maniana')
                                                        selected
                                                    @else
                                                        disabled
                                                    @endif
                                                >Consultas de Mañana</option>
                                                <option value="Tarde"
                                                    @if ($hora->etiqueta == 'Tarde')
                                                        selected
                                                    @else
                                                        disabled
                                                    @endif
                                                >Consultas de Tarde</option>
                                            </select>
                                            @error('etiqueta')
                                                <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="float-right">
                                    <a href="{{ route('gestion-atencion.index') }}" class="btn btn-danger" tabindex="7">Cancelar</a>
                                    <button type="submit" class="btn btn-success">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{{--
        <!-- Días y horarios de fechas específicas -->
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h5>Días y horarios de Atención - Fechas Específicas</h5>
                        </div>

                        <div class="card-body">
                            <input type="text" name="datetimes" />
                        </div>
                    </div>
            </div>
        </div>
    --}}
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $(function() {
            $('input[name="datetimes"]').daterangepicker({
                timePicker: true,
                startDate: moment().startOf('hour'),
                endDate: moment().startOf('hour').add(32, 'hour'),
                locale: {
                format: 'M/DD hh:mm A'
                }
            });
        });

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: "{{session('error')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif
    </script>


@stop
