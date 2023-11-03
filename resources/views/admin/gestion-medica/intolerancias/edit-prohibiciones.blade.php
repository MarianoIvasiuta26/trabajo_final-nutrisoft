@extends('adminlte::page')

@section('title', 'Editar prohibición en Intolerancias')

@section('content_header')
    <h1>Alimentos prohibidos en Intolerancias</h1>
@stop

@section('content')


    <div class="card card-dark">
        <div class="card-header">
            <h5>Alimentos prohibidos en Intolerancias</h5>
        </div>

        <div class="card-body">

            <form action="{{route('prohibiciones-intolerancias.update', $prohibicion->id)}}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <h6>Selecciona un Alimento:</h6>
                        <select name="alimentos" class="form-select" id="alimentos" data-placeholder="Alimentos...">
                            <option value="">Selecciona un alimento</option>
                            @foreach ($alimentos as $alimento)
                                <option @if($alimento->id == $alimentoSeleccionado->id) selected @endif value="{{ $alimento->id }}">{{ $alimento->alimento }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <h6>Selecciona una intolerancia:</h6>
                        <select name="intolerancias" class="form-select" id="intolerancias" data-placeholder="Intolerancias...">
                            <option value="">Ninguna</option>
                            @foreach ($intolerancias as $intolerancia)
                                <option @if($intolerancia->id == $intoleranciaSeleccionada->id) selected @endif value="{{$intolerancia->id}}">{{$intolerancia->intolerancia}}</option>
                            @endforeach
                        </select>
                        @error('intolerancias')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                <div class="row mt-3">
                    <div class="col">
                        <div class="float-right">
                            <a href="{{route('prohibiciones-intolerancias.create')}}" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</a>

                            <button type="button" class="btn btn-success asociar-button">Guardar</button>

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        $( '#alimentos' ).select2( {
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
                        title: '¿Estás seguro de editar la prohibicón para la intolerancia?',
                        text: 'Luego no se recomendará este alimento en la dieta de los pacientes con estas alergias.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, editar prohibición.',
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
            const deleteButtons = document.querySelectorAll('.volver-button');

            // Agrega un controlador de clic a cada botón de eliminar
            deleteButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    // Muestra un SweetAlert de confirmación
                    swalWithBootstrapButtons.fire({
                        title: '¿Estás seguro de volver a la vista principal d elas prohibiciones?',
                        text: '',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, volver',
                        cancelButtonText: 'Cancelar',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Si el usuario confirma, envía el formulario
                            const form = button.closest('form');
                            form.submit();form = document.querySelector('#volver-form');
                        }
                    });
                });
            });
        });
    </script>
@stop
