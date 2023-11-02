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

            <!-- Tabla con información del Plan -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr style="text-align: center;">
                                <th>Fecha generación</th>
                                <th>Profesional</th>
                                <th>Descripción del Plan</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr style="text-align: center;">
                                <td>{{ \Carbon\Carbon::parse($turno->fecha)->format('d/m/Y')}}</td>
                                <td>{{$nutricionista->user->apellido}}, {{$nutricionista->user->name}}</td>
                                <td>{{$planGenerado->descripcion}}</td>
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

            <!-- Tabla con más información del Paciente -->
            <div class="row mt-3">
                <div class="accordion accordion-flush-success" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                <strong>Más Datos del Paciente</strong>
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <!-- Tabla de historia clínica -->
                                <table class="table table-striped">
                                    <thead class="table-dark">
                                        <tr style="text-align: center;">
                                            <th colspan="4"><h5>Historia Clínica</h5></th>
                                        </tr>
                                        <tr style="text-align: center;" class="table-info table-active">
                                            <th>Alergias</th>
                                            <th>Patologías</th>
                                            <th>Cirugías</th>
                                            <th>Intolerancias</th>
                                        </tr>

                                    </thead>

                                    <tbody>
                                        @forelse ($datosMedicos as $datoMedico)
                                            <tr style="text-align: center;">
                                                <td>
                                                    @foreach ($alergias as $alergia)
                                                        @if ($alergia->id == $datoMedico->alergia_id)
                                                            {{ $alergia->alergia }}
                                                        @endif
                                                    @endforeach
                                                </td>

                                                <td>
                                                    @foreach ($patologias as $patologia)
                                                        @if ($patologia->id == $datoMedico->patologia_id)
                                                            {{ $patologia->patologia}}
                                                        @endif
                                                    @endforeach
                                                </td>

                                                <td>
                                                    @foreach ($intolerancias as $intolerancia)
                                                        @if ($intolerancia->id == $datoMedico->intolerancia_id)
                                                            {{ $intolerancia->intolerancia}}
                                                        @endif
                                                    @endforeach
                                                </td>

                                                <td>
                                                    @foreach ($cirugias as $cirugia)
                                                        @forelse ($cirugiasPaciente as $cirugiaPaciente)
                                                            @if ($cirugia->id == $cirugiaPaciente->cirugia_id)
                                                                {{$cirugia->cirugia}}
                                                            @endif
                                                        @empty
                                                            <span class="text-danger">No se registraron cirugías</span>
                                                        @endforelse
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td>
                                                    <span class="text-danger">No se registraron datos médicos</span>
                                                </td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>

                                <!-- Tabla de anamnesis -->
                                <table class="table table-striped mt-3">
                                    <thead class="table-dark table-striped">
                                        <tr style="text-align: center;">
                                            <th colspan="4"><h5>Gustos Alimenticios</h5></th>
                                        </tr>
                                        <tr style="text-align: center;" class="table-info  table-active">
                                            <th>Gustos</th>
                                            <th></th>
                                            <th>Disgustos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="text-align: center;">
                                            <td>
                                                @forelse ($anamnesisPaciente as $anamnesis)
                                                    @if ($anamnesis->gusta == 1)
                                                        @foreach ($alimentos as $alimento)
                                                            @if ($anamnesis->alimento_id == $alimento->id)
                                                                {{ $alimento->alimento }} <br>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @empty
                                                    <span class="text-danger">No se registraron gustos</span>
                                                @endforelse
                                            </td>
                                            <td></td>
                                            <td>
                                                @forelse ($anamnesisPaciente as $anamnesis)
                                                    @if ($anamnesis->gusta == 0)
                                                        @foreach ($alimentos as $alimento)
                                                            @if ($anamnesis->alimento_id == $alimento->id)
                                                                {{ $alimento->alimento }} <br>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @empty
                                                    <span class="text-danger">No se registraron disgustos</span>
                                                @endforelse
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="card card-dark">
        <div class="card-header" style="text-align: center;">
            <h3>Plan de Alimentación</h3>
        </div>

        <div class="card-body">

            @foreach($comidas as $comida)
                @if ($comida->nombre_comida != 'Sin comida')
                    <div class="row mt-3">
                        <div class="col-md-12 table-responsive">
                            <h5>
                                @if ($comida->nombre_comida == 'Media maniana')
                                    Media mañana
                                    <button type="button" class="btn btn-success btn-sm add-button" data-bs-toggle="modal" data-bs-target="#add{{$comida->id}}">
                                        <i class="bi bi-plus-circle"></i> Agregar
                                    </button>
                                @else
                                    {{ $comida->nombre_comida }}
                                    <button type="button" class="btn btn-success btn-sm add-button" data-bs-toggle="modal" data-bs-target="#add{{$comida->id}}">
                                        <i class="bi bi-plus-circle"></i> Agregar
                                    </button>
                                @endif
                            </h5>
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
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
                                            @if ($detallePlan->horario_consumicion == $comida->nombre_comida && $detallePlan->alimento_id == $alimento->id)
                                                <tr>
                                                    <td>{{$alimento->alimento}}</td>
                                                    <td>{{$detallePlan->cantidad}}</td>
                                                    <td>{{$detallePlan->unidad_medida}}</td>
                                                    <td>{{$detallePlan->observacion}}</td>
                                                    <td>
                                                        <div>
                                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit_{{$detallePlan->id}}">
                                                                <span class="far fa-edit"></span>
                                                            </button>
                                                            <form action="{{route('plan-alimentacion.destroy', $detallePlan->id)}}" method="POST" style="display: inline;">
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
                                                <div class="modal fade" id="edit_{{$detallePlan->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="edit{{$comida->id}}Label" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="edit{{$comida->id}}Label">
                                                                    @if ($comida->nombre_comida == 'Media maniana')
                                                                        Editar Media mañana
                                                                    @else
                                                                        Editar {{$comida->nombre_comida}}
                                                                    @endif
                                                                </h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form id="editForm" action="{{route('plan-alimentacion.update', $detallePlan->id)}}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')

                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="alimento">Alimento</label>
                                                                            <select id="alimentoSelect" class="form-select" name="alimento">
                                                                                <option value="" disabled>Seleccione un alimento</option>
                                                                                @foreach ($alimentos as $alimento)
                                                                                    @foreach ($detallesPlan as $detalle)
                                                                                        @if ($detalle->id == $detallePlan->id)
                                                                                            @if ($detallePlan->alimento_id == $alimento->id)
                                                                                                <option value="{{$alimento->id}}" selected>{{$alimento->alimento}}</option>
                                                                                            @else
                                                                                                <option value="{{$alimento->id}}">{{$alimento->alimento}}</option>
                                                                                            @endif
                                                                                        @endif
                                                                                    @endforeach
                                                                                @endforeach
                                                                            </select>
                                                                            @error('alimento')
                                                                                <small class="text-danger">{{$message}}</small>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="cantidad">Cantidad</label>
                                                                            <input type="text" id="cantidadInput" class="form-control" name="cantidad" value="{{$detallePlan->cantidad}}">
                                                                            @error('cantidad')
                                                                                <small class="text-danger">{{$message}}</small>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="unidad_medida">Unidad de medida</label>
                                                                            <select class="form-select" name="unidad_medida" id="">
                                                                                <option value="" disabled>Seleccione la unidad de medida</option>
                                                                                @foreach ($unidadesMedidas as $unidad)
                                                                                    @foreach ($detallesPlan as $detalle)
                                                                                        @if ($detalle->id == $detallePlan->id)
                                                                                            @if ($detallePlan->unidad_medida == $unidad->nombre_unidad_medida)
                                                                                                <option value="{{$unidad->nombre_unidad_medida}}" selected>{{$unidad->nombre_unidad_medida}}</option>
                                                                                            @else
                                                                                                <option value="{{$unidad->nombre_unidad_medida}}">{{$unidad->nombre_unidad_medida}}</option>
                                                                                            @endif
                                                                                        @endif
                                                                                    @endforeach
                                                                                @endforeach
                                                                            </select>

                                                                            @error('unidad_medida')
                                                                                <small class="text-danger">{{$message}}</small>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <div class="row mt-3">
                                                                        <div class="col-md-12">
                                                                            <label for="observaciones">Observaciones</label>
                                                                            <textarea class="form-control" name="observaciones" id="" cols="10" rows="5">{{$detallePlan->observacion}}</textarea>
                                                                            @error('observaciones')
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
                                        @endforeach
                                    @empty
                                        <tr>
                                            <td colspan="5">
                                                <p>No hay alimentos asignados para este horario</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            @endforeach

            <div class="float-right">
                <div class="row">
                    <div class="col-md-12">
                        <form id="confirmar-form" action="{{route('plan-alimentacion.confirmarPlan', $planGenerado->id)}}" method="POST" class="d-inline-block">
                            @csrf
                            <button class="btn btn-success confirmar-button" type="button">Confirmar Plan</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="float-left">
                <div class="row">
                    <div class="col">
                        <a href="{{ route('plan-alimentacion.pdf', $planGenerado->id) }}" target="_blank" class="btn btn-secondary">
                            <i class="bi bi-printer"></i>
                            Imprimir
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @foreach ($comidas as $comida)
        <!-- Modal Add-->
        <div class="modal fade" id="add{{$comida->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="add{{$comida->id}}Label" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="add{{$comida->id}}Label">
                            @if ($comida->nombre_comida == 'Media maniana')
                                Agregar alimento a Media mañana
                            @endif
                            Agregar alimento a {{$comida->nombre_comida}}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addForm" action="{{route('plan-alimentacion.store')}}" method="POST">
                            @csrf

                            <input type="hidden" name="plan_id" value="{{$planGenerado->id}}">
                            <input type="hidden" name="comida" value="{{$comida->nombre_comida}}">

                            <div class="row">
                                <div class="col-md-4">
                                    <label for="alimento">Alimento</label>
                                    <select id="alimentoSelect" class="form-select" name="alimento">
                                        <option value="" disabled>Seleccione un alimento</option>
                                        @foreach ($alimentos as $alimento)
                                            <option value="{{$alimento->id}}">{{$alimento->alimento}}</option>
                                        @endforeach
                                    </select>

                                    @error('alimento')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="cantidad">Cantidad</label>
                                    <input type="text" id="cantidadInput" class="form-control" name="cantidad" value="{{old('cantidad')}}">

                                    @error('cantidad')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="unidad_medida">Unidad de medida</label>
                                    <select class="form-select" name="unidad_medida" id="">
                                        <option value="" disabled>Seleccione la unidad de medida</option>
                                        @foreach ($unidadesMedidas as $unidad)
                                            <option value="{{$unidad->nombre_unidad_medida}}">{{$unidad->nombre_unidad_medida}}</option>
                                        @endforeach
                                    </select>

                                    @error('unidad_medida')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>

                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label for="observaciones">Observaciones</label>
                                    <textarea class="form-control" name="observaciones" id="" cols="10" rows="3">{{old('observaciones')}}</textarea>
                                    @error('observaciones')
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
    @endforeach


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
        @if (session('successPlanConfirmado'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{session('successPlanConfirmado')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif

        @if (session('successAlimentoEliminado'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{session('successAlimentoEliminado')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif

        @if (session('successAlimentoActualizado'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{session('successAlimentoActualizado')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif

        @if (session('successAlimentoAgregado'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{session('successAlimentoAgregado')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif

        @if (session('errorAlimentoNoEncontrado'))
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: "{{session('errorAlimentoNoEncontrado')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif

        @if (session('errorAlimentoNoAgregado'))
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: "{{session('errorAlimentoNoAgregado')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif

        @if (session('errorPlanNoEncontrado'))
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: "{{session('errorPlanNoEncontrado')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif

        @if (session('errorAlimentoYaAgregado'))
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: "{{session('errorAlimentoYaAgregado')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif

        //SweetAlert Eliminar alimento
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
                        title: '¿Estás seguro de eliminar el alimento del plan?',
                        text: 'Esta acción eliminará el alimento del plan de alimentación.',
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
