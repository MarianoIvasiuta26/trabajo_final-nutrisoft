@extends('adminlte::page')

@section('title', 'Tratamientos')

@section('content_header')
@stop

@section('content')

    <div class="card card-dark mt-3">
        <div class="card-header">
            <h5>Tratamientos</h5>
        </div>

        <div class="card-body">
            <a href="{{ route('gestion-tratamientos.create') }}" class="btn btn-primary mb-3">Crear Tratamiento</a>
            <table id="tratamientos" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Tratamiento</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($tratamientos as $tratamiento)

                        <tr>
                            <td>
                            {{ $tratamiento->id }}
                            </td>
                            <td>
                                {{ $tratamiento->tratamiento }}
                            </td>
                            <td>
                                <div>
                                    <form action="{{ route('gestion-tratamientos.edit', $tratamiento->id) }}" method="GET" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-warning">
                                            <span class="far fa-edit"></span>
                                        </button>
                                    </form>
                                    <form action="{{route('gestion-tratamientos.destroy', $tratamiento->id)}}" method="POST" style="display: inline;">
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
    </div>

    <!-- Estadística -->

    <div class="card card-dark mt-3" >
        <div class="card-header">
            <h3 class="card-title">Estadísticas</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget = "collapse" title= "collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <a class="btn btn-warning btn-sm" data-bs-toggle="collapse" href="#filtros" role="button" aria-expanded="false" aria-controls="filtros">
                <i class="bi bi-funnel"></i>Filtros
            </a>

            <div class="collapse" id="filtros">
                <div class="card card-body mt-2">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('gestion-tratamientos.filtros') }}" method="GET">
                                <label for="fecha_inicio">Desde:</label>
                                <input class="" type="date" name="fecha_inicio"  value="{{ old('fecha_inicio', $fechaInicio) }}">

                                <label for="fecha_fin">Hasta:</label>
                                <input class="" type="date" name="fecha_fin" value="{{ old('fecha_fin', $fechaFin) }}">

                                <div class="justify-end" style="display: inline-block;">
                                    <button class="btn btn-primary btn-sm" type="submit">Filtrar</button>
                                    <a href="{{route('gestion-tratamientos.clearFilters')}}" class="btn btn-danger btn-sm">Borrar filtros</a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <h3 class="mt-1" style="text-align: center;">Tratamientos más frecuentes</h3>

            <canvas id="myChart" style="display:block; width:100%; height:450px;"></canvas>

            <div class="row mt-3">
                <div class="col-md-12">

                    <table class="table table-striped" id="tabla-tratamientos">
                        <thead>
                            <tr>
                                <th scope="col">Tratamiento</th>
                                <th scope="col">Fecha de alta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($todosTratamientos as $tratamiento)
                                @foreach ($tratamientosPorPaciente as $porPaciente)
                                    @if ($porPaciente->tratamiento_id == $tratamiento->id)
                                        <tr>
                                            <td>
                                                {{ $tratamiento->tratamiento }}
                                            </td>
                                            <td>
                                                {{\Carbon\Carbon::parse($porPaciente->fecha_alta)->format('d/m/Y')}}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.js" integrity="sha512-6HrPqAvK+lZElIZ4mZ64fyxIBTsaX5zAFZg2V/2WT+iKPrFzTzvx6QAsLW2OaLwobhMYBog/+bvmIEEGXi0p1w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function(){
            $('#tratamientos').DataTable({
                responsive: true,
                autoWidth: false,
                "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ tratamientos por página",
                    "zeroRecords": "No se encontró ningún tratamientos",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay tratamientos",
                    "infoFiltered": "(filtrado de _MAX_ tratamientos totales)",
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
                        text: 'Esta acción eliminará el registro de alergia.',
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


        //Gráfico
        //Datatable tratamientos
        $(document).ready(function(){
            $('#tabla-tratamientos').DataTable({
                responsive: true,
                autoWidth: false,
                "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_",
                    "zeroRecords": "No se encontró ningún tratamientos",
                    "info": "",
                    "infoEmpty": "No hay tratamientos",
                    "infoFiltered": "(filtrado de _MAX_ tratamientos totales)",
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

        //Gráfico 1 - Frecuencia de tratamientos
        var ctx = document.getElementById('myChart').getContext('2d');
        console.log('Labels:', <?= json_encode($labels) ?>);
        console.log('Data:', <?= json_encode($data) ?>);

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($labels) ?>,
                datasets: [{
                    label: 'Frecuencia de Tratamientos',
                    data: <?= json_encode($data) ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 5
                        }
                    }
                },
                responsive: true,
            }
        });


    </script>
@stop
