@extends('adminlte::page')

@section('title', 'Estadísticas y Reportes')

@section('content_header')
    <h1>Estadísticas y Reportes</h1>
@stop

@section('content')

    <div class="row mt-3">
        <div class="col-lg-8 col-md-6">
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">Tratamientos</h3>
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
                    <div class="dropdown float-right">
                        <a class="btn btn-primary btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-list"></i>
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#datosTratamientos">Datos Tabulares</a></li>
                            <li><a class="dropdown-item" href="#">Generar Reporte</a></li>
                        </ul>
                    </div>

                    <!-- Filtros -->
                    <div class="collapse" id="filtros">
                        <div class="card card-body mt-2">
                            <form action="{{ route('gestion-estadisticas.filtrosTratamiento') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="fecha_inicio">Desde:</label>
                                        <input class="form-control" type="date" name="fecha_inicio"  value="{{ old('fecha_inicio', session('tratamientoFilters.fecha_inicio')) }}">

                                        @error( 'fecha_desde' )
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="fecha_fin">Hasta:</label>
                                        <input class="form-control" type="date" name="fecha_fin" value="{{ old('fecha_fin', session('tratamientoFilters.fecha_fin')) }}">

                                        @error('fecha_hasta')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="justify-end float-right" style="display: inline-block;">
                                    <button class="btn btn-primary btn-sm" type="submit">Filtrar</button>
                                    <a href="{{route('gestion-estadisticas.clearTratamientoFilters')}}" class="btn btn-danger btn-sm">Borrar filtros</a>
                                </div>

                            </form>
                        </div>
                    </div>

                    <!-- Tabla -->
                    <div class="modal fade" id="datosTratamientos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="datosTratamientosLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="datosTratamientosLabel">Datos Tabulares - Tratamientos</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
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
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="chart-container">

                    </div>
                    <canvas id="myChart" style="display:block; width:100%; height:450px;"></canvas>

                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">Tags Diagnósticos</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget = "collapse" title= "collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">

                    <a class="btn btn-warning btn-sm" data-bs-toggle="collapse" href="#filtrosTag" role="button" aria-expanded="false" aria-controls="filtrosTag">
                        <i class="bi bi-funnel"></i>Filtros
                    </a>

                    <div class="dropdown float-right">
                        <a class="btn btn-primary btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuTag" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-list"></i>
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuTag">
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#datosTags">Datos Tabulares</a></li>
                            <li><a class="dropdown-item" href="#">Generar Reporte</a></li>
                        </ul>
                    </div>

                    <!-- Filtros tags -->
                    <div class="collapse" id="filtrosTag">
                        <div class="card card-body mt-2">

                            <form action="{{ route('gestion-estadisticas.filtrosTag') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="fecha_inicio">Desde:</label>
                                        <input class="form-control" type="date" name="fecha_inicio"  value="{{ old('fecha_inicio', session('tagsFilters.fecha_inicio')) }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="fecha_fin">Hasta:</label>
                                        <input class="form-control" type="date" name="fecha_fin" value="{{ old('fecha_fin', session('tagsFilters.fecha_fin')) }}">
                                    </div>
                                </div>

                                <div class="justify-end float-right" style="display: inline-block;">
                                    <button class="btn btn-primary btn-sm" type="submit">Aplicar</button>
                                    <a href="{{route('gestion-estadisticas.clearTagsFilters')}}" class="btn btn-danger btn-sm">Borrar filtros</a>
                                </div>

                            </form>

                        </div>
                    </div>

                    <!-- Tabla -->
                    <div class="modal fade" id="datosTags" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="datosTagsLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="datosTagsLabel">Datos Tabulares - Tags</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-striped" id="tabla-diagnosticos">
                                        <thead>
                                            <tr>
                                                <th scope="col">Tag Diagnóstico</th>
                                                <th scope="col">Cantidad en consultas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($labels2 as $tagUsada)
                                                <tr>
                                                    <td>
                                                        {{ $tagUsada }}
                                                    </td>
                                                    <td>
                                                        {{ $cantidadTags[$tagUsada] ?? 0 }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <canvas id="myChart2" style="display: inline-block;"></canvas>

                </div>
            </div>
        </div>

    </div>

    <div class="row mt-3">
        <div class="col-lg-12 col-md-6">
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">Alimentos Recomendados</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget = "collapse" title= "collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">

                    <a class="btn btn-warning btn-sm" data-bs-toggle="collapse" href="#filtrosAlimentosRecomendados" role="button" aria-expanded="false" aria-controls="filtrosAlimentosRecomendados">
                        <i class="bi bi-funnel"></i>Filtros
                    </a>

                    <div class="dropdown float-right">
                        <a class="btn btn-primary btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuAlimentosRecomendados" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-list"></i>
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuAlimentosRecomendados">
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#datosAlimentosRecomendados">Datos Tabulares</a></li>
                            <li><a class="dropdown-item" href="#">Generar Reporte</a></li>
                        </ul>
                    </div>

                    <!-- Filtros tags -->
                    <div class="collapse" id="filtrosAlimentosRecomendados">
                        <div class="card card-body mt-2">

                            <form action="{{ route('gestion-estadisticas.filtrosTag') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="fecha_inicio">Desde:</label>
                                        <input class="form-control" type="date" name="fecha_inicio"  value="{{ old('fecha_inicio', session('tagsFilters.fecha_inicio')) }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="fecha_fin">Hasta:</label>
                                        <input class="form-control" type="date" name="fecha_fin" value="{{ old('fecha_fin', session('tagsFilters.fecha_fin')) }}">
                                    </div>
                                </div>

                                <div class="justify-end float-right" style="display: inline-block;">
                                    <button class="btn btn-primary btn-sm" type="submit">Aplicar</button>
                                    <a href="{{route('gestion-estadisticas.clearTagsFilters')}}" class="btn btn-danger btn-sm">Borrar filtros</a>
                                </div>

                            </form>

                        </div>
                    </div>

                    <!-- Tabla -->
                    <div class="modal fade" id="datosAlimentosRecomendados" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="datosAlimentosRecomendadosLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="datosAlimentosRecomendadosLabel">Datos Tabulares - Alimentos Recomendados</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <canvas id="myChart3" style="display: inline-block;"></canvas>


                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.js" integrity="sha512-6HrPqAvK+lZElIZ4mZ64fyxIBTsaX5zAFZg2V/2WT+iKPrFzTzvx6QAsLW2OaLwobhMYBog/+bvmIEEGXi0p1w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
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

        //-----------------Gráfico 2 - Porcentaje de Diagnósticos por Tags---------------------------------
        // Configuración del gráfico de pie
        var ctx2 = document.getElementById('myChart2').getContext('2d');
        console.log('Labels:', <?= json_encode($labels2) ?>);
        console.log('Data:', <?= json_encode($data2) ?>);

        // Obtener cantidad de etiquetas
        var numLabels = <?= count($labels2) ?>;

        // Generar colores de forma dinámica
        var dynamicColors = function () {
            var colors = [];
            for (var i = 0; i < numLabels; i++) {
                var r = Math.floor(Math.random() * 255);
                var g = Math.floor(Math.random() * 255);
                var b = Math.floor(Math.random() * 255);
                colors.push('rgb(' + r + ',' + g + ',' + b + ')');
            }
            return colors;
        };

        // Configuración del conjunto de datos
        var datasetConfig = {
            label: 'Porcentaje de Diagnósticos por Tags',
            data: <?= json_encode($data2) ?>,
            backgroundColor: dynamicColors(),
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        };
        console.log('Labels:', <?= json_encode($labels2) ?>);

        // Configuración del gráfico
        var myChart2 = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: <?= json_encode($labels2) ?>,
                datasets: [datasetConfig],
            },
            options: {
                title: {
                    display: true,
                    text: 'Proporción de Diagnósticos por Tags',
                    position: 'top'
                },
                responsive: true,
                title: {
                    display: true,
                    text: 'Chart.js Pie Chart'
                }
            }
        });


        //-----------------Gráfico 3 - Cantidad de alimentos Recomendados---------------------------------
        // Configuración del gráfico de barra
        var ctx3 = document.getElementById('myChart3').getContext('2d');
        console.log('Labels:', <?= json_encode($labels3) ?>);
        console.log('Data:', <?= json_encode($data3) ?>);

        // Configuración del gráfico
        var myChart3 = new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels3); ?>,
                datasets: [{
                    label: 'Frecuencia de Alimentos Recomendados',
                    data: <?php echo json_encode($data3); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Puedes ajustar el color de las barras según tus preferencias
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                title: {
                    display: true,
                    text: 'Alimento Recomendado',
                    position: 'top'
                },
                responsive: true,
                title: {
                    display: true,
                    text: ''
                }
            }
        });


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

        //Datatable Tags
        $(document).ready(function(){
            $('#tabla-diagnosticos').DataTable({
                responsive: true,
                autoWidth: false,
                "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_",
                    "zeroRecords": "No se encontró ninguna etiqueta",
                    "info": "",
                    "infoEmpty": "No hay etiquetas",
                    "infoFiltered": "(filtrado de _MAX_ etiquetas totales)",
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
    </script>
@stop
