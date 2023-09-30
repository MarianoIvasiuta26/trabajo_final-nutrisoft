@extends('adminlte::page')

@section('title', 'Mis turnos')

@section('content_header')
    <h1>Solicitar un turno</h1>
@stop

@section('content')

        @if(auth()->user()->tipo_usuario === 'Paciente' && !app('App\Http\Controllers\PacienteController')->hasCompletedHistory())

            <div class="alert alert-warning" role="alert">
                <h5>Historia Clínica icompleta</h5>
                Parece que aún no has completado tu Historia Clínica. <br>
                Para tener acceso a esta funcionalidad del sistema, necesita completar su historia clínica. <br>
                Haga click en el siguiente enlace para completar su historia clínica:
                <br><a href="{{ route('historia-clinica.create') }}" class="alert-link">Completar mi Historia Clínica</a>
            </div>

        @else

            @foreach ($turnos as $turno)
                @if($turno->paciente_id == $paciente->id && $turno->estado == 'Pendiente' || $turno->estado == 'Confirmar asistencia')
                    <div class="alert alert-warning" role="alert">
                        <h5>Ya tienes un turno solicitado</h5>
                        <p>Ya tienes un turno solicitado para el día {{$turno->fecha}} a las {{$turno->hora}} hs.</p>
                        <p>Si desea cancelar su turno, haga click en el siguiente enlace:</p>
                        <a href="{{ route('turnos.destroy', $turno->id) }}" class="alert-link">Cancelar mi turno</a>
                    </div>
                @endif
            @endforeach
                <div class="card card-dark">
                    <div class="card-header">
                        <h5>Solicitud de turno</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{route('turnos.store')}}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="profesional">Profesional</label>
                                    <select name="profesional" id="profesional" class="form-select">
                                        <option value="">Seleccione un profesional</option>
                                        @foreach($profesionales as $profesional)
                                            <option value="{{$profesional->id}}">{{$profesional->user->name}} {{$profesional->user->apellido}}</option>
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
                                            <option value="{{$tipo_consulta->id}}">{{$tipo_consulta->tipo_consulta}}</option>
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
                                <div class="col-md-12" id="fecha-turno">
                                    <label class="form-label" for="fecha">Fecha</label>
                                    <input class="form-control" type="date" name="fecha" id="fecha">

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
                                        <!-- Las horas disponibles se agregarán aquí dinámicamente -->
                                        @error('hora')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div id="mensaje-error" class="alert alert-danger" style="display: none;">
                                        No hay horarios disponibles para la fecha seleccionada o este día no se realizan consultas.
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-success mt-3 solicitar-turno-button" type="button">Solicitar turno</button>

                        </form>
                    </div>
                </div>
        @endif

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        //Agregamos un evento change al input date
        document.getElementById('fecha').addEventListener('change', function () {
            var fechaSeleccionada = this.value; // Obtenemos la fecha seleccionada
            // Obtén el token CSRF del formulario
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var profesionalSeleccionado = $('#profesional').val();

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
                        });

                        $.each(horasDisponibles.horasDisponiblesTarde, function (index, hora) {
                            // Crea un botón de alternancia para cada hora
                            var btn = $('<label class="btn btn-outline-secondary hora-disponible-tarde">' +
                                '<input type="radio" name="hora" value="' + hora + '">' + hora +
                                '</label>');

                            // Agrega el botón al contenedor
                            $('#horas-disponibles').append(btn);
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
        });

        //Aplicamos sweetAlert
        document.addEventListener('DOMContentLoaded', function () {
            const solicitarTurno = document.querySelectorAll('.solicitar-turno-button');

            solicitarTurno.forEach(button => {
                button.addEventListener('click', function () {
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: true
                        })

                        swalWithBootstrapButtons.fire({
                        title: '¿Está seguro de solicitar el turno para la fecha y hora seleccionada?',
                        text: "",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: '¡Si, solicitar turno!',
                        confirmButtonColor: '#3085d6',
                        cancelButtonText: '¡No, cancelar!',
                        cancelButtonColor: '#d33',
                        reverseButtons: true
                        }).then((result) => {
                        if (result.isConfirmed) {
                            //Envia el form
                            const form = this.closest('form');
                            form.submit();
                            swalWithBootstrapButtons.fire(
                            '¡Turno solicitado!',
                            'Puede ver los detalles del turno reservado en la sección "Mis turnos".',
                            'success'
                            )
                        } else if (
                            /* Read more about handling dismissals below */
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            swalWithBootstrapButtons.fire(
                            '¡Cancelado!',
                            'La solicitud del turno para la fecha y seleccionada no se ha realizado.',
                            'error'
                            )
                        }
                    })
                });
            });
        });
    </script>
@stop
