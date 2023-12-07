@extends('adminlte::page')

@section('title', 'Alimentos recomendados en dietas')

@section('content_header')

@stop

@section('content')


    <div class="card card-dark mt-3">
        <div class="card-header">
            <h5>Alimentos recomendados en dietas</h5>
        </div>

        <div class="card-body">

            <form action="{{route('gestion-alimento-por-dietas.store')}}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <h6>Selecciona un Alimento:</h6>
                        <select name="alimento_id" class="form-control">
                            <option value="">Selecciona un alimento</option>
                            @foreach ($alimentos as $alimento)
                                <option @if(old('alimento_id', null) == $alimento->id) selected @endif value="{{ $alimento->id }}">{{ $alimento->alimento }}</option>
                            @endforeach
                        </select>

                        @error('alimento_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <h6>Selecciona un Tipo de Dieta:</h6>
                        <select name="tipo_de_dieta_id" class="form-control">
                            <option value="" disabled selected>Selecciona un tipo de dieta</option>
                            @foreach ($tiposDietas as $tipoDieta)
                                <option @if(old('tipo_de_dieta_id', null) == $tipoDieta->id) selected @endif value="{{ $tipoDieta->id }}">
                                    {{ $tipoDieta->tipo_de_dieta }}
                                </option>
                            @endforeach
                        </select>
                        @error('tipo_de_dieta_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <h6>Cantidad:</h6>
                        <input type="text" name="cantidad" class="form-control" value="{{old('cantidad')}}">

                        @error('cantidad')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <h6>Unidad de Medida:</h6>
                        <select name="unidad_medida_id" class="form-control">
                            <option value="">Selecciona una unidad de medida</option>
                            @foreach ($unidadesMedidas as $unidadMedida)
                            <option @if(old('unidad_medida_id', null) == $unidadMedida->id) selected @endif value="{{ $unidadMedida->id }}">{{ $unidadMedida->nombre_unidad_medida }}</option>
                            @endforeach
                        </select>

                        @error('unidad_medida_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <h6>Comida</h6>
                        <select name="comida_id" class="form-control">
                            <option value="">Selecciona una comida</option>
                            @foreach ($comidas as $comida)
                                <option @if(old('comida_id', null) == $comida->id) selected @endif value="{{ $comida->id }}">{{ $comida->nombre_comida }}</option>
                            @endforeach
                        </select>
                        @error('comida_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col">
                        <div class="float-right">
                            <button type="button" class="btn btn-success asociar-button">Asociar Alimento con Dieta</button>
                        </div>
                    </div>
                </div>

            </form>
            <div class="mt-4">
                <h5>Asociaciones Actuales:</h5>
                <table class="table table-dark" id="tabla-alimentos">
                    <thead>
                        <tr>
                            <th>Alimento</th>
                            <th>Tipo de Dieta</th>
                            <th>Cantidad</th>
                            <th>Unidad de Medida</th>
                            <th>Comida</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($alimentosPorDietas as $alimentoPorDieta)
                            <tr>
                                <td>
                                    @foreach ($alimentos as $alimento)
                                        @if ($alimento->id == $alimentoPorDieta->alimento_id)
                                            {{ $alimento->alimento }}
                                        @endif
                                    @endforeach
                                </td>

                                <td>
                                    @foreach ($tiposDietas as $tipoDieta)
                                        @if ($tipoDieta->id == $alimentoPorDieta->tipo_de_dieta_id)
                                            {{ $tipoDieta->tipo_de_dieta }}
                                        @endif
                                    @endforeach
                                </td>

                                <td>
                                    @foreach ($alimentosRecomendadosPorDietas as $alimentoRecomendadoPorDieta)
                                        @if ($alimentoRecomendadoPorDieta->alimento_por_dieta_id == $alimentoPorDieta->id)
                                            {{ $alimentoRecomendadoPorDieta->cantidad }}
                                        @endif
                                    @endforeach
                                </td>

                                <td>
                                    @foreach ($unidadesMedidas as $unidadMedida)
                                        @foreach ($alimentosRecomendadosPorDietas as $alimentoRecomendadoPorDieta)
                                            @if ($alimentoRecomendadoPorDieta->alimento_por_dieta_id == $alimentoPorDieta->id && $alimentoRecomendadoPorDieta->unidad_medida_id == $unidadMedida->id)
                                                {{ $unidadMedida->nombre_unidad_medida }}
                                            @endif
                                        @endforeach
                                    @endforeach
                                </td>

                                <td>
                                    @foreach ($comidas as $comida)
                                        @foreach ($alimentosRecomendadosPorDietas as $alimentoRecomendadoPorDieta)
                                            @if ($alimentoRecomendadoPorDieta->alimento_por_dieta_id == $alimentoPorDieta->id && $alimentoRecomendadoPorDieta->comida_id == $comida->id)
                                                {{ $comida->nombre_comida }}
                                            @endif
                                        @endforeach
                                    @endforeach
                                </td>

                                <td>
                                    <div class="row g-1">
                                        <div class="col-auto">
                                            <form action="{{ route('gestion-alimento-por-dietas.edit', $alimentoPorDieta->id) }}" method="GET">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm">
                                                    <span class="far fa-edit"></span>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-auto">
                                            <form action="{{ route('gestion-alimento-por-dietas.destroy', $alimentoPorDieta->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm delete-button">
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

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
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>


    <script>

        //Datatables
        $(document).ready(function(){
            var table = $('#tabla-alimentos').DataTable({
                responsive: true,
                autoWidth: false,
                "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ alimentos por página",
                    "zeroRecords": "No se encontró ninguna alimento",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros de alimentos",
                    "infoFiltered": "(filtrado de _MAX_ alimentos totales)",
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
            buttonsStyling: true
        })
        document.addEventListener('DOMContentLoaded', function () {
            // Selecciona todos los botones de eliminar con la clase 'delete-button'
            const guardarButtons = document.querySelectorAll('.asociar-button');

            // Agrega un controlador de clic a cada botón de eliminar
            guardarButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    // Muestra un SweetAlert de confirmación
                    swalWithBootstrapButtons.fire({
                        title: '¿Estás seguro de recomendar este alimento a la dieta seleccionada?',
                        text: 'Esta acción asociará el alimento con este tipo de dieta.',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#198754',
                        confirmButtonText: 'Sí, asociar alimento con la dieta.',
                        cancelButtonColor: '#d33',
                        reverseButtons: true
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
                        text: 'Esta acción eliminará el alimento recomendado a la dieta.',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#198754',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonColor: '#d33',
                        reverseButtons: true
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
