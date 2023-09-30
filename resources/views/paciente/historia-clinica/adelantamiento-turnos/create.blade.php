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


                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="float-right">
                                <button type="submit" class="btn btn-success">Guardar</button>
                                <a href="{{ route('gestion-usuarios.index') }}" class="btn btn-danger" tabindex="7">Cancelar</a>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/css/bootstrap-select.min.css" rel="stylesheet">

    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />


    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>
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
                        var indicacion = '<h5>Seleccione los días que tiene disponibles:</h5>'
                        diasContainer.append(indicacion);
                        $.each(diasDisponibles.diasFijos, function (index, dia) {
                            // Agrega los checkboxes de días disponibles al contenedor

                            var checkbox = '<div class="col-md-2">' +
                                '<div class="icheck-primary">' +
                                '<input value="' + dia + '" type="checkbox" id="diasFijos-' + dia + '" name="diasFijos[]"/>' +
                                '<label for="diasFijos-' + dia + '">' + dia + '</label>' +
                                '</div>' +
                                '</div>';
                            diasContainer.append(checkbox);
                        });
                        console.log(diasDisponibles);
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }

            // Agrega un evento de cambio a los checkboxes de días
            $(document).on('change', 'input[name="diasFijos[]"]', function() {
                if (this.checked) {
                    var diaSeleccionado = $(this).val();
                    console.log('Día seleccionado: ' + diaSeleccionado);
                    cargarHorasDisponibles(profesionalSeleccionado, diaSeleccionado);
                } else {
                    console.log('Se ha desmarcado el día.');
                    // Si se desmarca el día, borra las horas correspondientes
                    $('#horas-disponibles').empty();
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
                        var horasContainer = $('#horas-disponibles');
                        var indicacion = '<h5>Seleccione las horas disponibles:</h5>'
                        horasContainer.append(indicacion);

                        $.each(horasDisponibles.horas, function (index, hora) {
                            // Agrega los checkboxes de horas disponibles al contenedor
                            var checkbox = '<div class="col-md-2">' +
                                '<div class="icheck-primary">' +
                                '<input value="' + hora + '" type="checkbox" id="horasFijas-' + hora + '" name="horasFijas[]"/>' +
                                '<label for="horasFijas-' + hora + '">' + hora + '</label>' +
                                '</div>' +
                                '</div>';
                            horasContainer.append(checkbox);
                        });
                    },
                    error: function (error) {
                        console.log(error);xam
                    }
                });
            }
            });
        });
    </script>

@stop
