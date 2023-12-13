@extends('adminlte::page')

@section('title', 'Agregar nuevo usuario')

@section('content_header')

@stop

@section('content')

    <div class="card card-dark mt-3">
        <div class="card-header">
            <h5 class="card-title">Agregar nuevo usuario</h5>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget = "collapse" title= "collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('gestion-usuarios.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nombre<span class="text-muted">(*)</span></label>
                    <input type="text" name="name" id="name" class="form-control" tabindex="2" maxlength="50">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="apellido">Apellido<span class="text-muted">(*)</span></label>
                    <input type="text" name="apellido" id="apellido" class="form-control" tabindex="3" maxlength="50">
                    @error('apellido')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tipo_usuario" class="form-label">Rol <span class="text-muted">(*)</label>
                    <select name="tipo_usuario" id="tipo_usuario" class="form-control" tabindex="4">
                        <option value="Administrador">Administrador</option>
                        <option value="Nutricionista">Nutricionista</option>
                        <option value="Paciente">Paciente</option>
                    </select>

                    @error('tipo_usuario')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email <span class="text-muted">(*)</span> </label>
                    <input type="email" name="email" id="email" class="form-control" tabindex="5" maxlength="50">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="alert alert-warning mt-3" role="alert">
                    Los campos marcados con un (*) son obligatorios.
                </div>

                <div class="row float-right">
                    <div class="col-auto">
                        <a href="{{ route('gestion-usuarios.index') }}" class="btn btn-danger" tabindex="7">Cancelar</a>
                        <button type="button" class="btn btn-success guardar-button">Guardar</button>
                    </div>
                </div>

            </form>

        </div>

    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        //SweetAlert para mensajes flash
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

        @if(session('info'))
            Swal.fire({
                icon: 'info',
                title: '¡Información!',
                text: "{{session('info')}}",
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
            const guardarButtons = document.querySelectorAll('.guardar-button');

            // Agrega un controlador de clic a cada botón de eliminar
            guardarButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    // Muestra un SweetAlert de confirmación
                    swalWithBootstrapButtons.fire({
                        title: '¿Estás seguro de crear el usuario?',
                        text: 'Esta acción crearáel registro de usuario.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, crear',
                        confirmButtonColor: '#198754',
                        cancelButtonText: 'Cancelar',
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
