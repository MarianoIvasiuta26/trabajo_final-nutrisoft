@extends('adminlte::page')

@section('title', 'Plan de Alimentación')

@section('content_header')

@stop

@section('content')

    <div class="card card-dark mt-3">
        <div class="card-header" style="text-align: center;">
            <h3>Información del Plan</h3>
        </div>

        <div class="card-body">
            <div class="row mt-3">

                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead>
                            <tr style="text-align: center;">
                                <th>Fecha generación</th>
                                <th>Hora de Consulta</th>
                                <th>Profesional</th>
                                <th>Descripción del Plan</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr style="text-align: center;">
                                <td>{{ \Carbon\Carbon::parse($turno->fecha)->format('d/m/Y')}}</td>
                                <td>{{ \Carbon\Carbon::parse($turno->hora)->format('H:i')}}</td>
                                <td>{{$nutricionista->user->apellido}}, {{$nutricionista->user->name}}</td>
                                <td>{{$planGenerado->descripcion}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>



            <div class="row mt-3">

                <table class="table table-striped">
                    <thead>
                        <tr style="text-align: center;">
                            <th>Paciente</th>
                            <th>IMC</th>
                            <th>Peso actual</th>
                            <th>Altura actual</th>
                            <th>Objetivo de salud</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr style="text-align: center;">
                            <td>{{$paciente->user->apellido}}, {{$paciente->user->name}}</td>
                            <td>{{$turno->consulta->imc_actual}}</td>
                            <td>{{$turno->consulta->peso_actual}} kg</td>
                            <td>{{$turno->consulta->altura_actual}} cm</td>
                            <td>{{$paciente->historiaClinica->objetivo_salud}}</td>
                        </tr>
                    </tbody>
                </table>


            </div>
        </div>
        </div>
    </div>

    <div class="card card-dark">
        <div class="card-header" style="text-align: center;">
            <h3>Plan de Alimentación</h3>
        </div>

        <div class="card-body">
            <div class="row mt-3">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead>
                            <tr style="text-align: center;">
                                <th colspan="5"><h5>Desayuno</h5></th>
                            </tr>
                            <tr>
                                <th>Alimento</th>
                                <th>Cantidad</th>
                                <th>Unidad de medida</th>
                                <th>Observaciones</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($detallesPlan as $detallePlan)
                                @foreach ($alimentos as $alimento)
                                    @if ($detallePlan->horario_consumicion == 'Desayuno' && $detallePlan->alimento_id == $alimento->id)
                                        <tr>
                                            <td>{{$alimento->alimento}}</td>
                                            <td>{{$detallePlan->cantidad}}</td>
                                            <td>{{$detallePlan->unidad_medida}}</td>
                                            <td>{{$detallePlan->observaciones}}</td>
                                            <td>
                                                <form action="#" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="4"><p>No hay alimentos asignados para este horario</p></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead>
                            <tr style="text-align: center;">
                                <th colspan="5"><h5>Media mañana</h5></th>
                            </tr>
                            <tr>
                                <th>Alimento</th>
                                <th>Cantidad</th>
                                <th>Unidad de medida</th>
                                <th>Observaciones</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($detallesPlan as $detallePlan)
                                @foreach ($alimentos as $alimento)
                                    @if ($detallePlan->horario_consumicion == 'Media mañana' && $detallePlan->alimento_id == $alimento->id)
                                        <tr>
                                            <td>{{$alimento->alimento}}</td>
                                            <td>{{$detallePlan->cantidad}}</td>
                                            <td>{{$detallePlan->unidad_medida}}</td>
                                            <td>{{$detallePlan->observaciones}}</td>
                                            <td>
                                                <form action="#" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="4"><p>No hay alimentos asignados para este horario</p></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">

                    <table class="table table-striped">
                        <thead>
                            <tr style="text-align: center;">
                                <th colspan="5"><h5>Almuerzo</h5></th>
                            </tr>
                            <tr>
                                <th>Alimento</th>
                                <th>Cantidad</th>
                                <th>Unidad de medida</th>
                                <th>Observaciones</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($detallesPlan as $detallePlan)
                                @foreach ($alimentos as $alimento)
                                    @if ($detallePlan->horario_consumicion == 'Almuerzo' && $detallePlan->alimento_id == $alimento->id)
                                        <tr>
                                            <td>{{$alimento->alimento}}</td>
                                            <td>{{$detallePlan->cantidad}}</td>
                                            <td>{{$detallePlan->unidad_medida}}</td>
                                            <td>{{$detallePlan->observaciones}}</td>
                                            <td>
                                                <form action="#" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="4"><p>No hay alimentos asignados para este horario</p></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead>
                            <tr style="text-align: center;">
                                <th colspan="5"><h5>Merienda</h5></th>
                            </tr>
                            <tr>
                                <th>Alimento</th>
                                <th>Cantidad</th>
                                <th>Unidad de medida</th>
                                <th>Observaciones</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($detallesPlan as $detallePlan)
                                @foreach ($alimentos as $alimento)
                                    @if ($detallePlan->horario_consumicion == 'Merienda' && $detallePlan->alimento_id == $alimento->id)
                                        <tr>
                                            <td>{{$alimento->alimento}}</td>
                                            <td>{{$detallePlan->cantidad}}</td>
                                            <td>{{$detallePlan->unidad_medida}}</td>
                                            <td>{{$detallePlan->observaciones}}</td>
                                            <td>
                                                <form action="#" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="4"><p>No hay alimentos asignados para este horario</p></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">

                    <table class="table table-striped">
                        <thead>
                            <tr style="text-align: center;">
                                <th colspan="5"><h5>Cena</h5></th>
                            </tr>
                            <tr>
                                <th>Alimento</th>
                                <th>Cantidad</th>
                                <th>Unidad de medida</th>
                                <th>Observaciones</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($detallesPlan as $detallePlan)
                                @foreach ($alimentos as $alimento)
                                    @if ($detallePlan->horario_consumicion == 'Cena' && $detallePlan->alimento_id == $alimento->id)
                                        <tr>
                                            <td>{{$alimento->alimento}}</td>
                                            <td>{{$detallePlan->cantidad}}</td>
                                            <td>{{$detallePlan->unidad_medida}}</td>
                                            <td>{{$detallePlan->observaciones}}</td>
                                            <td>
                                                <form action="#" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @empty
                                <p>No hay alimentos asignados para este horario</p>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="float-right">
                <div class="row">
                    <div class="col-md-12">
                        <form id="confirmar-form" action="" method="POST" class="d-inline-block">
                            @csrf
                            <button class="btn btn-success confirmar-button" type="button">Confirmar Plan</button>
                        </form>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            const confirmarPlan = document.querySelectorAll('.confirmar-button');

            confirmarPlan.forEach(button => {
                button.addEventListener('click', function () {
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: true
                        })

                        swalWithBootstrapButtons.fire({
                        title: '¿Está seguro de guardar el plan de alimentación generado?',
                        text: "Al confirmar se asociará el plan al paciente correspondiente.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: '¡Confirmar plan!',
                        confirmButtonColor: '#3085d6',
                        cancelButtonText: '¡No, cancelar!',
                        cancelButtonColor: '#d33',
                        reverseButtons: true
                        }).then((result) => {
                        if (result.isConfirmed) {
                            //Envia el form
                            const form = document.getElementById('confirmar-form');
                            form.submit();
                        } else if (
                            /* Read more about handling dismissals below */
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            swalWithBootstrapButtons.fire(
                            '¡No se guardó el plan de alimentación!',
                            'El plan aún no se asoció al paciente, puede realizar modificaciones en el mismo.',
                            'error'
                            )
                        }
                    })
                });
            });
        });
    </script>
@stop
