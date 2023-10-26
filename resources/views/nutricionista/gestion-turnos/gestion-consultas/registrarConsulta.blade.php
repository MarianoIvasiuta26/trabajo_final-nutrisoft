@extends('adminlte::page')

@section('title', 'Registrar Consulta')

@section('content_header')
    <h1>Registrar Consulta</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-md-8">
            <div class="card card-dark">
                <div class="card-header">
                   <h5>Paciente: {{$paciente->user->name}} {{$paciente->user->apellido}}</h5>

                </div>

                <div class="card-body">
                    <form id="consulta-form" action="{{route('gestion-consultas.store', $turno->id)}}" method="post">
                        @csrf

                        <input type="hidden" value="{{$paciente->id}}" id="paciente_id" name="paciente_id">
                        <span class="text-muted">Los datos con la etiqueta (*) significa que son obligatorios</span>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label for="tipo_consulta">Tipo de Consulta</label>
                                <select class="form-select" name="tipo_consulta" id="tipo_consulta">
                                    @foreach ($tipoConsultas as $tipoConsulta)
                                        <option value="{{$tipoConsulta->id}}"
                                            @if ($turno->tipo_consulta_id == $tipoConsulta->id)
                                                selected
                                            @else
                                                disabled
                                            @endif
                                            >{{$tipoConsulta->tipo_consulta}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="tratamiento_paciente">Tratamiento <span class="text-muted">(*)</span></label>
                                <div class="input-group">
                                    <select class="form-select" name="tratamiento_paciente" id="tratamiento_paciente">
                                        <option value="" selected disabled>Seleccione un tratamiento</option>
                                        @foreach ($tratamientos as $tratamiento)
                                            <option value="{{$tratamiento->id}}"
                                                @if ($turno->tipo_consulta_id == 2)
                                                    @foreach ($tratamientosPaciente as $tratamientoPaciente)
                                                        @if ($tratamiento->id == $tratamientoPaciente->tratamiento_id)
                                                            selected
                                                        @endif
                                                    @endforeach
                                                @endif
                                            >{{$tratamiento->tratamiento}}
                                            </option>
                                        @endforeach
                                    </select>
                                    {{--ACÁ VA EL FORM NUEVO--}}
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary nuevo-tratamiento-button">
                                            Nuevo
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12 mt-3">
                                <label for="observacion">Observaciones de Tratamiento <span class="text-muted">(*)</span></label>
                                <textarea class="form-control" name="observacion" id="observacion" cols="30" rows="2">{{old('observacion')}}</textarea>
                                @error('observacion')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label>¿Desea generar un plan de alimentación para este tratamiento?</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="generar-plan-alimentacion" name="generar-plan-alimentacion" value="1">
                                    <label class="form-check-label" for="generar-plan-alimentacion">Sí</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>¿Desea generar un plan de seguimiento para este tratamiento?</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="generar-plan-seguimiento" name="generar-plan-seguimiento" value="1">
                                    <label class="form-check-label" for="generar-plan-seguimiento">Sí</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <h5>Datos Físicos del paciente</h5>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label for="peso_actual">Peso actual <span class="text-muted">(*)</span> </label>
                                <div class="input-group">
                                    <input @if($turno->tipo_consulta_id == 2) value="{{$turnoAnteriorPaciente->consulta->peso_actual}}" @endif value="{{old('peso_actual')}}" class="form-control" name="peso_actual" id="peso_actual" type="text">
                                    <div class="input-group-append">
                                        <span class="input-group-text">kg</span>
                                    </div>
                                </div>
                                @error('peso_actual')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="altura_actual">Altura
                                    @if($turno->tipo_consulta_id == 1)
                                        <span class="text-muted">(*)</span>
                                        <button type="button" style="margin-left: 5px; padding: 0;" class="btn btn-sm align-middle" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-placement="right" data-bs-content="Debe ingresar la altura en la primera consulta aunque el paciente haya registrado su altura al completar su historia clínica antes de la consulta para tener resultados más aproximados.">
                                            <i class="bi bi-question-circle"></i>
                                        </button>
                                    @endif
                                </label>
                                <div class="input-group">
                                    <input @if($turno->tipo_consulta_id == 2) value="{{$turnoAnteriorPaciente->consulta->altura_actual}}" readonly @endif value="{{old('altura_actual')}}" class="form-control" name="altura_actual" id="altura_actual" type="text">
                                    <div class="input-group-append">
                                        <span class="input-group-text">cm</span>
                                    </div>
                                </div>
                                @error('altura_actual')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror

                            </div>
                        </div>

                        <div class="row mt-3">
                            <label for="imc_actual">IMC actual</label>
                            <div class="col-md-12">
                                <div class="input-group">
                                    <input @if($turno->tipo_consulta_id == 2) value="{{$turnoAnteriorPaciente->consulta->imc_actual}}" readonly @endif value="{{old('imc_actual')}}" class="form-control" name="imc_actual" id="imc_actual" type="text">
                                    <div class="input-group-append">
                                        <!-- <span class="input-group-text">kg/m<sup>2</sup></span> -->
                                        <button type="button" class="btn btn-success calcular-imc-button" id="calcular-imc-button">
                                            Calcular IMC
                                        </button>
                                    </div>
                                </div>
                                @error('imc_actual')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="col">
                                <div class="float-right">

                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label>Nuevas mediciones de circunferencias</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="nuevas-mediciones-circunferencias" name="nuevas_mediciones-circunferencias" value="1">
                                    <label class="form-check-label" for="nuevas-mediciones-circunferencias">Sí</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label>Nuevas mediciones de pliegues</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="nuevas-mediciones-pliegues" name="nuevas_mediciones-pliegues" value="1">
                                    <label class="form-check-label" for="nuevas-mediciones-pliegues">Sí</label>
                                </div>
                            </div>
                        </div>

                        <!-- Contenedor con las circunferencias necesarias -->
                        <div class="medidas-circunferencias" id="medidas-circunferencias" style="display: none;">
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="circ_munieca_actual">Circunferencia de muñeca
                                        @if($turno->tipo_consulta_id == 2)
                                            <button type="button" style="margin-left: -5px;" class="btn btn-sm align-middle" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-placement="right" data-bs-content="Circunferencia completada con el valor registrado en la última consulta. Puede modificarla en caso de realizar una nueva medición.">
                                                <i class="bi bi-question-circle"></i>
                                            </button>
                                        @endif
                                    </label>
                                    <div class="input-group">
                                        <input @if($turno->tipo_consulta_id == 2) value="{{$turnoAnteriorPaciente->consulta->circunferencia_munieca_actual}}"  @endif value="{{old('circ_munieca_actual')}}" class="form-control" name="circ_munieca_actual" id="circ_munieca_actual" type="text">
                                        <div class="input-group-append">
                                            <span class="input-group-text">cm</span>
                                        </div>
                                    </div>
                                    @error('circ_munieca_actual')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="circ_cadera_actual">Circunferencia de cadera
                                        @if($turno->tipo_consulta_id == 2)
                                            <button type="button" style="margin-left: -5px;" class="btn btn-sm align-middle" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-placement="right" data-bs-content="Circunferencia completada con el valor registrado en la última consulta. Puede modificarla en caso de realizar una nueva medición.">
                                                <i class="bi bi-question-circle"></i>
                                            </button>
                                        @endif
                                    </label>
                                    <div class="input-group">
                                        <input @if($turno->tipo_consulta_id == 2) value="{{$turnoAnteriorPaciente->consulta->circunferencia_cadera_actual}}"  @endif value="{{old('circ_cadera_actual')}}" class="form-control" name="circ_cadera_actual" id="circ_cadera_actual" type="text">
                                        <div class="input-group-append">
                                            <span class="input-group-text">cm</span>
                                        </div>
                                    </div>
                                    @error('circ_cadera_actual')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="circ_cintura_actual">Circunferencia de cintura
                                        @if($turno->tipo_consulta_id == 2)
                                            <button type="button" style="margin-left: -5px;" class="btn btn-sm align-middle" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-placement="right" data-bs-content="Circunferencia completada con el valor registrado en la última consulta. Puede modificarla en caso de realizar una nueva medición.">
                                                <i class="bi bi-question-circle"></i>
                                            </button>
                                        @endif
                                    </label>
                                    <div class="input-group">
                                        <input @if($turno->tipo_consulta_id == 2) value="{{$turnoAnteriorPaciente->consulta->circunferencia_cintura_actual}}"  @endif value="{{old('circ_cintura_actual')}}" class="form-control" name="circ_cintura_actual" id="circ_cintura_actual" type="text">
                                        <div class="input-group-append">
                                            <span class="input-group-text">cm</span>
                                        </div>
                                    </div>
                                    @error('circ_cintura_actual')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="circ_pecho_actual">Circunferencia de pecho
                                        @if($turno->tipo_consulta_id == 2)
                                            <button type="button" style="margin-left: -5px;" class="btn btn-sm align-middle" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-placement="right" data-bs-content="Circunferencia completada con el valor registrado en la última consulta. Puede modificarla en caso de realizar una nueva medición.">
                                                <i class="bi bi-question-circle"></i>
                                            </button>
                                        @endif
                                    </label>
                                    <div class="input-group">
                                        <input @if($turno->tipo_consulta_id == 2) value="{{$turnoAnteriorPaciente->consulta->circunferencia_pecho_actual}}"  @endif value="{{old('circ_pecho_actual')}}" class="form-control" name="circ_pecho_actual" id="circ_pecho_actual" type="text">
                                        <div class="input-group-append">
                                            <span class="input-group-text">cm</span>
                                        </div>
                                    </div>
                                    @error('circ_pecho_actual')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Contenedor con las masas corporales necesarias -->
                        <div class="medidas-masas" id="medidas-masas" style="display: none;">
                            <div class="seccion mt-3">
                                <h3>Datos para cálculos necesarios</h3>
                                <div class="contenido">
                                    <div class="row mt-3">
                                        <h5>
                                            Cálculos necesarios
                                            <button type="button" style="margin-left: -5px;" class="btn btn-sm align-middle" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-placement="right" data-bs-content="En esta sección debe seleccionar los cálculos que considere necesario para la generación del diagnóstico y del plan de alimentación del paciente.">
                                                <i class="bi bi-question-circle"></i>
                                            </button>
                                        </h5>

                                        <span class="text-muted">Los cálculos con la etiqueta (*) significa que son obligatorios</span>
                                    </div>

                                    <div class="row">
                                        <div class="btn-group" data-toggle="buttons">
                                        {{--
                                            <label class="btn btn-outline-success">
                                                <input class="btn-check" type="checkbox" name="calculo[]" id="imc" value="imc" checked readonly disabled> IMC (*)
                                            </label>
                                        --}}
                                            <label class="btn btn-outline-success">
                                                <input class="btn-check" type="checkbox" name="calculo[]" id="masa_grasa" value="masa_grasa"
                                                @if(old('calculo') && in_array('masa_grasa', old('calculo'))) checked @endif readonly> Masa Grasa
                                            </label>
                                            <label class="btn btn-outline-success">
                                                <input class="btn-check" type="checkbox" name="calculo[]" id="masa_osea" value="masa_osea"
                                                @if(old('calculo') && in_array('masa_osea', old('calculo'))) checked @endif readonly> Masa Ósea
                                            </label>
                                            <label class="btn btn-outline-success">
                                                <input class="btn-check" type="checkbox" name="calculo[]" id="masa_muscular" value="masa_muscular"
                                                @if(old('calculo') && in_array('masa_muscular', old('calculo'))) checked @endif readonly> Masa Muscular
                                            </label>
                                            <label class="btn btn-outline-success">
                                                <input class="btn-check" type="checkbox" name="calculo[]" id="masa_residual" value="masa_residual"
                                                @if(old('calculo') && in_array('masa_residual', old('calculo'))) checked @endif readonly> Masa Residual
                                            </label>
                                        </div>
                                    </div>

                                    <div class="container-mediciones" id="container-mediciones" style="display: none;">
                                        <div class="row mt-3">
                                            <h5>
                                                Mediciones de Pliegues Cutáneos
                                                <button type="button" style="margin-left: -5px;" class="btn btn-sm align-middle" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-placement="right" data-bs-content="(OPCIONAL) En esta sección puede ingresar las medidas de distintos pliegues cutáneos según sea necesario para los cálculos seleccionados arriba.">
                                                    <i class="bi bi-question-circle"></i>
                                                </button>
                                            </h5>

                                            <span class="text-muted">Si un pliegue cutáneo no es necesario para los cálculos a realizar puede dejarlo en blanco o escribir '0.00'</span>

                                        </div>

                                        <div class="row mt-3">
                                            @foreach ($plieguesCutaneos as $pliegue)
                                                <div class="col-md-6">
                                                    <label for="pliegue_{{$pliegue->id}}">{{$pliegue->nombre_pliegue}}</label>
                                                    <div class="input-group">
                                                        <input class="form-control pliegue-input" name="pliegue_{{$pliegue->id}}" id="pliegue_{{$pliegue->id}}" type="text" data-pliegue-key="{{$pliegue->id}}"
                                                        value="{{ old('pliegue_'.$pliegue->id) }}">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">{{$pliegue->unidad_de_medida}}</span>
                                                        </div>
                                                    </div>
                                                    @error('pliegue_{{$pliegue->id}}')
                                                        <span class="text-danger">{{$message}}</span>
                                                    @enderror
                                                </div>

                                                @if ($loop->iteration % 2 == 0)
                                                    </div>
                                                    <div class="row mt-3">
                                                @endif

                                            @endforeach
                                        </div>
                                        <div class="float-left">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-primary nuevo-pliegue-button">
                                                    Nuevo Pliegue Cutáneo
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="float-right">
                                                <button type="button" class="btn btn-success calcular-button" id="realizar-calculos-button">
                                                    Realizar cálculos
                                                </button>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row mt-3" id="resultados">

                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <label for="diagnostico">Diagnóstico <span class="text-muted">(*)</span></label>
                                <textarea class="form-control" name="diagnostico" id="diagnostico" cols="30" rows="5">{{old('diagnostico')}}</textarea>
                                @error('diagnostico')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 d-flex justify-content-end">
                                <button type="button" class="btn btn-success guardar-button">Guardar</button>
                                <form action="{{ route('gestion-turnos-nutricionista.index') }}" method="GET">
                                    @csrf
                                    <button class="btn btn-danger ml-2 cancelar-button" type="button">
                                        Cancelar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <button id="toggleAccordionsButton" class="btn btn-primary">Mostrar Accordions</button>

            <div class="accordion accordion-flush-success" id="accordionFlushExample">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        Datos del paciente
                    </button>
                  </h2>
                  <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <div class="row">

                            <div class="col-md-12">
                                <ul class="list-group list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                      <div class="ms-2 me-auto">
                                        <div class="fw-bold">Sexo</div>
                                        {{ $paciente->sexo }}
                                      </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                      <div class="ms-2 me-auto">
                                        <div class="fw-bold">Edad</div>
                                        {{ $paciente->edad }}
                                      </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                      <div class="ms-2 me-auto">
                                        <div class="fw-bold">Altura</div>
                                        {{ $historiaClinica->altura }} cm
                                      </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                          <div class="fw-bold">Peso</div>
                                          {{ $historiaClinica->peso }} kg
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                          <div class="fw-bold">Objetivo de Salud</div>
                                          {{ $historiaClinica->objetivo_salud }}
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                          <div class="fw-bold">Estilo de vida</div>
                                          {{ $historiaClinica->estilo_vida  }}
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-md-12 mt-2">
                                <div class="float-right">
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-historia-clinica">
                                        Ver Historia Clínica
                                    </button>

                                    <div class="modal fade" id="modal-historia-clinica" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">Historia Clínica</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                            <div class="modal-body">
                                                <table class="table table-stripped">
                                                    <tbody>
                                                        @forelse ($datosMedicos as $datoMedico)

                                                            @foreach ($alergias as $alergia)
                                                                @if ($alergia->id == $datoMedico->alergia_id)
                                                                    <tr>
                                                                        <th scope="row">Alergias</th>
                                                                        <td>{{ $alergia->alergia }}</td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach

                                                            @foreach ($patologias as $patologia)
                                                                    @if ($patologia->id == $datoMedico->patologia_id)
                                                                        <tr>
                                                                            <th scope="row">Patologías</th>
                                                                            <td>{{ $patologia->patologia}}</td>
                                                                        </tr>
                                                                    @endif
                                                            @endforeach
                                                            @foreach ($intolerancias as $intolerancia)
                                                                @if ($intolerancia->id == $datoMedico->intolerancia_id)
                                                                    <tr>
                                                                        <th scope="row">Intolerancias</th>
                                                                        <td>{{ $intolerancia->intolerancia}}</td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                            @foreach ($cirugias as $cirugia)
                                                                @forelse ($cirugiasPaciente as $cirugiaPaciente)
                                                                    @if ($cirugia->id == $cirugiaPaciente->cirugia_id)
                                                                        <tr>
                                                                            <th scope="row">Cirugías</th>
                                                                            <td>{{$cirugia->cirugia}}</td>
                                                                        </tr>
                                                                    @endif
                                                                @empty
                                                                @endforelse
                                                            @endforeach
                                                        @empty
                                                            <tr>
                                                                <td>
                                                                    <span class="text-danger">No se registraron datos médicos</span>
                                                                </td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>



            </div>

            <div class="row mt-2">
                <div class="accordion accordion-flush-success" id="accordionFlushHistorialTurnos">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="flush-historial-turnos">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseHistorialTurnos" aria-expanded="false" aria-controls="flush-collapseHistorialTurnos">
                            Historial de turnos
                        </button>
                      </h2>
                      <div id="flush-collapseHistorialTurnos" class="accordion-collapse collapse" aria-labelledby="flush-historial-turnos" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <div class="row">
                                @if ($turno->tipo_consulta_id == 2)
                                    <div class="col-md-12">
                                        <ul class="list-group list-group">
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto ">
                                                <div class="fw-bold">Último turno - {{\Carbon\Carbon::parse($turnoAnteriorPaciente->fecha)->format('d/m/Y')}}</div>
                                                </div>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold">Tipo de Consulta</div>
                                                {{ $turnoAnteriorPaciente->tipoConsulta->tipo_consulta }}
                                            </div>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold">Tratamiento</div>
                                                @foreach ($tratamientos as $tratamiento)
                                                    @forelse ($tratamientosPaciente as $tratamientoPaciente)
                                                        @if ($turnoAnteriorPaciente->fecha == $tratamientoPaciente->fecha_alta && $paciente->id == $tratamientoPaciente->paciente_id)
                                                            @if ($tratamiento->id == $tratamientoPaciente->tratamiento_id)
                                                                {{ $tratamiento->tratamiento }}
                                                            @endif
                                                        @endif
                                                    @empty
                                                        <span class="text-danger">No se registró tratamiento</span>
                                                    @endforelse
                                                @endforeach
                                            </div>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold">Observaciones</div>
                                                @forelse ($tratamientosPaciente as $tratamientoPaciente)
                                                    @if ($turnoAnteriorPaciente->fecha == $tratamientoPaciente->fecha_alta && $paciente->id == $tratamientoPaciente->paciente_id)
                                                        {{ $tratamientoPaciente->observaciones }}
                                                    @endif
                                                @empty
                                                    <span class="text-danger">No se registró tratamiento</span>
                                                @endforelse
                                            </div>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                <div class="fw-bold">Peso registrado</div>
                                                    @if ($turnoAnteriorPaciente->consulta)
                                                        {{ $turnoAnteriorPaciente->consulta->peso_actual }} kg
                                                    @else
                                                        Sin consulta relacionada
                                                    @endif
                                                </div>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                <div class="fw-bold">IMC</div>
                                                    @if ($turnoAnteriorPaciente->consulta)
                                                        {{ $turnoAnteriorPaciente->consulta->imc_actual }}
                                                    @else
                                                        Sin consulta relacionada
                                                    @endif
                                                </div>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                <div class="fw-bold">Diagnóstico</div>
                                                    @if ($turnoAnteriorPaciente->consulta)
                                                        {{ $turnoAnteriorPaciente->consulta->diagnostico }}
                                                    @else
                                                        Sin consulta relacionada
                                                    @endif
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <div class="float-right">
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-historial-turnos">
                                                Historial de Turnos
                                            </button>

                                            <div class="modal fade" id="modal-historial-turnos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="staticBackdropLabel">Historial de Turnos</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                    <div class="modal-body">
                                                        <table class="table table-striped" id="turnos">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Fecha</th>
                                                                    <th scope="col">Tipo de consulta</th>
                                                                    <th scope="col">Tratamiento</th>
                                                                    <th scope="col">Observaciones</th>
                                                                    <th scope="col">Peso registrado</th>
                                                                    <th scope="col">IMC</th>
                                                                    <th scope="col">Diagnóstico</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($turnosPaciente as $turno)
                                                                    <tr>
                                                                        <td>{{ \Carbon\Carbon::parse($turno->fecha)->format('d/m/Y') }}</td>
                                                                        <td>{{ $turno->tipoConsulta->tipo_consulta }}</td>
                                                                        <td>
                                                                            @foreach ($tratamientos as $tratamiento)
                                                                                @forelse ($tratamientosPaciente as $tratamientoPaciente)
                                                                                    @if ($turno->fecha == $tratamientoPaciente->fecha_alta && $paciente->id == $tratamientoPaciente->paciente_id)
                                                                                        @if ($tratamiento->id == $tratamientoPaciente->tratamiento_id)
                                                                                            {{ $tratamiento->tratamiento }}
                                                                                        @endif
                                                                                    @endif
                                                                                @empty
                                                                                    <span class="text-danger">No se registró tratamiento</span>
                                                                                @endforelse

                                                                            @endforeach
                                                                        </td>
                                                                        <td>
                                                                            @forelse ($tratamientosPaciente as $tratamientoPaciente)
                                                                                @if ($turno->fecha == $tratamientoPaciente->fecha_alta && $paciente->id == $tratamientoPaciente->paciente_id)
                                                                                    {{ $tratamientoPaciente->observaciones }}
                                                                                @endif
                                                                            @empty
                                                                                <span class="text-danger">No se registró tratamiento</span>
                                                                            @endforelse
                                                                        </td>
                                                                        <td>
                                                                            @if ($turno->consulta)
                                                                                {{ $turno->consulta->peso_actual }} kg
                                                                            @else
                                                                                Sin consulta relacionada
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ($turno->consulta)
                                                                                {{ $turno->consulta->imc_actual }}
                                                                            @else
                                                                                Sin consulta relacionada
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ($turno->consulta)
                                                                                {{ $turno->consulta->diagnostico }}
                                                                            @else
                                                                                Sin consulta relacionada
                                                                            @endif
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

                                        </div>
                                    </div>
                                @else
                                    <span>Sin turnos previos.</span>
                                @endif

                            </div>
                        </div>
                    </div>
                    </div>



                </div>
            </div>
        </div>

        <div id="sidebar">
            <!-- Contenido de los accordions -->

            <div class="accordion" id="accordionFlushHistorialTurnos">
                <!-- Tus accordions para Historial de turnos -->
            </div>
        </div>



    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
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

        /* Estilo para las casillas de verificación */
            .custom-checkbox-label {
                font-weight: bold;
                font-size: 1.2rem;
                color: #007bff; /* Color azul, puedes personalizarlo */
            }

            /* Cambiar el color de fondo cuando la casilla está seleccionada */
            .custom-checkbox-input:checked + .custom-checkbox-label::before {
                background-color: #007bff; /* Cambia al mismo color azul */
            }

            /* Cambiar el color del texto de la casilla seleccionada */
            .custom-checkbox-input:checked + .custom-checkbox-label::after {
                color: #ffffff; /* Texto en blanco en casilla seleccionada */
            }

            #sidebar {
                position: fixed;
                top: 0;
                right: -300px; /* Inicialmente, el sidebar está fuera de la pantalla */
                width: 300px; /* Ancho del sidebar */
                height: 100%;
                background-color: #f8f9fa; /* Color de fondo del sidebar */
                box-shadow: -5px 0px 5px rgba(0, 0, 0, 0.1); /* Sombra a la izquierda para resaltar el sidebar */
                z-index: 1000; /* Para estar por encima del contenido */
                overflow-y: auto; /* Agrega desplazamiento vertical si el contenido es largo */
                transition: right 0.3s; /* Animación de transición */
            }

            #sidebar.open {
                right: 0; /* Cuando se abre, se desplaza hacia la izquierda y se muestra completamente */
            }

    </style>

@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        $(document).ready(function() {
            $('[data-bs-toggle="popover"]').popover();
        });

        document.addEventListener("DOMContentLoaded", function () {
            const sidebar = document.getElementById("sidebar");
            const toggleButton = document.getElementById("toggleAccordionsButton");

            toggleButton.addEventListener("click", function () {
                sidebar.classList.toggle("open");
            });
        });

        //Evento para mostrar el contenedor con las mediciones de circunferencias
        document.addEventListener("DOMContentLoaded", function () {
            // Selecciona los elementos relevantes
            const nuevasMedicionesCheckbox = document.querySelector("#nuevas-mediciones-circunferencias");
            const containerMediciones = document.querySelector("#medidas-circunferencias");

            // Agrega un controlador de eventos para cambiar la visibilidad
            nuevasMedicionesCheckbox.addEventListener("change", function () {
                if (nuevasMedicionesCheckbox.checked) {
                    containerMediciones.style.display = "block";
                } else {
                    containerMediciones.style.display = "none";
                }
            });

            // Inicialmente, oculta el contenedor de mediciones
            containerMediciones.style.display = "none";
        });

        //SweetAlert para confirmar generación de plan de alimentación
        document.addEventListener('DOMContentLoaded', function () {
            // Selecciona el checkbox 'generar-plan-alimentacion'
            const generarPlanAlimentacionCheckbox = document.querySelector('#generar-plan-alimentacion');

            // Agrega un controlador de cambio al checkbox
            generarPlanAlimentacionCheckbox.addEventListener('change', function () {
                if (generarPlanAlimentacionCheckbox.checked) {
                    // Muestra un SweetAlert de confirmación solo si el checkbox se marca
                    Swal.fire({
                        title: '¿Está seguro de generar un plan de alimentación?',
                        text: 'Al registrar la consulta se generará automáticamente el plan de alimentación para el paciente.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, generar plan de alimentación',
                        cancelButtonText: 'Cancelar',
                    }).then((result) => {
                        if (!result.isConfirmed) {
                            // Si el usuario cancela, desmarca el checkbox
                            generarPlanAlimentacionCheckbox.checked = false;
                        }
                    });
                }
            });
        });

         //SweetAlert para confirmar generación de plan de seguimiento
         document.addEventListener('DOMContentLoaded', function () {
            // Selecciona el checkbox 'generar-plan-alimentacion'
            const generarPlanSeguimientoCheckbox = document.querySelector('#generar-plan-seguimiento');

            // Agrega un controlador de cambio al checkbox
            generarPlanSeguimientoCheckbox.addEventListener('change', function () {
                if (generarPlanSeguimientoCheckbox.checked) {
                    // Muestra un SweetAlert de confirmación solo si el checkbox se marca
                    Swal.fire({
                        title: '¿Está seguro de generar un plan de alimentación?',
                        text: 'Al registrar la consulta se generará automáticamente el plan de seguimiento para el paciente.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, generar plan de seguimiento',
                        cancelButtonText: 'Cancelar',
                    }).then((result) => {
                        if (!result.isConfirmed) {
                            // Si el usuario cancela, desmarca el checkbox
                            generarPlanSeguimientoCheckbox.checked = false;
                        }
                    });
                }
            });
        });

        //Función para calcular IMC
        $(document).ready(function () {
            $('#calcular-imc-button').click(function () {
                // Obtener el peso y la altura desde los campos de entrada
                var peso = parseFloat($('#peso_actual').val());
                var altura = parseFloat($('#altura_actual').val());

                // Realizar la validación de peso y altura
                if (isNaN(peso) || isNaN(altura)) {
                    $('#imc-result').html('Por favor, ingrese un peso y una altura válidos.');
                    return;
                }

                // Realizar la solicitud AJAX al servidor para calcular el IMC
                $.ajax({
                    type: 'POST',
                    url: '{{route('gestion-consultas.calcularIMC')}}',
                    data: { peso: peso, altura: altura, _token: "{{ csrf_token() }}" },
                    success: function (data) {
                        // Actualizar el campo de IMC con el resultado
                        $('#imc_actual').val(data.imc);
                        document.getElementById('diagnostico').value += data.diagnostico;
                    },
                    error: function () {
                        $('#imc-result').html('Ocurrió un error al calcular el IMC.');
                    }
                });
            });
        });

        //Evento para mostrar el contenedor con las mediciones de pliegues
        document.addEventListener("DOMContentLoaded", function () {
            // Selecciona los elementos relevantes
            const nuevasMedicionesCheckbox = document.querySelector("#nuevas-mediciones-pliegues");
            const containerMediciones = document.querySelector("#medidas-masas");

            // Agrega un controlador de eventos para cambiar la visibilidad
            nuevasMedicionesCheckbox.addEventListener("change", function () {
                if (nuevasMedicionesCheckbox.checked) {
                    containerMediciones.style.display = "block";
                } else {
                    containerMediciones.style.display = "none";
                }
            });

            // Inicialmente, oculta el contenedor de mediciones
            containerMediciones.style.display = "none";
        });

        //Evento para que al seleccionar la masa a calcular aparezca los pliegues necesarios
        document.addEventListener('DOMContentLoaded', function () {
            const calculos = document.querySelectorAll('input[name="calculo[]"]');

            calculos.forEach(function (calculo) {
                calculo.addEventListener('click', function () {
                    const containerMediciones = document.getElementById('container-mediciones');
                    if (calculo.checked) {
                        containerMediciones.style.display = 'block';
                    } else {
                        containerMediciones.style.display = 'none';
                    }
                });
            });
        });

        //SweetAlert2
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        //SweetAlert botón de agregar un nuevo registro de tratamiento
        document.addEventListener('DOMContentLoaded', function () {
            // Selecciona todos los botones de eliminar con la clase 'delete-button'
            const nuevoTratamientoButton = document.querySelectorAll('.nuevo-tratamiento-button');

            // Agrega un controlador de clic a cada botón de eliminar
            nuevoTratamientoButton.forEach(function (button) {
                button.addEventListener('click', function () {
                    // Muestra un SweetAlert de confirmación
                    swalWithBootstrapButtons.fire({
                        title: '¿Está seguro de agregar un nuevo tratamiento?',
                        text: 'Al confirmar, se redirigirá a la página para registrar un nuevo tratamiento.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, registrar un nuevo tratamiento',
                        cancelButtonText: 'Cancelar',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirige al usuario a la ruta deseada
                            window.location.href = '{{ route('gestion-tratamientos.create') }}';
                        }
                    });
                });
            });
        });

        //SweetAlert botón de agregar un nuevo registro de pliegue
        document.addEventListener('DOMContentLoaded', function () {
            // Selecciona todos los botones de eliminar con la clase 'delete-button'
            const nuevoPliegueButton = document.querySelectorAll('.nuevo-pliegue-button');

            // Agrega un controlador de clic a cada botón de eliminar
            nuevoPliegueButton.forEach(function (button) {
                button.addEventListener('click', function () {
                    // Muestra un SweetAlert de confirmación
                    swalWithBootstrapButtons.fire({
                        title: '¿Está seguro de agregar un nuevo Pliegue cutáneo?',
                        text: 'Al confirmar, se redirigirá a la página para registrar un nuevo pliegue.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, registrar un nuevo pliegue cutáneo',
                        cancelButtonText: 'Cancelar',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirige al usuario a la ruta deseada
                            window.location.href = '{{ route('gestion-pliegues-cutaneos.create') }}';
                        }
                    });
                });
            });
        });

        //SweetAlert botón de calcular los cálculos necesarios
        document.addEventListener('DOMContentLoaded', function () {
            const calcularButton = document.getElementById('realizar-calculos-button');

            if (calcularButton) {
                calcularButton.addEventListener('click', function () {
                    swalWithBootstrapButtons.fire({
                        title: '¿Está seguro de realizar los cálculos?',
                        text: 'Al confirmar se calcularán automáticamente los cálculos seleccionados.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, realizar cálculos necesarios',
                        cancelButtonText: 'Cancelar',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            //Recogemos datos del form
                            let paciente = document.getElementById('paciente_id').value;
                            let peso = document.getElementById('peso_actual').value;
                            let altura = document.getElementById('altura_actual').value;
                            let calculosSeleccionado = [];
                            let plieguesSeleccionado = {};

                            //Recorremos los checkbox de los cálculos
                            let calculos = document.querySelectorAll('input[name="calculo[]"]:checked');
                            calculos.forEach(function(calculo){
                                calculosSeleccionado.push(calculo.value);
                            });

                            //Recorremos los input de los pliegues
                            let pliegues = document.querySelectorAll('input[name^="pliegue_"]');
                            pliegues.forEach(function (pliegue) {
                                // Obtenemos la clave del atributo 'data-pliegue-key'
                                let pliegueKey = pliegue.getAttribute('data-pliegue-key');
                                let pliegueValue = pliegue.value;
                                // Almacenamos la clave y el valor en un objeto
                                plieguesSeleccionado['pliegue_' + pliegueKey] = pliegueValue;
                            });

                            console.log(paciente);
                            console.log(peso);
                            console.log(altura);
                            console.log(calculosSeleccionado);
                            console.log(plieguesSeleccionado);

                            //Enviamos la petición AJAX
                            $.ajax({
                                url: '{{route('gestion-consultas.realizarCalculos')}}',
                                method: 'POST',
                                data: {
                                    paciente: paciente,
                                    peso: peso,
                                    altura: altura,
                                    calculosSeleccionado: calculosSeleccionado,
                                    plieguesSeleccionado: plieguesSeleccionado,
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(data){
                                    //Si la petición es correcta, mostramos los resultados
                                    // Formatea los datos y asigna la representación de cadena al textarea
                                /*
                                    const formattedData = "IMC: " + data.imc + "\n" +
                                        "Peso Ideal: " + data.pesoIdeal + "\n" +
                                        "Masa Grasa: " + data.masaGrasa + "\n" +
                                        "Masa Ósea: " + data.masaOsea + " Kg\n" +
                                        "Masa Residual: " + data.masaResidual + " Kg\n" +
                                        "Masa Muscular: " + data.masaMuscular + " Kg";

                                    document.getElementById('diagnostico').value = formattedData;
                                */
                                    document.getElementById('diagnostico').value += data.diagnostico;
                                    const masaGrasaValue = data.masaGrasa;
                                    const masaOseaValue = data.masaOsea;
                                    const masaResidualValue = data.masaResidual;
                                    const masaMuscularValue = data.masaMuscular;

                                    //Mostramos los resultados en el div resultados en input:hidden
                                    document.getElementById('resultados').innerHTML = `
                                        <div class="col-md-6">
                                            <label for="masa_grasa">Masa Grasa</label>
                                            <input value="${masaGrasaValue}" class="form-control" name="masa_grasa_actual" id="masa_grasa_actual" type="text" value="${data.masaGrasa}" >
                                            @error('masa_grasa_actual')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="masa_osea">Masa Ósea</label>
                                            <input value="${masaOseaValue}" class="form-control" name="masa_osea_actual" id="masa_osea_actual" type="text" value="${data.masaOsea}" >
                                            @error('masa_osea_actual')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="masa_residual">Masa Residual</label>
                                            <input value="${masaResidualValue}" class="form-control" name="masa_residual_actual" id="masa_residual_actual" type="text" value="${data.masaResidual}" >
                                            @error('masa_residual_actual')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="masa_muscular">Masa Muscular</label>
                                            <input value="${masaMuscularValue}" class="form-control" name="masa_muscular_actual" id="masa_muscular_actual" type="text" value="${data.masaMuscular}" >
                                            @error('masa_muscular_actual')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    `;

                                    if (errorDeValidacion) {
                                        //document.getElementById('imc_actual').value = imcValue;
                                        //document.getElementById('peso_ideal_actual').value = pesoIdealValue;
                                        document.getElementById('masa_grasa_actual').value = masaGrasaValue;
                                        document.getElementById('masa_osea_actual').value = masaOseaValue;
                                        document.getElementById('masa_residual_actual').value = masaResidualValue;
                                        document.getElementById('masa_muscular_actual').value = masaMuscularValue;
                                    }

                                },
                                error: function (error) {
                                    console.log(error);
                                },
                            });
                        }
                    });
                });
            }
        });

        //SweetAlert botón cancelar registro de consulta
        document.addEventListener('DOMContentLoaded', function () {
            // Selecciona todos los botones de eliminar con la clase 'delete-button'
            const cancelarButton = document.querySelectorAll('.cancelar-button');

            // Agrega un controlador de clic a cada botón de eliminar
            cancelarButton.forEach(function (button) {
                button.addEventListener('click', function () {
                    // Muestra un SweetAlert de confirmación
                    swalWithBootstrapButtons.fire({
                        title: '¿Está seguro de cancelar el registro de la consulta?',
                        text: 'Al confirmar se redirigirá a la página de turnos pendientes y el turno no se habrá registrado perdiénse toda la información.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, cancelar registro de consulta.',
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

        //SweetAlert para guardar consulta
        document.addEventListener('DOMContentLoaded', function () {
            const guardarConsulta = document.querySelectorAll('.guardar-button');

            guardarConsulta.forEach(button => {
                button.addEventListener('click', function () {
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: true
                        })

                        swalWithBootstrapButtons.fire({
                        title: '¿Está seguro de guardar el registro de la consulta?',
                        text: "Al confirmar se generarán los planes de alimentación y de seguimiento para el paciente.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: '¡Si, registrar consulta!',
                        confirmButtonColor: '#3085d6',
                        cancelButtonText: '¡No, cancelar!',
                        cancelButtonColor: '#d33',
                        reverseButtons: true
                        }).then((result) => {
                        if (result.isConfirmed) {
                            //Envia el form
                            const form = document.getElementById('consulta-form');
                            form.submit();
                        } else if (
                            /* Read more about handling dismissals below */
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            swalWithBootstrapButtons.fire(
                            '¡Consulta no registrada!',
                            'La consulta no se ha registrado, puede seguir modificando el formulario.',
                            'error'
                            )
                        }
                    })
                });
            });
        });

    </script>
@stop
