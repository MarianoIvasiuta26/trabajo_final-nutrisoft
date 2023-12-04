@extends('adminlte::page')

@section('title', 'Historial de Turnos')

@section('content_header')

@stop

@section('content')

    <div class="card card-dark mt-3">
        <div class="card-header">
            <h5>Historial de Turnos</h5>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-4 mb-3">
                    <label for="filtro-fecha" class="form-label">Filtrar por Fecha:</label>
                    <input type="text" class="form-control" id="filtro-fecha">
                </div>
                <div class="col-4 mb-3">
                    <label for="filtro-hora" class="form-label">Filtrar por Hora:</label>
                    <input type="text" class="form-control" id="filtro-hora">
                </div>
                <div class="col-4 mb-3">
                    <label for="filtro-estado" class="form-label">Filtrar por Estado:</label>
                    <select class="form-select" id="filtro-estado">
                        <option value="">Todos</option>
                        <option value="Pendiente">Pendiente</option>
                        <option value="Cancelado">Cancelado</option>
                        <option value="Inasistencia">Inasistencia</option>
                        <option value="Realizado" selected>Realizado</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-4 mb-3">
                    <label for="filtro-tipo-consulta" class="form-label">Filtrar por Tipo de Consulta:</label>
                    <select class="form-select" id="filtro-tipo-consulta">
                        <option value="">Todos</option>
                        @foreach ($tipoConsultas as $tipoConsulta)
                            <option value="{{ $tipoConsulta->tipo_consulta }}">{{ $tipoConsulta->tipo_consulta }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4 mb-3">
                    <label for="filtro-objetivo-salud" class="form-label">Filtrar por Objetivo de Salud:</label>
                    <input type="text" class="form-control" id="filtro-objetivo-salud">
                </div>
                <div class="col-4 mb-3">
                    <label for="filtro-paciente" class="form-label">Filtrar por Paciente:</label>
                    <input type="text" class="form-control" id="filtro-paciente">
                </div>
            </div>

            <table id="historial-turnos" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Paciente</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Tipo de consulta</th>
                        <th scope="col">Objetivo de salud</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($turnos as $turno)
                        @foreach ($pacientes as $paciente)
                            @if ($paciente->id == $turno->paciente_id)
                                <tr>
                                    <td>
                                        {{ \Carbon\Carbon::parse($turno->fecha)->format('d-m-Y') }}
                                    </td>

                                    <td>
                                        {{ $turno->hora }}
                                    </td>

                                    <td>

                                        {{ $paciente->user->name }} {{ $paciente->user->apellido }}

                                    </td>

                                    <td>
                                        {{ $turno->estado }}
                                    </td>

                                    <td>
                                        @foreach ($tipoConsultas as $tipoConsulta)
                                            @if ($tipoConsulta->id == $turno->tipo_consulta_id)
                                                {{ $tipoConsulta->tipo_consulta }}
                                            @endif
                                        @endforeach
                                    </td>

                                    <td>
                                        @foreach ($historiasClinicas as $historiaClinica)
                                            @if ($historiaClinica->paciente_id == $paciente->id)
                                                {{ $historiaClinica->objetivo_salud }}
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                            @endif
                        @endforeach
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

                    <form action="{{ route('gestion-turnos-nutricionista.filtros') }}" method="GET">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fecha_inicio">Desde:</label>
                                <input class="form-control" type="date" name="fecha_inicio"  value="{{ old('fecha_inicio', $fechaInicio) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha_fin">Hasta:</label>
                                <input class="form-control" type="date" name="fecha_fin" value="{{ old('fecha_fin', $fechaFin) }}">
                            </div>
                        </div>

                        <div class="justify-end float-right" style="display: inline-block;">
                            <button class="btn btn-primary btn-sm" type="submit">Aplicar</button>
                            <a href="{{route('gestion-turnos-nutricionista.clearFilters')}}" class="btn btn-danger btn-sm">Borrar filtros</a>
                        </div>

                    </form>

                </div>
            </div>

            <h3 class="mt-1" style="text-align: center;">Proporción de diagnósticos por Tags</h3>

            <div style="text-align: center;">
                <canvas id="myChart2" style="display: inline-block;"></canvas>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">

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
            </div>
        </div>
    </div>


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">


@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.js" integrity="sha512-6HrPqAvK+lZElIZ4mZ64fyxIBTsaX5zAFZg2V/2WT+iKPrFzTzvx6QAsLW2OaLwobhMYBog/+bvmIEEGXi0p1w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Moment.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <!-- datetime-moment CDN -->
    <script src="https://cdn.datatables.net/datetime-moment/2.6.1/js/dataTables.dateTime.min.js"></script>

    <script>
        $(document).ready(function(){
            var table = $('#historial-turnos').DataTable({
                responsive: true,
                autoWidth: false,
                "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ turnos por página",
                    "zeroRecords": "No se encontró ningún turno",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros de turnos",
                    "infoFiltered": "(filtrado de _MAX_ turnos totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                },
                order: [[ 0, "desc" ]],
                columnDefs: [
                    {
                        targets: 0, // Índice de la columna de fecha
                        type: 'datetime-moment',
                        render: function (data, type, row) {
                            return type === 'sort' ? moment(data, 'DD-MM-YYYY').format('YYYY-MM-DD') : data;
                        }
                    }
                ]
            });

            // Aplicar los filtros personalizados
            $('#filtro-fecha').on('keyup', function(){
                table.column(0).search(this.value).draw(); // Columna 0 para la fecha
            });

            $('#filtro-hora').on('keyup', function(){
                table.column(1).search(this.value).draw(); // Columna 1 para la hora
            });

            $('#filtro-estado').on('change', function(){
                table.column(3).search(this.value).draw(); // Columna 3 para el estado
            });

            //Filtro estado or defecto
            var filtroEstado = $('#filtro-estado');
            filtroEstado.val('Realizado');
            table.column(3).search('Realizado').draw();

            $('#filtro-tipo-consulta').on('change', function(){
                table.column(4).search(this.value).draw(); // Columna 4 para el tipo de consulta
            });

            $('#filtro-objetivo-salud').on('keyup', function(){
                table.column(5).search(this.value).draw(); // Columna 5 para el objetivo de salud
            });

            $('#filtro-paciente').on('keyup', function(){
                table.column(2).search(this.value).draw(); // Columna 2 para el paciente
            });
        });

        //Datable estadísticas
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

        //Gráfico 2 - Porcentaje de Diagnósticos por Tags
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
                responsive: false,
                title: {
                    display: true,
                    text: 'Chart.js Pie Chart'
                }
            }
        });
    </script>
@stop
