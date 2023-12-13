@extends('adminlte::page')

@section('title', 'Editar tratamiento')

@section('content_header')
@stop

@section('content')
    <div class="card card-dark mt-3">
        <div class="card-header">
            <h5>Editar Tratamiento</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('gestion-tratamientos.update', $tratamiento->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="tratamiento" class="form-label">Tratamiento <span class="text-muted">(*)</span></label>
                    <input value="{{$tratamiento->tratamiento}}" type="text" name="tratamiento" id="tratamiento" class="form-control" tabindex="2">

                    @error('tratamiento')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label for="tipo_de_dieta">Tipo de dieta <span class="text-muted">(*)</span></label>
                        <select class="form-select" name="tipo_de_dieta" id="tipo_de_dieta">
                            <option value="">Seleccione un tipo de dieta para el tratamiento</option>
                            @foreach ($tiposDeDietas as $dieta)
                                <option value="{{ $dieta->id }}"
                                    @if ($dieta->id == $tratamiento->tipo_de_dieta_id)
                                        selected
                                    @endif
                                >
                                    {{ $dieta->tipo_de_dieta }}
                                </option>
                            @endforeach
                        </select>

                        @error('tipo_de_dieta')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label for="actividades">Tipo de Actividades <span class="text-muted">(*)</span></label>
                        <select name="actividades[]" class="form-select" id="actividades" data-placeholder="Actividades..." multiple>
                            <option value="">Selecciona una actividad</option>
                            @foreach ($tiposActividades as $tipoActividad)
                                <option
                                    @foreach ($tiposActividadesSeleccionadas as $seleccionado)
                                        @if($tipoActividad->id == $seleccionado->tipo_actividad_id)
                                            selected
                                        @endif
                                    @endforeach
                                    value="{{ $tipoActividad->id }}">{{ $tipoActividad->tipo_actividad }}
                                </option>
                            @endforeach
                        </select>

                        @error('actividades')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <span class="text-muted">Los datos con la etiqueta (*) significa que son obligatorios</span>
                </div>

                <div class="mt-3 float-right">
                    <form action="{{ route('gestion-tratamientos.index') }}">
                        @csrf

                        <button type="button" class="btn btn-danger cancelar-button">
                            Cancelar
                        </button>
                    </form>

                    <button type="button" id="guardar-button" class="btn btn-success guardar-button">Guardar</button>
                </div>
            </form>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>

        //Select2
        $( '#actividades' ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            closeOnSelect: false,
        } );

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
            const cancelarButtons = document.querySelectorAll('.cancelar-button');


            cancelarButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    // Muestra un SweetAlert de confirmación
                    swalWithBootstrapButtons.fire({
                        title: '¿Estás seguro de cancelar la edición?',
                        text: 'Esta acción redirigirá a la vista con todos los tratamientos.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, cancelar edición',
                        confirmButtonColor: '#198754',
                        cancelButtonText: 'No, volver a edición.',
                        cancelButtonColor: '#d33',
                        reverseButtons: true,
                        customClass: {
                            confirmButton: 'btn btn-success ml-2', // Añade la clase ml-2 al botón Confirmar
                            cancelButton: 'btn btn-danger', // Clase para el botón Cancelar
                        },
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Si el usuario confirma, envía el formulario
                            //button.closest('form').submit();
                            window.location.href = "{{ route('gestion-tratamientos.index') }}";
                        }
                    });
                });
            });
        });

        //SweetAlert
        document.addEventListener('DOMContentLoaded', function () {
            // Selecciona todos los botones de eliminar con la clase 'delete-button'
            const guardarButtons = document.querySelectorAll('.guardar-button');

            // Agrega un controlador de clic a cada botón de eliminar
            guardarButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    // Muestra un SweetAlert de confirmación
                    swalWithBootstrapButtons.fire({
                        title: '¿Estás seguro de editar el tratamiento?',
                        text: 'Esta acción modificará la información actual del tratamiento.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, editar tratamiento',
                        confirmButtonColor: '#198754',
                        cancelButtonText: 'No, cancelar edición',
                        cancelButtonColor: '#d33',
                        reverseButtons: true,
                        customClass: {
                            confirmButton: 'btn btn-success ml-2', // Añade la clase ml-2 al botón Confirmar
                            cancelButton: 'btn btn-danger', // Clase para el botón Cancelar
                        },
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
