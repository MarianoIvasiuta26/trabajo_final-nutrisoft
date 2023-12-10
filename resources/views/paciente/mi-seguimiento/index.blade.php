@extends('adminlte::page')

@section('title', 'Mi seguimiento')

@section('content_header')

@stop

@section('content')

    <div style="padding: 2%;" class="card-header text-white bg-success  mt-3">
        <h3 style="text-align: center;">¡Bienvenido, {{ Auth::user()->name }}!</h3>
        <h5 style="text-align: center;">En este apartado podrá observar su seguimiento y evolución</h5>
    </div>

    <div class="card card-dark mt-3">
        <div class="card-header">
            <h5 class="card-title">Estado Actual</h5>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget = "collapse" title= "collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-auto" style="margin: auto;" >
                    <div class="medallon {{$diagnostico == 'Bajo peso' ? 'medallon-amarillo' : ($diagnostico == 'Peso saludable' ? 'medallon-verde' : 'medallon-rojo') }}">
                        {{ $planSeguimientoActivo->consulta->peso_actual }} kg <br>
                        {{ $diagnostico }}
                    </div>
                    <div class="mt-3">
                        <h5 style="text-align: center;">Peso actual</h5>
                    </div>
                </div>

                <div class="col-auto" style="margin: auto;" >
                    <div class="medallon medallon-verde">
                        {{ $planSeguimientoActivo->consulta->altura_actual }} cm
                    </div>
                    <div class="mt-3">
                        <h5 style="text-align: center;">Altura actual</h5>
                    </div>
                </div>

                <div class="col-auto" style="margin: auto;">
                    <div class="medallon {{$estadoIMC == 'Bajo' ? 'medallon-amarillo' : ($estadoIMC == 'Normal' ? 'medallon-verde' : 'medallon-rojo')}}">
                        {{ $planSeguimientoActivo->consulta->imc_actual }} <br>
                        {{ $estadoIMC }}
                    </div>
                    <div class="mt-3">
                        <h5 style="text-align: center;">IMC actual</h5>
                    </div>
                </div>

                <div class="col-auto" style="margin: auto;">
                    <div class="medallon medallon-amarillo">
                        {{ $pesoIdeal }} kg
                    </div>
                    <div class="mt-3">
                        <h5 style="text-align: center;">Peso ideal</h5>
                    </div>
                </div>

            </div>


{{--
            <div class="row mt-3">
                <div style="width: 300px; margin: auto;">
                    <canvas id="estadoActualPeso"></canvas>
                </div>

                <div style="width: 300px; margin: auto;">
                    <canvas id="estadoActualAltura"></canvas>
                </div>

                <div style="width: 300px; margin: auto;">
                    <canvas id="estadoActualImc"></canvas>
                </div>
            </div>
--}}
        </div>

    </div>

    <div class="card card-dark mt-3">
        <div class="card-header">
            <h5 class="card-title">Evolución en el tiempo</h5>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget = "collapse" title= "collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <canvas id="graficoLinea" style="display: inline-block;"></canvas>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        /* Estilos generales para el contenedor */
        .medallon {
            width: 200px;
            height: 200px;
            background-color: #3498db;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: bold;
            font-size: 18px;
            text-align: center;
            cursor: pointer;
        }

        .medallon:hover {
            transform: scale(1.1);
        }

        /* Estilos adicionales para diferentes medallones */
        .medallon-verde {
            background-color: #27ae60;
        }

        .medallon-amarillo {
            background-color: #f39c12;
        }

        .medallon-rojo {
            background-color: #e74c3c;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.js" integrity="sha512-6HrPqAvK+lZElIZ4mZ64fyxIBTsaX5zAFZg2V/2WT+iKPrFzTzvx6QAsLW2OaLwobhMYBog/+bvmIEEGXi0p1w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>

    var ctx = document.getElementById('graficoLinea').getContext('2d');

    var data = {
        labels: {!! json_encode($fechas) !!},
        datasets: [{
            label: 'Evolución del Peso',
            data: {!! json_encode($pesos) !!},
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 2,
            fill: true
        }]
    };

    var options = {
        scales: {
            x: {
                type: 'category',
                position: 'bottom'
            },
            y: {
                beginAtZero: true,
                stepSize: 10 // Establecer el tamaño del paso en el eje y
            }
        },
        responsive: true,
    };

    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: options
    });


    /*
        // Configuración de datos del gráfico de estado actual
        var data1 = {
            labels: ['Peso'],
            datasets: [{
                data: [{{ $planSeguimientoActivo->consulta->peso_actual }}],
                backgroundColor: ['#FF6384'],
                borderWidth: 0
            }],

        };

        var data2 = {
            labels: ['Altura'],
            datasets: [{
                data: [{{ $planSeguimientoActivo->consulta->altura_actual }}],
                backgroundColor: ['#36A2EB'],
                borderWidth: 0
            }],
            hoverOffset: 4
        };

        var data3 = {
            labels: ['IMC'],
            datasets: [{
                data: [{{ $planSeguimientoActivo->consulta->imc_actual }}],
                backgroundColor: ['#FFCE56'],
                borderWidth: 0
            }]
        };

        // Crear el gráfico
        var ctx1 = document.getElementById('estadoActualPeso').getContext('2d');
        var myDoughnutChart = new Chart(ctx1, {
            type: 'doughnut',
            data: data1,
        });

        var ctx2 = document.getElementById('estadoActualAltura').getContext('2d');
        var myDoughnutChart = new Chart(ctx2, {
            type: 'doughnut',
            data: data2,
        });

        var ctx3 = document.getElementById('estadoActualImc').getContext('2d');
        var myDoughnutChart = new Chart(ctx3, {
            type: 'doughnut',
            data: data3,
            options: {
                responsive: true,
            },
        });

    */
    </script>
@stop
