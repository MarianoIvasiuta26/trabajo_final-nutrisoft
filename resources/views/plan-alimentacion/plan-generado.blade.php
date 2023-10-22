@extends('adminlte::page')

@section('title', 'Plan de Alimentación')

@section('content_header')

@stop

@section('content')

    <div class="encabezado-plan mt-3">
        <h1>Plan de Alimentación</h1>

        <div class="seccion mt-3">
            <h3>Información del plan</h3>
            <div class="contenido">
                <div class="row mt-3">
                    <div class="col-md-6">
                        <h5>Fecha de generación: </h5> <p class="ms-2">{{$turno->fecha}}</p>
                    </div>

                    <div class="col-md-6">
                        <h5>Hora de consulta: </h5> <p class="ms-2">{{$turno->hora}}</p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <h5>Paciente: </h5> <p class="ms-2">{{$paciente->user->apellido}}, {{$paciente->user->name}}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Profesional: </h5> <p class="ms-2">{{$nutricionista->user->apellido}}, {{$nutricionista->user->name}}</p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-3">
                        <h5>IMC: </h5> <p class="ms-2">{{$turno->consulta->imc_actual}}</p>
                    </div>
                    <div class="col-md-3">
                        <h5>Peso actual: </h5> <p class="ms-2">{{$turno->consulta->peso_actual}} kg</p>
                    </div>
                    <div class="col-md-3">
                        <h5>Altura actual: </h5> <p class="ms-2">{{$turno->consulta->altura_actual}} cm</p>
                    </div>

                    <div class="col-md-3">
                        <h5>Objetivo de salud: </h5> <p class="ms-2">{{$paciente->historiaClinica->objetivo_salud}}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="info-plan mt-3">
        <div class="seccion mt-3">
            <h3>Plan de Alimentación</h3>
            <div class="contenido">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <h5>Desayuno</h5>
                    </div>
                    <div class="col-md-12">
                        @forelse ($detallesPlan as $detallePlan)
                            @foreach ($alimentos as $alimento)
                                @if ($detallePlan->horario_consumicion == 'Desayuno' && $detallePlan->alimento_id == $alimento->id)
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <h5>Alimento: </h5> <p class="ms-2">{{$alimento->alimento}}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Cantidad: </h5> <p class="ms-2">{{$detallePlan->cantidad}}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Unidad de medida: </h5> <p class="ms-2">{{$detallePlan->unidad_medida}}</p>
                                        </div>
                                        <div class="col-md-12">
                                            <h5>Observaciones: </h5> <p class="ms-2">{{$detallePlan->observaciones}}</p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @empty
                            <p>No hay alimentos asignados para este horario</p>
                        @endforelse
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <h5>Media mañana</h5>
                    </div>
                    <div class="col-md-12">
                        @forelse ($detallesPlan as $detallePlan)
                            @foreach ($alimentos as $alimento)
                                @if ($detallePlan->horario_consumicion == 'Media maniana' && $detallePlan->alimento_id == $alimento->id)
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <h5>Alimento: </h5> <p class="ms-2">{{$alimento->alimento}}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Cantidad: </h5> <p class="ms-2">{{$detallePlan->cantidad}}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Unidad de medida: </h5> <p class="ms-2">{{$detallePlan->unidad_medida}}</p>
                                        </div>
                                        <div class="col-md-12">
                                            <h5>Observaciones: </h5> <p class="ms-2">{{$detallePlan->observaciones}}</p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @empty
                            <p>No hay alimentos asignados para este horario</p>
                        @endforelse
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <h5>Almuerzo</h5>
                    </div>
                    <div class="col-md-12">
                        @forelse ($detallesPlan as $detallePlan)
                            @foreach ($alimentos as $alimento)
                                @if ($detallePlan->horario_consumicion == 'Almuerzo' && $detallePlan->alimento_id == $alimento->id)
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <h5>Alimento: </h5> <p class="ms-2">{{$alimento->alimento}}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Cantidad: </h5> <p class="ms-2">{{$detallePlan->cantidad}}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Unidad de medida: </h5> <p class="ms-2">{{$detallePlan->unidad_medida}}</p>
                                        </div>
                                        <div class="col-md-12">
                                            <h5>Observaciones: </h5> <p class="ms-2">{{$detallePlan->observaciones}}</p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @empty
                            <p>No hay alimentos asignados para este horario</p>
                        @endforelse
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <h5>Media tarde</h5>
                    </div>
                    <div class="col-md-12">
                        @forelse ($detallesPlan as $detallePlan)
                            @foreach ($alimentos as $alimento)
                                @if ($detallePlan->horario_consumicion == 'Media tarde' && $detallePlan->alimento_id == $alimento->id)
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <h5>Alimento: </h5> <p class="ms-2">{{$detallePlan->alimento->alimento}}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Cantidad: </h5> <p class="ms-2">{{$detallePlan->cantidad}}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Unidad de medida: </h5> <p class="ms-2">{{$detallePlan->unidad_medida}}</p>
                                        </div>
                                        <div class="col-md-12">
                                            <h5>Observaciones: </h5> <p class="ms-2">{{$detallePlan->observaciones}}</p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @empty
                            <p>No hay alimentos asignados para este horario</p>
                        @endforelse
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <h5>Cena</h5>
                    </div>
                    <div class="col-md-12">
                        @forelse ($detallesPlan as $detallePlan)
                            @foreach ($alimentos as $alimento)
                                @if ($detallePlan->horario_consumicion == 'Cena' && $detallePlan->alimento_id == $alimento->id)
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <h5>Alimento: </h5> <p class="ms-2">{{$detallePlan->alimento->alimento}}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Cantidad: </h5> <p class="ms-2">{{$detallePlan->cantidad}}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Unidad de medida: </h5> <p class="ms-2">{{$detallePlan->unidad_medida}}</p>
                                        </div>
                                        <div class="col-md-12">
                                            <h5>Observaciones: </h5> <p class="ms-2">{{$detallePlan->observaciones}}</p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @empty
                            <p>No hay alimentos asignados para este horario</p>
                        @endforelse
                    </div>
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
    <style>
        .seccion {
            border: 1px solid #ccc;
            padding: 0;
            margin: 10px 0;
        }

        .seccion h3 {
            background-color: #f2f2f2;
            padding: 5px;
            margin: 0;
            border-bottom: 1px solid #ccc; /* Línea que separa el título del contenido */
            text-align: center; /* Centra el título */
        }

        .seccion .contenido {
            padding: 10px;
        }

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
    <script> console.log('Hi!'); </script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>

//Respuestas Flash del controlador con SweetAlert
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

        $(document).ready(function() {
            $('[data-bs-toggle="popover"]').popover();
        });

        $(document).ready(function(){
            var table = $('#tabla-mis-turnos').DataTable({
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
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const cancelarButtons = document.querySelectorAll('.cancelar-turno-button');

            cancelarButtons.forEach(button => {
                button.addEventListener('click', function () {
                    Swal.fire({
                        title: '¿Estás seguro de cancelar el turno?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, cancelar turno'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            //Envia el form
                            const form = this.closest('form');
                            form.submit();
                        }
                    })
                });
            });
        });
    </script>
@stop
