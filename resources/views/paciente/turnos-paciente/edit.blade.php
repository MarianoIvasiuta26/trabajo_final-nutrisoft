@extends('adminlte::page')

@section('title', 'Mis turnos')

@section('content_header')
    <h1>Turno solicitado para el {{$turno->fecha}} - {{$paciente->user->name}} {{$paciente->user->apellido}}</h1>
@stop

@section('content')

    <div class="card card-dark">
        <div class="card-header">
            <h5>Editar turno</h5>
        </div>

        <div class="card-body">
            <form action="{{route('turnos.update', $turno->id)}}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label" for="profesional">Profesional</label>
                        <select name="profesional" id="profesional" class="form-select">
                            <option value="">Seleccione un profesional</option>
                            @foreach($profesionales as $profesional)
                                <option value="{{$profesional->id}}"
                                    @foreach ($horarios as $horario)
                                        @if ($horario->nutricionista_id == $profesional->id && $turno->horario_id == $horario->id)
                                            selected
                                        @endif
                                    @endforeach
                                    >{{$profesional->user->name}} {{$profesional->user->apellido}}
                                </option>
                            @endforeach
                        </select>

                        @error('profesional')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="paciente">Paciente</label>
                        <input
                            @foreach ($pacientes as $paciente)
                                @if ($paciente->user_id == auth()->user()->id)
                                value="{{$paciente->user->name}} {{$paciente->user->apellido}}"
                                @endif
                            @endforeach
                        class="form-control" name="paciente" id="paciente" type="text" disabled>

                        @error('paciente')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label class="form-label" for="tipo_consulta">Tipo de consulta</label>
                        <select class="form-select" name="tipo_consulta" id="tipo_consulta">
                            <option value="">Seleccione un tipo de consulta</option>
                            @foreach($tipo_consultas as $tipo_consulta)
                                @foreach ($turnos as $turno)
                                    @if ($turno->paciente_id == $paciente->id && $turno->tipo_consulta_id == 1)
                                        @if ($tipo_consulta->id == 1)
                                            <option value="{{$tipo_consulta->id}}" disabled>{{$tipo_consulta->tipo_consulta}}</option>
                                        @else
                                            <option value="{{$tipo_consulta->id}}" selected>{{$tipo_consulta->tipo_consulta}}</option>
                                        @endif
                                        <option value="2" selected>Seguimiento</option>
                                    @else
                                        <option value="{{$tipo_consulta->id}}"
                                            @if ($turno->tipo_consulta_id == $tipo_consulta->id)
                                                selected
                                            @endif
                                            >{{$tipo_consulta->tipo_consulta}}</option>
                                    @endif
                                @endforeach
                            @endforeach
                        </select>
                        @error('tipo_consulta')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="objetivo_salud">Objetivo de salud</label>
                        <select class="form-select" name="objetivo_salud" id="objetivo_salud" disabled>
                            @foreach ($pacientes as $paciente)
                                @foreach ($historias_clinicas as $historia_clinica)
                                    @if ($paciente->user_id == auth()->user()->id)
                                        @if ($historia_clinica->paciente_id == $paciente->id)
                                            <option value="{{$historia_clinica->objetivo_salud}}">{{$historia_clinica->objetivo_salud}}</option>
                                        @endif
                                    @endif
                                @endforeach
                            @endforeach
                        </select>
                        @error('objetivo_salud')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3" id="horarios-disponibles">
                    <div class="col-md-6" id="fecha-turno">
                        <label class="form-label" for="fecha">Fecha</label>
                        <input class="form-control" type="date" name="fecha" id="fecha" value="{{$turno->fecha}}">

                        @error('fecha')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-6" id="estado">
                        <label class="form-label" for="estado">Estado</label>
                        <select class="form-select" name="estado" id="estado">
                            <option value="Pendiente" @if ($turno->estado == 'Pendiente')
                                selected
                            @endif @if ($turno->estado == 'Cancelado')
                                disabled
                            @endif>Pendiente</option>
                            <option value="Cancelado" @if ($turno->estado == 'Cancelado')
                                selected
                            @endif @if ($turno->estado == 'Cancelado')
                                disabled
                            @endif>Cancelado</option>
                            <option value="Confirmar asistencia" @if ($turno->estado == 'Confirmar asistencia')
                                selected
                            @endif @if ($turno->estado == 'Cancelado')
                                disabled
                            @endif>Confirmar asistencia</option>
                        </select>

                        @error('fecha')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label for="hora">Horas Disponibles</label>
                        <br>
                        <div class="btn-group" data-toggle="buttons" id="horas-disponibles">

                            @error('hora')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div id="mensaje-error" class="alert alert-danger" style="display: none;">
                            No hay horarios disponibles para la fecha seleccionada o este día no se realizan consultas.
                        </div>
                    </div>
                </div>

                <button class="btn btn-success mt-3" type="submit">Guardar</button>
                <a href="{{route('turnos.index')}}" class="btn btn-danger mt-3">Volver</a>

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

    <script>
        //Agregamos un evento change al input date
        // Obtén el token CSRF del formulario
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var profesionalSeleccionado = $('#profesional').val();
        var fechaSeleccionada = new Date().toISOString().slice(0, 10); // Obtiene la fecha actual en formato 'YYYY-MM-DD'
        var horaSeleccionada = "{{ $horaSeleccionada ?? '' }}";
        horaSeleccionada = horaSeleccionada.substring(0, 5); // Ajustar el formato a "10:30"

        $.ajax({
            url: '{{ route('turnos.horas-disponibles') }}',
            method: 'POST',
            data: {
                profesional: profesionalSeleccionado,
                fecha: fechaSeleccionada,
                _token: csrfToken,
            },
            success: function (horasDisponibles) {
                if (horasDisponibles.horasDisponiblesManiana && horasDisponibles.horasDisponiblesManiana.length > 0
                    || horasDisponibles.horasDisponiblesTarde && horasDisponibles.horasDisponiblesTarde.length > 0) {
                    // Si hay horarios disponibles, oculta el mensaje de error.
                    $('#mensaje-error').hide();

                    // Limpiar cualquier contenido anterior
                    $('#horas-disponibles').empty();

                    // Iterar sobre las horas disponibles y crear botones de alternancia
                    $.each(horasDisponibles.horasDisponiblesManiana, function (index, hora) {
                    // Crea un botón de alternancia para cada hora
                    var btn = $('<label class="btn btn-outline-secondary hora-disponible-maniana">' +
                        '<input type="radio" name="hora" value="' + hora + '">' + hora +
                        '</label>');

                    // Agrega el botón al contenedor
                    $('#horas-disponibles').append(btn);

                    // Verifica si esta hora es la seleccionada y, si es así, márcala como seleccionada
                    if (hora === horaSeleccionada) {
                        btn.addClass('active'); // Esto marca la hora seleccionada como activa
                        btn.find('input').prop('checked', true);
                    }
                });

                $.each(horasDisponibles.horasDisponiblesTarde, function (index, hora) {
                    // Crea un botón de alternancia para cada hora
                    var btn = $('<label class="btn btn-outline-secondary hora-disponible-tarde">' +
                        '<input type="radio" name="hora" value="' + hora + '">' + hora +
                        '</label>');

                    // Agrega el botón al contenedor
                    $('#horas-disponibles').append(btn);

                    // Verifica si esta hora es la seleccionada y, si es así, márcala como seleccionada
                    if (hora === horaSeleccionada) {
                        btn.addClass('active'); // Esto marca la hora seleccionada como activa
                        btn.find('input').prop('checked', true);
                    }
                });
                    $('#horas-disponibles').show();
                } else {
                    // Si no hay horarios disponibles, muestra el mensaje de error.
                    $('#mensaje-error').show();
                    $('#horas-disponibles').hide();
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    </script>
@stop
