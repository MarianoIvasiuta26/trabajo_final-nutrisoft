@extends('adminlte::page')

@section('title', 'Días y Horarios Fijos')

@section('content_header')

@stop

@section('content')
    <div class="col-md-12">
        <div class="card card-dark">
            <div class="card-header">
                <h5>Días y Horas Fijos disponibles</h5>
            </div>
            <div id="diasYHoras" class="card-body">
                <form action="{{route('adelantamiento-turno.guardar')}}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col">
                            <label class="form-label" for="profesional">Seleccione el profesional del que recibe atenciones</label>
                            <select name="profesional" id="profesional" class="form-select">
                                <option value="">Seleccione un profesional</option>
                                @foreach($profesionales as $profesional)
                                    <option value="{{$profesional->id}}">{{$profesional->user->name}} {{$profesional->user->apellido}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="row mt-3">
                        <div class="col-md-12" id="dias-consultas">
                        {{-- @php
                            $diasAgregados = []; // Matriz para realizar un seguimiento de los días agregados
                            @endphp
                            @foreach ($profesionales as $profesional)
                                @foreach ($horarios as $horario)
                                    @foreach ($dias as $dia)
                                        @if ($profesional->id == $horario->nutricionista_id && $dia->id == $horario->dia_atencion_id && $dia->seleccionado == 1 && !in_array($dia->dia, $diasAgregados))
                                            <div class="col-md-2">
                                                <div class="icheck-primary">
                                                    <input value="{{$dia->dia}}" type="checkbox" id="diasFijos-{{$dia->dia}}" name="diasFijos[]"/>
                                                    <label for="diasFijos-{{$dia->dia}}">{{$dia->dia}}</label>
                                                </div>
                                            </div>
                                            @php
                                            $diasAgregados[] = $dia->dia; // Agrega el día a la matriz de seguimiento
                                            @endphp
                                        @endif
                                    @endforeach
                                @endforeach
                            @endforeach
                        --}}
                        </div>

                        <!-- Horas -->

                        @foreach ($dias as $dia)
                            <div class="col-md-12" id="horas-disponibles-{{$dia->dia}}">

                            </div>
                        @endforeach

                        <!--
                        <div class="col-md-12" id="horas-disponibles">
                        {{--
                            <div class="row">
                                <select name="horasFijas[]" class="selectpicker" multiple title="Seleccione las horas de la mañana disponibles..." data-style="btn-success" data-width="fit" data-live-search="true" data-size="5">
                                    <option value="8:00">8:00</option>
                                    <option value="8:30">8:30</option>
                                    <option value="9:00">9:00</option>
                                    <option value="9:30">9:30</option>
                                    <option value="10:00">10:00</option>
                                    <option value="10:30">10:30</option>
                                    <option value="11:00">11:00</option>
                                    <option value="11:30">11:30</option>
                                    <option value="12:00">12:00</option>
                                </select>
                            </div>

                            <div class="row">
                                <select name="horasFijas[]" class="selectpicker mt-4" data-style="btn-success" multiple title="Seleccione las horas de la tarde disponibles..." data-width="fit" data-size="5" data-live-search="true">
                                    <option value="16:30">16:30</option>
                                    <option value="17:00">17:00</option>
                                    <option value="17:30">17:30</option>
                                    <option value="18:00">18:00</option>
                                    <option value="18:30">18:30</option>
                                    <option value="19:00">19:00</option>
                                    <option value="19:30">19:30</option>
                                </select>
                            </div>
                        --}}

                        </div>
                    -->

                    </div>


                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="float-right">
                                <button type="submit" class="btn btn-success">Guardar</button>
                                <a href="{{ route('historia-clinica.index') }}" class="btn btn-danger" tabindex="7">Cancelar</a>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />

@stop

@section('js')
    <script> console.log('Hi!'); </script>

    <!-- Select2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        //Obtener días y horas
        $(document).ready(function() {
            $('#profesional').on('change', function () {
                var profesionalSeleccionado = this.value;

                if (profesionalSeleccionado) {
                    cargarDiasDisponibles(profesionalSeleccionado);
                } else {
                    // Si no se selecciona un profesional, vacía el contenedor de días y horas
                    $('#dias-consultas').empty();
                    $('#horas-disponibles').empty();
                }

                // Función para cargar los días disponibles
                function cargarDiasDisponibles(profesionalSeleccionado) {
                    // Realiza una solicitud Ajax para obtener los días disponibles
                    $.ajax({
                        url: "{{ route('adelantamiento-turno.obtener-dias') }}",
                        type: "POST",
                        data: {
                            profesional: profesionalSeleccionado,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (diasDisponibles) {
                            var diasContainer = $('#dias-consultas');
                            diasContainer.empty();
                            var indicacion = '<h5>Seleccione los días que tiene disponibles:</h5>';
                            diasContainer.append(indicacion);

                            // Agrega una fila para los días
                            var row = '<div class="row">';
                            $.each(diasDisponibles.diasFijos, function (index, dia) {
                                // Agrega los checkboxes de días disponibles a la fila
                                var checkbox = '<div class="col-md-2">' +
                                    '<div class="icheck-primary">' +
                                    '<input value="' + dia + '" type="checkbox" id="diasFijos-' + dia + '" name="diasFijos[]"/>' +
                                    '<label for="diasFijos-' + dia + '">' + dia + '</label>' +
                                    '</div>' +
                                    '</div>';
                                row += checkbox;
                            });
                            row += '</div>';
                            diasContainer.append(row);

                            console.log(diasDisponibles);
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }

                var horasContainer;
                // Agrega un evento de cambio a los checkboxes de días
                $(document).on('change', 'input[name="diasFijos[]"]', function() {
                    if (this.checked) {
                        var diaSeleccionado = $(this).val();

                        console.log('Día seleccionado: ' + diaSeleccionado);
                        cargarHorasDisponibles(profesionalSeleccionado, diaSeleccionado);
                    } else {
                        // Si se desmarca el día, borra las horas correspondientes
                        var diaDeseleccionado = $(this).val();
                        var horasContainerId = 'horas-disponibles-' + diaDeseleccionado;
                        var horasContainer = $('#' + horasContainerId);
                        horasContainer.empty();
                        console.log('Se ha desmarcado el día. ' + diaDeseleccionado);
                    }
                });

                // Función para cargar las horas disponibles
                function cargarHorasDisponibles(profesionalSeleccionado, diaSeleccionado) {
                    console.log('La función cargarHorasDisponibles se ha activado.');
                    // Realiza una solicitud Ajax para obtener las horas disponibles
                    $.ajax({
                        url: "{{ route('adelantamiento-turno.obtener-horas') }}",
                        type: "POST",
                        data: {
                            profesional: profesionalSeleccionado,
                            dia: diaSeleccionado,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (horasDisponibles) {
                            var horasContainerId = 'horas-disponibles-' + diaSeleccionado; // Identificador único por día
                            var horasContainer = $('#' + horasContainerId);
                            var indicacion = '<h5>Seleccione las horas disponibles para el día ' + diaSeleccionado + ':</h5>';
                            horasContainer.empty();
                            horasContainer.append(indicacion);

                            // Agrega una fila para las horas
                            var row = '<div class="row">';
                            $.each(horasDisponibles.horas, function (index, hora) {
                                // Agrega los checkboxes de horas disponibles a la fila
                                var checkbox = '<div class="col-md-2">' +
                                    '<div class="icheck-primary">' +
                                    '<input value="' + hora + '" type="checkbox" id="horasFijas-' + hora + '-' + diaSeleccionado + '" name="horasFijas[]"/>' +
                                    '<label for="horasFijas-' + hora + '-' + diaSeleccionado + '">' + hora + '</label>' +
                                    '</div>' +
                                    '</div>';
                                row += checkbox;
                            });
                            row += '</div>';
                            horasContainer.append(row);
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }
            });
        });

    </script>

@stop
