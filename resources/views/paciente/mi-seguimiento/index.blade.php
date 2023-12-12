@extends('adminlte::page')

@section('title', 'Mi seguimiento')

@section('content_header')

@stop

@section('content')

    <div style="padding: 2%;" class="card-header text-white bg-success  mt-3">
        <h3 style="text-align: center;">¡Bienvenido, {{ Auth::user()->name }}!</h3>
        <h5 style="text-align: center;">En este apartado podrá observar su seguimiento y evolución</h5>
    </div>

    <!-- Estado actual -->

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

    <!-- Evolución en el tiempo -->
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

    <!-- Consumo diario -->
    <div class="row mt-3">
        <div class="col-lg-8 col-md-6">
            <div class="card card-dark mt-3">
                <div class="card-header">
                    <h5 class="card-title">Consumo diario</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget = "collapse" title= "collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">

                    <div class="row mt-3">
                        <div class="col-md-10">
                            <h5>Alimentos Consumidos hoy:</h5>
                        </div>

                        <div class="col-auto float-right">
                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addAlimento">Registrar</button>
                        </div>

                    </div>

                    <!-- Modal Nuevo alimento consumido -->
                    <div class="modal fade" id="addAlimento" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addAlimentoLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addAlimentoLabel">Nuevo alimento consumido</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="formAddAlimento" action="{{route('mi-seguimiento.registrarAlimentoConsumido')}}" method="POST">
                                        @csrf

                                        <div class="row mt-3">
                                            <h5>Alimentos recomendados en el plan de alimentación</h5>

                                            <div class="row mt-3">
                                                <table class="table table-striped" id="tabla-alimentos-plan">
                                                    <thead>
                                                        <tr>
                                                            <th>Alimento</th>
                                                            <th>Cantidad</th>
                                                            <th>Seleccionar</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($detallesPlanAlimentacionActivo as $detalle)
                                                            <tr>
                                                                <td>
                                                                    {{ $detalle->alimento->alimento }}
                                                                </td>

                                                                <td>
                                                                    {{ $detalle->cantidad }} {{ $detalle->unidad_medida }}
                                                                </td>
                                                                <td>
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input" type="checkbox" name="alimentosPlan[]" value="{{$detalle->id}}" id="alimentosPlan_{{$detalle->id}}"
                                                                            @if ($alimentosConsumidos->contains('alimento_id', $detalle->alimento_id))
                                                                                checked
                                                                            @endif
                                                                        >
                                                                        <label class="form-check-label" for="alimentosPlan_{{$detalle->id}}">Consumido</label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <h5>Otros alimentos</h5>
                                        <button type="button" class="btn btn-success mt-3" onclick="agregarAlimento()">Agregar Alimento</button>

                                        <!-- Sección para cada Ingrediente -->
                                        <div id="alimentos-section-add" class="row mt-3">
                                            <!-- Los ingredientes seleccionados se agregarán dinámicamente aquí -->
                                        </div>

                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn btn-success add-alimento">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla alimentos -->
                    <div class="row mt-3">
                        <table class="table table-striped mt-3" id="tabla-consumo-hoy">
                            <thead>
                                <tr>
                                    <th>Alimento</th>
                                    <th>Cantidad</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alimentosConsumidos as $alimentoConsumido)
                                    <tr>
                                        <td>
                                            {{ $alimentoConsumido->alimento->alimento }}
                                        </td>

                                        <td>
                                            {{ $alimentoConsumido->cantidad }} {{ $alimentoConsumido->unidad_medida }}
                                        </td>
                                        <td>
                                            <form id="formEliminar" action="{{route('mi-seguimiento.destroy', $alimentoConsumido->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm delete-button"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- kcal consumida -->
        <div class="col-lg-4 col-md-6">
            <div class="card card-dark mt-3">
                <div class="card-header">
                    <h5 class="card-title">Kilocalorías totales consumidas</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget = "collapse" title= "collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-auto" style="margin: auto;" >
                            <div class="medallon medallon-amarillo">
                                {{ $kcal }} kcal <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

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
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>

        function agregarAlimento() {
            // Clonar la sección de ingrediente y agregarla al contenedor
            const alimentoContainer = document.getElementById('alimentos-section-add');
            const nuevoAlimento = document.createElement('div');
            nuevoAlimento.classList.add('row', 'mb-3', 'align-items-center');

            nuevoAlimento.innerHTML = `
                <div class="col-md-4">
                    <div class="form-floating">
                        <select name="alimentos[]" class="form-select" placeholder="Alimento" required>
                            <option value="" selected>Selecciona el alimento</option>
                            @foreach($alimentos as $alimento)
                                <option value="{{$alimento->id}}">{{$alimento->alimento}}</option>
                            @endforeach
                        </select>
                        <label for="alimento">Alimento</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="cantidades[]" placeholder="Cantidad" required>
                        <label for="cantidades">Cantidad</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select" name="unidades_de_medida[]" placeholder="Unidad de medida" required>
                            <option value="" selected>Selecciona la unidad de medida</option>
                            @foreach($unidades_de_medida as $unidad_de_medida)
                                <option value="{{$unidad_de_medida->id}}">{{$unidad_de_medida->nombre_unidad_medida}}</option>
                            @endforeach
                        </select>
                        <label for="unidades_de_medida">Unidad de medida</label>
                    </div>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarAlimento(this)"><i class="bi bi-trash"></i></button>
                </div>
            `;

            alimentoContainer.appendChild(nuevoAlimento);
        }

        function eliminarAlimento(elemento) {
            // Obtener el elemento padre y eliminarlo
            const alimentoContainer = document.getElementById('alimentos-section-add');
            const padre = elemento.parentNode.parentNode; // Dos niveles arriba para llegar al div.row
            alimentoContainer.removeChild(padre);
        }

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

        //Datatable
        $(document).ready(function(){
            $('#tabla-consumo-hoy').DataTable({
                responsive: true,
                autoWidth: false,
                "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_",
                    "zeroRecords": "No se encontró ningún registro",
                    "info": "",
                    "infoEmpty": "No hay registros",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
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

        $(document).ready(function(){
            $('#tabla-alimentos-plan').DataTable({
                responsive: true,
                autoWidth: false,
                "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_",
                    "zeroRecords": "No se encontró ningún registro",
                    "info": "",
                    "infoEmpty": "No hay registros",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
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
                timer: 10000
            })
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: '¡Atención!',
                text: "{{session('error')}}",
                showConfirmButton: false,
                timer: 10000
            })
        @endif

        //SweetAlert para guardar nuevo alimento
        document.addEventListener('DOMContentLoaded', function () {
            const guardarAlimento = document.querySelectorAll('.add-alimento');

            guardarAlimento.forEach(button => {
                button.addEventListener('click', function () {
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: true
                        })

                        swalWithBootstrapButtons.fire({
                        title: '¿Está seguro de guardar el alimento consumido?',
                        text: "Al confirmar se registrará el alimento consumido y calculará las kcal.",
                        icon: 'question',
                        showCancelButton: true,
                        cancelButtonText: '¡No, cancelar!',
                        confirmButtonColor: '#198754',
                        confirmButtonText: '¡Guardar alimento!',
                        cancelButtonColor: '#d33',
                        reverseButtons: true
                        }).then((result) => {
                        if (result.isConfirmed) {
                            //Envia el form
                            const form = document.getElementById('formAddAlimento');
                            form.submit();
                        } else if (
                            /* Read more about handling dismissals below */
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            swalWithBootstrapButtons.fire(
                            '¡No se guardó el alimento!'
                            )
                        }
                    })
                });
            });
        });

         //SweetAlert para guardar nuevo alimento
         document.addEventListener('DOMContentLoaded', function () {
            const eliminarAlimento = document.querySelectorAll('.delete-button');

            eliminarAlimento.forEach(button => {
                button.addEventListener('click', function () {
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: true
                        })

                        swalWithBootstrapButtons.fire({
                        title: '¿Está seguro de eliminar el alimento consumido?',
                        text: "Al confirmar se eliminará el registro del alimento consumido.",
                        icon: 'question',
                        showCancelButton: true,
                        cancelButtonText: '¡No, cancelar!',
                        confirmButtonColor: '#198754',
                        confirmButtonText: '¡Eliminar alimento!',
                        cancelButtonColor: '#d33',
                        reverseButtons: true
                        }).then((result) => {
                        if (result.isConfirmed) {
                            //Envia el form
                            const form = document.getElementById('formEliminar');
                            form.submit();
                        } else if (
                            /* Read more about handling dismissals below */
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            swalWithBootstrapButtons.fire(
                            '¡No se eliminó el alimento!'
                            )
                        }
                    })
                });
            });
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
