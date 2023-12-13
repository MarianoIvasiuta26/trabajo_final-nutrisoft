@extends('adminlte::page')

@section('title', 'Plan de Seguimiento')

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
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr style="text-align: center;">
                                <th>Fecha generación</th>
                                <th>Profesional</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr style="text-align: center;">
                                <td>{{ \Carbon\Carbon::parse($turno->fecha)->format('d/m/Y')}}</td>
                                <td>{{$nutricionista->user->apellido}}, {{$nutricionista->user->name}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- Tabla con información del Paciente -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <table class="table table-striped">
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
            <h3>Plan de Seguimiento</h3>
        </div>

        <div class="card-body">

            <!-- Tabla con información de las actividades -->

            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-success btn-sm add-button" data-bs-toggle="modal" data-bs-target="#add">
                        <i class="bi bi-plus-circle"></i> Agregar actividad
                    </button>
                    <table class="table table-striped mt-2">
                        <thead class="table-dark">
                            <tr style="text-align: center;">
                                <th>Actividad</th>
                                <th>Tipo de actividad</th>
                                <th>Duración</th>
                                <th>Recursos externos</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($detallesPlan as $detalle)
                                @foreach ($actividadesRecomendadas as $recomendada)
                                    @foreach ($tiposActividades as $tipoActividad)
                                        @foreach ($actividadesPorTipo as $tipo)
                                            @foreach ($unidadesTiempo as $tiempo)
                                                @if ($detalle->act_rec_id == $recomendada->id)
                                                    @if ($detalle->actividad_id == $tipo->actividad_id && $detalle->tiempo_realizacion == $recomendada->duracion_actividad && $detalle->unidad_tiempo_realizacion == $tiempo->nombre_unidad_tiempo && $tiempo->id == $recomendada->unidad_tiempo_id && $recomendada->act_tipoAct_id == $tipo->id && $tipoActividad->id == $tipo->tipo_actividad_id)
                                                        <tr style="text-align: center;">
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
                                                            <!-- Acciones -->
                                                            <td>
                                                                <div>
                                                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit_{{$detalle->id}}">
                                                                        <span class="far fa-edit"></span>
                                                                    </button>
                                                                    <form action="{{route('plan-seguimiento.destroy', $detalle->id)}}" method="POST" style="display: inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="button" class="btn btn-danger delete-button">
                                                                            <span class="far fa-trash-alt"></span>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <!-- Modal Edit-->
                                                        <div class="modal fade" id="edit_{{$detalle->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="edit_{{$detalle->id}}Label" aria-hidden="true">
                                                            <div class="modal-dialog modal-xl">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="edit_{{$detalle->id}}Label">
                                                                            Editar actividad del plan de seguimiento
                                                                        </h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form id="editForm" action="{{route('plan-seguimiento.update', $detalle->id)}}" method="POST">
                                                                            @csrf
                                                                            @method('PUT')

                                                                            <div class="row">
                                                                                <div class="col-md-4">
                                                                                    <label for="actividad">Actividad</label>
                                                                                    <select id="actividadSelect" class="form-select" name="actividad">
                                                                                        <option value="" disabled>Seleccione una actividad</option>
                                                                                        @foreach ($actividades as $actividad)
                                                                                            @foreach ($detallesPlan as $detallePlan)
                                                                                                @if ($detalle->id == $detallePlan->id)
                                                                                                    @if ($detallePlan->actividad_id == $actividad->id)
                                                                                                        <option value="{{$actividad->id}}" selected>{{$actividad->actividad}}</option>
                                                                                                    @else
                                                                                                        <option value="{{$actividad->id}}">{{$actividad->actividad}}</option>
                                                                                                    @endif
                                                                                                @endif
                                                                                            @endforeach
                                                                                        @endforeach
                                                                                    </select>
                                                                                    @error('actividad')
                                                                                        <small class="text-danger">{{$message}}</small>
                                                                                    @enderror
                                                                                </div>

                                                                                <div class="col-md-4">
                                                                                    <label for="duracion">Duración</label>
                                                                                    <input type="text" id="duracionInput" class="form-control" name="duracion" value="{{$detalle->tiempo_realizacion}}">
                                                                                    @error('duracion')
                                                                                        <small class="text-danger">{{$message}}</small>
                                                                                    @enderror
                                                                                </div>

                                                                                <div class="col-md-4">
                                                                                    <label for="unidad_tiempo">Unidad de tiempo</label>
                                                                                    <select class="form-select" name="unidad_tiempo" id="">
                                                                                        <option value="" disabled>Seleccione la unidad de medida</option>
                                                                                        @foreach ($unidadesTiempo as $unidad)
                                                                                            @foreach ($detallesPlan as $detallePlan)
                                                                                                @if ($detalle->id == $detallePlan->id && $unidad->nombre_unidad_tiempo != 'Sin unidad de tiempo')
                                                                                                    @if ($detallePlan->unidad_tiempo_realizacion == $unidad->nombre_unidad_tiempo)
                                                                                                        <option value="{{$unidad->nombre_unidad_tiempo}}" selected>{{$unidad->nombre_unidad_tiempo}}</option>
                                                                                                    @else
                                                                                                        <option value="{{$unidad->nombre_unidad_tiempo}}">{{$unidad->nombre_unidad_tiempo}}</option>
                                                                                                    @endif
                                                                                                @endif
                                                                                            @endforeach
                                                                                        @endforeach
                                                                                    </select>

                                                                                    @error('unidad_tiempo')
                                                                                        <small class="text-danger">{{$message}}</small>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>

                                                                            <div class="row mt-3">
                                                                                <div class="col-md-12">
                                                                                    <label for="recursos_externos">Recursos externos</label>
                                                                                    <textarea class="form-control" name="recursos_externos" id="" cols="10" rows="5">{{$detalle->recursos_externos}}</textarea>
                                                                                    @error('recursos_externos')
                                                                                        <small class="text-danger">{{$message}}</small>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>

                                                                            <div class="row mt-3 float-right">
                                                                                <div class="col">
                                                                                    <button type="submit" class="btn btn-success">Guardar cambios</button>
                                                                                </div>
                                                                            </div>

                                                                        </form>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    @endif
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center;">
                                        <h5>No hay actividades agregadas al plan de seguimiento</h5>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="float-right">
                <div class="row">
                    <div class="col-md-12">
                        <form id="confirmar-form" action="{{route('plan-seguimiento.confirmarPlan', $planSeguimientoGenerado->id)}}" method="POST" class="d-inline-block">
                            @csrf
                            <button class="btn btn-success confirmar-button" type="button">Confirmar Plan</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="float-left">
                <div class="row">
                    <div class="col">
                        <a href="{{ route('plan-seguimiento.pdf', $planSeguimientoGenerado->id) }}" target="_blank" class="btn btn-secondary">
                            <i class="bi bi-printer"></i>
                            Imprimir
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal Add-->

    <div class="modal fade" id="add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="add" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLabel">
                        Agregar actividad al plan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm" action="{{route('plan-seguimiento.store')}}" method="POST">
                        @csrf

                        <input type="hidden" name="plan_id" value="{{$planSeguimientoGenerado->id}}">

                        <div class="row">
                           <div class="col-md-12">
                                <table class="table table-striped">
                                    <thead>
                                        <th>Actividad</th>
                                        <th>Tipo de actividad</th>
                                        <th>Duración</th>
                                        <th>Agregar</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($actividadesRecomendadas as $recomendada)
                                            <tr>
                                                <th>
                                                    @foreach ($actividades as $actividad)
                                                        @foreach ($tiposActividades as $tipo)
                                                            @foreach ($actividadesPorTipo as $porTipo)
                                                                @if ($porTipo->actividad_id == $actividad->id)
                                                                    @if ($porTipo->tipo_actividad_id == $tipo->id)
                                                                        @if ($recomendada->act_tipoAct_id == $porTipo->id)
                                                                            {{$actividad->actividad}}
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    @endforeach
                                                </th>

                                                <th>
                                                    @foreach ($actividades as $actividad)
                                                        @foreach ($tiposActividades as $tipo)
                                                            @foreach ($actividadesPorTipo as $porTipo)
                                                                @if ($porTipo->actividad_id == $actividad->id)
                                                                    @if ($porTipo->tipo_actividad_id == $tipo->id)
                                                                        @if ($recomendada->act_tipoAct_id == $porTipo->id)
                                                                            {{$tipo->tipo_actividad}}
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    @endforeach
                                                </th>

                                                <th>
                                                    @foreach ($actividades as $actividad)
                                                        @foreach ($tiposActividades as $tipo)
                                                            @foreach ($actividadesPorTipo as $porTipo)
                                                                @if ($porTipo->actividad_id == $actividad->id)
                                                                    @if ($porTipo->tipo_actividad_id == $tipo->id)
                                                                        @if ($recomendada->act_tipoAct_id == $porTipo->id)
                                                                            @foreach ($unidadesTiempo as $tiempo)
                                                                                @if ($tiempo->id == $recomendada->unidad_tiempo_id)
                                                                                    {{$recomendada->duracion_actividad}} {{$tiempo->nombre_unidad_tiempo}}
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    @endforeach
                                                </th>

                                                <th>
                                                    @foreach ($actividades as $actividad)
                                                        @foreach ($tiposActividades as $tipo)
                                                            @foreach ($actividadesPorTipo as $porTipo)
                                                                @if ($porTipo->actividad_id == $actividad->id)
                                                                    @if ($porTipo->tipo_actividad_id == $tipo->id)
                                                                        @if ($recomendada->act_tipoAct_id == $porTipo->id)
                                                                            <div class="form-check form-switch">
                                                                                <input class="form-check-input" type="checkbox" id="actividad{{$recomendada->id}}" name="actividades_seleccionadas[]" value="{{$recomendada->id}}"
                                                                                    @foreach ($detallesPlan as $detalle)
                                                                                        @foreach ($unidadesTiempo as $tiempo)
                                                                                            @if($detalle->act_rec_id == $recomendada->id && $detalle->actividad_id == $actividad->id && $tiempo->id == $recomendada->unidad_tiempo_id
                                                                                                && $tiempo->nombre_unidad_tiempo == $detalle->unidad_tiempo_realizacion || $detalle->actividad_id == $actividad->id)

                                                                                            checked

                                                                                            @endif
                                                                                        @endforeach
                                                                                    @endforeach
                                                                                >
                                                                                <label class="form-check-label" for="actividad{{$recomendada->id}}"></label>
                                                                            </div>
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    @endforeach
                                                </th>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                           </div>

                        </div>

                        <div class="row mt-3 float-right">
                            <div class="col">
                                <button type="submit" class="btn btn-success add-button">Guardar cambios</button>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
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
        @if (session('errorPlanNoEncontrado'))
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: "{{session('errorPlanNoEncontrado')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif

        @if (session('errorActividadYaAgregada'))
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: "{{session('errorActividadYaAgregada')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif

        @if (session('successActividadAgregada'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{session('successActividadAgregada')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif

        @if (session('successActividadActualizada'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{session('successActividadActualizada')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif

        @if (session('errorActividadNoEncontrada'))
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: "{{session('errorActividadNoEncontrada')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif

        @if (session('successActividadEliminada'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{session('successActividadEliminada')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif

        @if (session('info'))
            Swal.fire({
                icon: 'info',
                title: '¡Atención!',
                text: "{{ session('info') }}",
                showCancelButton: true,
                confirmButtonText: 'Agregar actividad',
                cancelButtonText: 'No agregar',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Enviar solicitud Ajax para guardar igualmente
                    fetch('{{ route('plan-seguimiento.guardarDetalle', ['planId' => session('planId'), 'actRecomendadaId' => session('actRecomendadaId'), 'estadoIMC'=>session('estadoIMC'), 'pesoIdeal'=>session('pesoIdeal')]) }}/' + accion, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            planId: '{{ session('planId') }}',
                            actRecomendadaId: '{{ session('actRecomendadaId') }}',
                            estadoIMC: '{{session('estadoIMC')}}',
                            pesoIdeal: '{{session('pesoIdeal')}}'
                        })
                    }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: data.success
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else if (data.error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.error
                                }).then(() => {
                                    window.location.reload();
                                });
                            }
                    }).catch(error => {
                        // Manejar errores de red o excepciones
                        console.error('Error:', error);
                    });
                }
            });
        @endif


        //SweetAlert Eliminar actividad
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: true
        })

        document.addEventListener('DOMContentLoaded', function () {
            // Selecciona todos los botones de eliminar con la clase 'delete-button'
            const deleteButtons = document.querySelectorAll('.delete-button');

            // Agrega un controlador de clic a cada botón de eliminar
            deleteButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    // Muestra un SweetAlert de confirmación
                    swalWithBootstrapButtons.fire({
                        title: '¿Estás seguro de eliminar la actividad del plan?',
                        text: 'Esta acción eliminará la actividad del plan de seguimiento.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, eliminar',
                        confirmButtonColor: '#198754',
                        cancelButtonText: 'Cancelar',
                        cancelButtonColor: '#d33',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Si el usuario confirma, envía el formulario
                            button.closest('form').submit();
                        }
                    });
                });
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
                            title: '¿Está seguro de guardar el plan de seguimiento generado?',
                            text: "Al confirmar se asociará el plan al paciente correspondiente.",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: '¡Confirmar plan!',
                            confirmButtonColor: '#198754',
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
                            '¡No se guardó el plan de seguimiento!',
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
