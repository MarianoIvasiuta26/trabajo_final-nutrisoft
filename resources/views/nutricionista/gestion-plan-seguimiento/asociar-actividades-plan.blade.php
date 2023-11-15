@extends('adminlte::page')

@section('title', 'Actividades recomendadas por tipo de actividad')

@section('content_header')

@stop

@section('content')


    <div class="card card-dark mt-3">
        <div class="card-header">
            <h5>Actividades recomendadas por tipo de actividad</h5>
        </div>

        <div class="card-body">

            <form action="{{route('gestion-actividad-por-tipo-actividad.store')}}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <h6>Selecciona una Actividad:</h6>
                        <select name="actividad_id" class="form-control">
                            <option value="">Selecciona una actividad</option>
                            @foreach ($actividades as $actividad)
                                <option @if(old('actividad_id', null) == $actividad->id) selected @endif value="{{ $actividad->id }}">{{ $actividad->actividad }}</option>
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
                                <option @if(old('tipo_de_dieta_id', null) == $tipoActividad->id) selected @endif value="{{ $tipoActividad->id }}">
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
                        <input type="text" name="duracion_actividad" class="form-control" value="{{old('duracion_actividad')}}">

                        @error('duracion_actividad')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <h6>Unidad de tiempo:</h6>
                        <select name="unidad_tiempo_id" class="form-control">
                            <option value="">Selecciona una unidad de tiempo</option>
                            @foreach ($unidadesTiempo as $unidadTiempo)
                                <option @if(old('unidad_tiempo_id', null) == $unidadTiempo->id) selected @endif value="{{ $unidadTiempo->id }}">{{ $unidadTiempo->nombre_unidad_tiempo }}</option>
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
                            <button type="button" class="btn btn-success asociar-button">Asociar Actividad</button>
                        </div>
                    </div>
                </div>

            </form>
            <div class="mt-4">
                <h5>Asociaciones Actuales:</h5>
                <table class="table table-dark" id="tabla-actividades">
                    <thead>
                        <tr>
                            <th>Actividad</th>
                            <th>Tipo de Actividad</th>
                            <th>Duración</th>
                            <th>Unidad de Tiempo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($actividadesPorTipoActividad as $actividadPorTipo)
                            <tr>
                                <td>
                                    @foreach ($actividades as $actividad)
                                        @if ($actividad->id == $actividadPorTipo->actividad_id)
                                            {{ $actividad->actividad }}
                                        @endif
                                    @endforeach
                                </td>

                                <td>
                                    @foreach ($tiposActividades as $tipoActividad)
                                        @if ($tipoActividad->id == $actividadPorTipo->tipo_actividad_id)
                                            {{ $tipoActividad->tipo_actividad }}
                                        @endif
                                    @endforeach
                                </td>

                                <td>
                                    @foreach ($actividadesRecomendadas as $actividadRecomendada)
                                        @if ($actividadRecomendada->act_tipoAct_id == $actividadPorTipo->id)
                                            {{ $actividadRecomendada->duracion_actividad }}
                                        @endif
                                    @endforeach
                                </td>

                                <td>
                                    @foreach ($unidadesTiempo as $unidadTiempo)
                                        @foreach ($actividadesRecomendadas as $actividadRecomendada)
                                            @if ($actividadRecomendada->act_tipoAct_id == $actividadPorTipo->id && $actividadRecomendada->unidad_tiempo_id == $unidadTiempo->id)
                                                {{ $unidadTiempo->nombre_unidad_tiempo }}
                                            @endif
                                        @endforeach
                                    @endforeach
                                </td>

                                <td>
                                    <div class="row">
                                        <div class="col-3">
                                            <form action="{{ route('gestion-actividad-por-tipo-actividad.edit', $actividadPorTipo->id) }}" method="GET">
                                                @csrf
                                                <button type="submit" class="btn btn-warning">
                                                    <span class="far fa-edit"></span>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-3">
                                            <form action="{{ route('gestion-actividad-por-tipo-actividad.destroy', $actividadPorTipo->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger delete-button">
                                                    <span class="far fa-trash-alt"></span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
            </div>
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

        //Datatables
        $(document).ready(function(){
            var table = $('#tabla-actividades').DataTable({
                responsive: true,
                autoWidth: false,
                "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ actividades por página",
                    "zeroRecords": "No se encontró ninguna actividad",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros de actividades",
                    "infoFiltered": "(filtrado de _MAX_ actividades totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                }
            });
        });

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
                        title: '¿Estás seguro de recomendar esta actividad al tipo de actividad seleccionado?',
                        text: 'Esta acción asociará la actividad con este tipo de actividad.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, asociar actividad.',
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

        document.addEventListener('DOMContentLoaded', function () {
            // Selecciona todos los botones de eliminar con la clase 'delete-button'
            const deleteButtons = document.querySelectorAll('.delete-button');

            // Agrega un controlador de clic a cada botón de eliminar
            deleteButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    // Muestra un SweetAlert de confirmación
                    swalWithBootstrapButtons.fire({
                        title: '¿Estás seguro?',
                        text: 'Esta acción eliminará la asociación de la actividad.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, eliminar',
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
