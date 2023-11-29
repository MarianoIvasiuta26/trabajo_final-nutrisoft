@extends('adminlte::page')

@section('title', 'Estadísticas')

@section('content_header')
@stop

@section('content')

    <div class="card card-dark mt-3">
        <div class="card-header">
            <h5>Estadísticas</h5>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-md-10 ">
                    <form action="{{ route('gestion-estadisticas.filtros') }}" method="GET">
                        <label for="fecha_inicio">Fecha de Inicio:</label>
                        <input class="" type="date" name="fecha_inicio"  value="{{ old('fecha_inicio', $fechaInicio) }}">

                        <label for="fecha_fin">Fecha de Fin:</label>
                        <input class="" type="date" name="fecha_fin" value="{{ old('fecha_fin', $fechaFin) }}">

                        <button class="btn btn-primary btn-sm" type="submit">Filtrar</button>

                    </form>
                </div>
                <div class="col-md-2">
                    <form action="{{ route('gestion-estadisticas.clearFilters') }}" method="get">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Borrar Filtros</button>
                    </form>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <canvas id="myChart" style="display:block; width:100%; height:450px;"></canvas>
                </div>
            </div>
        </div>
    </div>


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />

@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.js" integrity="sha512-6HrPqAvK+lZElIZ4mZ64fyxIBTsaX5zAFZg2V/2WT+iKPrFzTzvx6QAsLW2OaLwobhMYBog/+bvmIEEGXi0p1w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script>
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
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
@stop
