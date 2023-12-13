@extends('adminlte::page')

@section('title', 'Editar usuario')

@section('content_header')
@stop

@section('content')

    <div class="card card-dark mt-3">
        <div class="card-header">
            <h5 class="card-title">Editar usuario</h5>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget = "collapse" title= "collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form action="{{route('gestion-usuarios.update', $usuario->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre <span class="text-muted">(*)</span> </label>
                    <input type="text" name="name" id="name" class="form-control" value="{{$usuario->name}}">
                </div>
                <div class="mb-3">
                    <label for="apellido">Apellido <span class="text-muted">(*)</span> </label>
                    <input type="text" name="apellido" id="apellido" class="form-control" value="{{$usuario->apellido}}">
                </div>
                <div class="mb-3">
                    <label for="tipo_usuario" class="form-label">Rol <span class="text-muted">(*)</span> </label>
                    <select name="tipo_usuario" id="tipo_usuario" class="form-control" tabindex="6">
                        <option value="Administrador" @if ($usuario->tipo_usuario === 'Administrador') selected @endif>Administrador</option>
                        <option value="Nutricionista" @if ($usuario->tipo_usuario === 'Nutricionista') selected @endif>Nutricionista</option>
                        <option value="Paciente" @if ($usuario->tipo_usuario === 'Paciente') selected @endif>Paciente</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email <span class="text-muted">(*)</span> </label>
                    <input type="email" name="email" id="email" class="form-control" value="{{$usuario->email}}">
                </div>

                <div class="alert alert-warning mt-3" role="alert">
                    Los campos marcados con un (*) son obligatorios.
                </div>

                <div class="row float-right">
                    <div class="col-auto ">
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
                        title: '¿Estás seguro de editar el usuario?',
                        text: 'Esta acción modificará el registro de usuario.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, editar',
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
