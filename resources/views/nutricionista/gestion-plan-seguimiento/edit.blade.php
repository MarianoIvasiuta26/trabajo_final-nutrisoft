@extends('adminlte::page')

@section('title', 'Actividades recomendadas por tipo de actividad')

@section('content_header')

@stop

@section('content')


    <div class="card card-dark">
        <div class="card-header">
            <h5>Actividades recomendadas por tipo de actividad</h5>
        </div>

        <div class="card-body">

            <form action="{{route('gestion-actividad-por-tipo-actividad.update', $actividadPorTipo->id)}}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <h6>Selecciona una Actividad:</h6>
                        <select name="actividad_id" class="form-control">
                            <option value="">Selecciona una actividad</option>
                            @foreach ($actividades as $actividad)
                                <option value="{{ $actividad->id }}" @if ($actividadPorTipo->actividad_id == $actividad->id) selected @endif>
                                    {{ $actividad->actividad }}
                                </option>
                            @endforeach
                        </select>

                        @error('actividad_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <h6>Selecciona un Tipo de actividad:</h6>
                        <select name="tipo_de_actividad_id" class="form-control">
                            <option value="" disabled selected>Selecciona un tipo de actividad</option>
                            @foreach ($tiposActividades as $tipoActividad)
                                <option @if($actividadPorTipo->tipo_actividad_id == $tipoActividad->id) selected @endif value="{{ $tipoActividad->id }}">
                                    {{ $tipoActividad->tipo_actividad }}
                                </option>
                            @endforeach
                        </select>
                        @error('tipo_de_actividad_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6>Duración:</h6>
                        <input type="text" name="duracion_actividad" class="form-control" value="{{$actividadRecomendada->duracion_actividad}}">

                        @error('duracion_actividad')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <h6>Unidad de Tiempo:</h6>
                        <select name="unidad_tiempo_id" class="form-control">
                            <option value="">Selecciona una unidad de tiempo</option>
                            @foreach ($unidadesTiempo as $unidadTiempo)
                                <option @if($actividadRecomendada->unidad_tiempo_id == $unidadTiempo->id) selected @endif value="{{ $unidadTiempo->id }}">{{ $unidadTiempo->nombre_unidad_tiempo }}</option>
                            @endforeach
                        </select>

                        @error('unidad_tiempo_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                <div class="row mt-3">
                    <div class="col">
                        <div class="float-right">
                            <button type="button" class="btn btn-success asociar-button">Guardar</button>
                            <a href="{{route('gestion-actividad-por-tipo-actividad.create')}}" class="btn btn-danger">Cancelar</a>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <style>
        .swal2-confirm {
            margin-right: 5px; /* Ajusta el margen derecho del botón de confirmación */
            font-size: 18px;
        }

        .swal2-cancel {
            margin-left: 5px; /* Ajusta el margen izquierdo del botón de cancelación */
            font-size: 18px;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script> console.log('Hi!'); </script>
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{session('success')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: "{{session('error')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif




        //SweetAlert
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        document.addEventListener('DOMContentLoaded', function () {
            // Selecciona todos los botones de eliminar con la clase 'delete-button'
            const guardarButtons = document.querySelectorAll('.asociar-button');

            // Agrega un controlador de clic a cada botón de eliminar
            guardarButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    // Muestra un SweetAlert de confirmación
                    swalWithBootstrapButtons.fire({
                        title: '¿Estás seguro de guardar la edición?',
                        text: 'Esta acción modificará los datos anteriores.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, guardar edición.',
                        cancelButtonText: 'Cancelar',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Si el usuario confirma, envía el formulario
                            button.closest('form').submit();
                        }
                    });
                });
            });
        });
    </script>
@stop
