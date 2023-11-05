@extends('adminlte::page')

@section('title', 'Editar Actividad')

@section('content_header')
@stop

@section('content')

    <div class="card card-dark mt-3">
        <div class="card-header">
            <h5>Editar Actividad</h5>
        </div>

        <div class="card-body">

            <form action="{{route('gestion-actividades.update', $actividad->id)}}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="actividad" class="form-label">Actividad</label>
                    <input type="text" name="actividad" id="actividad" class="form-control" tabindex="2" value="{{$actividad->actividad}}" @if('error') value="{{old('actividad')}}" @endif>

                    @error('actividad')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div class="float-right">
                    <a href="{{route('gestion-actividades.index')}}" class="btn btn-danger" tabindex="5">Cancelar</a>
                    <button type="button" class="btn btn-success guardar-button" tabindex="4">Guardar</button>
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
            const guardarButtons = document.querySelectorAll('.guardar-button');

            // Agrega un controlador de clic a cada botón de eliminar
            guardarButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    // Muestra un SweetAlert de confirmación
                    swalWithBootstrapButtons.fire({
                        title: '¿Estás seguro de guardar la actividad?',
                        text: 'Esta acción guardará el registro de actividad.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, Guardar actividad.',
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
