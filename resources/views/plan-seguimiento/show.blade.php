@extends('adminlte::page')

@section('title', 'Plan de seguimiento')

@section('content_header')
@stop

@section('content')

    <div class="card card-dark mt-3">
        <div class="card-header" style="text-align: center;">
            <h3>Información del Plan</h3>
        </div>

        <div class="card-body">

            <!-- Tabla con información del Plan -->
            <div class="row mt-3">
                <div class="col-md-12 table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr style="text-align: center;">
                                <th>Fecha generación</th>
                                <th>Profesional</th>
                                <th>Descripción del Plan</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr style="text-align: center;">
                                <td>{{ \Carbon\Carbon::parse($plan->consulta->turno->fecha)->format('d/m/Y')}}</td>
                                <td>{{$plan->consulta->nutricionista->user->apellido}}, {{$plan->consulta->nutricionista->user->name}}</td>
                                <td>{{$plan->descripcion}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- Tabla con información del Paciente -->
            <div class="row mt-3">
                <div class="col-md-12 table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
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
                                <td>{{$plan->paciente->user->apellido}}, {{$plan->paciente->user->name}}</td>
                                <td>{{$plan->consulta->imc_actual}}</td>
                                <td>{{$plan->consulta->peso_actual}} kg</td>
                                <td>{{$plan->consulta->altura_actual}} cm</td>
                                <td>{{$plan->paciente->historiaClinica->objetivo_salud}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-dark">
        <div class="card-header" style="text-align: center;">
            <h3>Plan de Seguimiento</h3>
        </div>

        <div class="card-body">

            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Actividad</th>
                        <th>Tipo de actividad</th>
                        <th>Duración</th>
                        <th>Recursos externos</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($detallesPlan as $detalle)
                        @foreach ($actividadesRecomendadas as $recomendada)
                            @foreach ($tiposActividades as $tipoActividad)
                                @foreach ($actividadesPorTipo as $tipo)
                                    @foreach ($unidadesTiempo as $tiempo)
                                        @if ($detalle->act_rec_id == $recomendada->id && $detalle->actividad_id == $tipo->actividad_id && $detalle->tiempo_realizacion == $recomendada->duracion_actividad && $detalle->unidad_tiempo_realizacion == $tiempo->nombre_unidad_tiempo && $tiempo->id == $recomendada->unidad_tiempo_id && $recomendada->act_tipoAct_id == $tipo->id && $tipoActividad->id == $tipo->tipo_actividad_id)
                                            <tr>
                                                 <!-- Actividad -->
                                                 <td>
                                                    @foreach ($actividades as $actividad)
                                                        @if ($actividad->id == $detalle->actividad_id)
                                                            {{$actividad->actividad}}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <!-- Tipo de actividad -->
                                                <td>
                                                    @foreach ($actividades as $actividad)
                                                        @if ($actividad->id == $detalle->actividad_id && $detalle->actividad_id == $tipo->actividad_id)
                                                            <span class="badge bg-primary">{{$tipoActividad->tipo_actividad}}</span>
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <!-- Duración -->
                                                <td>
                                                    @foreach ($actividades as $actividad)
                                                        @if ($actividad->id == $detalle->actividad_id && $detalle->actividad_id == $tipo->actividad_id)
                                                            {{$detalle->tiempo_realizacion}} {{$detalle->unidad_tiempo_realizacion}}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                 <!-- Recursos externos -->
                                                 <td>
                                                    @foreach ($actividades as $actividad)
                                                        @if ($actividad->id == $detalle->actividad_id)
                                                            {{$detalle->recursos_externos}}
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="4"><p>No hay actividades recomendadas para el plan</p></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">


@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        //Respuestas Flash del controlador con SweetAlert
        @if (session('errorPlanNoEncontrado'))
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: "{{session('errorPlanNoEncontrado')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif

        @if (session('successPlanConfirmado'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{session('successPlanConfirmado')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif

        //Datatable planes a confirmar
        $(document).ready(function(){
            $('#planes-confirmacion').DataTable({
                responsive: true,
                autoWidth: false,
                "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ planes por página",
                    "zeroRecords": "No se encontró ningún plan de alimentación pendiente para su confirmación.",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay planes de alimentación pendientes para su confirmación.",
                    "infoFiltered": "(filtrado de _MAX_ planes totales)",
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

        //Datatable historial de planes
        $(document).ready(function(){
            $('#historial-planes').DataTable({
                responsive: true,
                autoWidth: false,
                "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ planes por página",
                    "zeroRecords": "No se encontró ningún plan de alimentación.",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay planes de alimentación existentes.",
                    "infoFiltered": "(filtrado de _MAX_ planes totales)",
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

         //SweetAlert Confirmar plan
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
