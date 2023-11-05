@extends('adminlte::page')

@section('title', 'Lista de actividades')

@section('content_header')
    <h1>Lista de Actividades</h1>
@stop

@section('content')

    <a class="btn btn-primary" href="gestion-actividades/create">Agregar nueva actividad</a>

    <div class="container mt-3">
        <table id="tabla-actividades" class="table table-dark table-striped mt-4">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Actividad</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($actividades as $actividad)
                    <tr>
                        <td>{{$actividad->id}}</td>
                        <td>{{$actividad->actividad}}</td>
                        <td>
                            <div>
                                <form action="{{ route('gestion-actividades.edit', $actividad->id) }}" method="GET"style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-warning">
                                        <span class="far fa-edit"></span>
                                    </button>
                                </form>
                                <form action="{{ route('gestion-actividades.destroy', $actividad->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger delete-button">
                                        <span class="far fa-trash-alt"></span>
                                    </button>
                                </form>
                            </div>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
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
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
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
            const deleteButtons = document.querySelectorAll('.delete-button');

            // Agrega un controlador de clic a cada botón de eliminar
            deleteButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    // Muestra un SweetAlert de confirmación
                    swalWithBootstrapButtons.fire({
                        title: '¿Estás seguro?',
                        text: 'Esta acción eliminará el registro de actividad.',
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
