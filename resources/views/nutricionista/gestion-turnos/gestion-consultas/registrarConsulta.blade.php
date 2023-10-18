@extends('adminlte::page')

@section('title', 'Registrar Consulta')

@section('content_header')
    <h1>Registrar Consulta</h1>
@stop

@section('content')
    <div class="card card-dark">
        <div class="card-header">
            <h5>Paciente: {{$paciente->user->name}} {{$paciente->user->apellido}}</h5>
        </div>

        <div class="card-body">
            <form id="consulta-form" action="{{route('gestion-consultas.store', $turno->id)}}" method="post">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <label for="fecha">Fecha</label>
                        <input class="form-control" name="fecha" id="fecha" type="date" disabled value="{{$turno->fecha}}">
                    </div>

                    <div class="col-md-6">
                        <label for="hora">Hora</label>
                        <input class="form-control" name="hora" id="hora" type="time" disabled value="{{$turno->hora}}">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="tipo_consulta">Tipo de Consulta</label>
                        <select class="form-select" name="tipo_consulta" id="tipo_consulta">
                            @foreach ($tipoConsultas as $tipoConsulta)
                                <option value="{{$tipoConsulta->id}}" @if ($turno->tipo_consulta_id == $tipoConsulta->id)
                                    selected
                                @endif disabled>{{$tipoConsulta->tipo_consulta}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="tratamiento_paciente">Tratamiento <span class="text-muted">(*)</span></label>
                        <div class="input-group">
                            <select class="form-select" name="tratamiento_paciente" id="tratamiento_paciente">
                                @foreach ($tratamientos as $tratamiento)
                                    <option value="{{$tratamiento->id}}">{{$tratamiento->tratamiento}}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <form action="{{route('gestion-tratamientos.create')}}" method="GET">
                                    @csrf
                                    <button type="button" class="btn btn-primary nuevo-tratamiento-button">
                                        Nuevo
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12 mt-3">
                        <label for="observacion">Observaciones de Tratamiento <span class="text-muted">(*)</span></label>
                        <textarea class="form-control" name="observacion" id="observacion" cols="30" rows="2"></textarea>
                        @error('observacion')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <label for="paciente">Paciente</label>
                        <input class="form-control" name="paciente" id="paciente" type="text" disabled value="{{$paciente->user->name}} {{$paciente->user->apellido}}">
                        <input type="hidden" name="paciente_id" id="paciente_id" value="{{$paciente->id}}">
                    </div>

                    <div class="col-md-4">
                        <label for="objetivo_salud">Objetivo de Salud</label>
                        <input class="form-control" name="objetivo_salud" id="objetivo_salud" type="text" disabled value="{{$historiaClinica->objetivo_salud}}">
                        <input id="objetivo_salud" type="hidden" name="objetivo_salud" value="{{$historiaClinica->objetivo_salud}}">
                    </div>

                    <div class="col-md-4">
                        <label for="estilo_vida">Estilo de vida</label>
                        <input class="form-control" name="estilo_vida" id="estilo_vida" type="text" disabled value="{{$historiaClinica->estilo_vida}}">
                        <input id="estilo_vida" type="hidden" name="estilo_vida" value="{{$historiaClinica->estilo_vida}}">
                    </div>
                </div>

                <div class="row mt-3">
                    <h5>Datos Físicos del paciente</h5>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="peso_actual">Peso actual <span class="text-muted">(*)</span> </label>
                        <div class="input-group">
                            <input class="form-control" name="peso_actual" id="peso_actual" type="text">
                            <div class="input-group-append">
                                <span class="input-group-text">kg</span>
                            </div>
                        </div>
                        @error('peso_actual')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="altura_actual">Altura actual <span class="text-muted">(*)</span></label>
                        <div class="input-group">
                            <input class="form-control" name="altura_actual" id="altura_actual" type="text">
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
                    <div class="col-md-6">
                        <label for="circ_munieca_actual">Circunferencia de muñeca <span class="text-muted">(*)</span></label>
                        <div class="input-group">
                            <input class="form-control" name="circ_munieca_actual" id="circ_munieca_actual" type="text">
                            <div class="input-group-append">
                                <span class="input-group-text">cm</span>
                            </div>
                        </div>
                        @error('circ_munieca_actual')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="circ_cadera_actual">Circunferencia de cadera <span class="text-muted">(*)</span></label>
                        <div class="input-group">
                            <input class="form-control" name="circ_cadera_actual" id="circ_cadera_actual" type="text">
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
                        <label for="circ_cintura_actual">Circunferencia de cintura <span class="text-muted">(*)</span></label>
                        <div class="input-group">
                            <input class="form-control" name="circ_cintura_actual" id="circ_cintura_actual" type="text">
                            <div class="input-group-append">
                                <span class="input-group-text">cm</span>
                            </div>
                        </div>
                        @error('circ_cintura_actual')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="circ_pecho_actual">Circunferencia de pecho <span class="text-muted">(*)</span></label>
                        <div class="input-group">
                            <input class="form-control" name="circ_pecho_actual" id="circ_pecho_actual" type="text">
                            <div class="input-group-append">
                                <span class="input-group-text">cm</span>
                            </div>
                        </div>
                        @error('circ_pecho_actual')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>

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
                                <label class="btn btn-outline-success">
                                    <input class="btn-check" type="checkbox" name="calculo[]" id="imc" value="imc" checked disabled> IMC (*)
                                </label>
                                <label class="btn btn-outline-success">
                                    <input class="btn-check" type="checkbox" name="calculo[]" id="masa_grasa" value="masa_grasa"> Masa Grasa
                                </label>
                                <label class="btn btn-outline-success">
                                    <input class="btn-check" type="checkbox" name="calculo[]" id="masa_osea" value="masa_osea"> Masa Ósea
                                </label>
                                <label class="btn btn-outline-success">
                                    <input class="btn-check" type="checkbox" name="calculo[]" id="masa_muscular" value="masa_muscular"> Masa Muscular
                                </label>
                                <label class="btn btn-outline-success">
                                    <input class="btn-check" type="checkbox" name="calculo[]" id="masa_residual" value="masa_residual"> Masa Residual
                                </label>
                            </div>
                        </div>

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
                                        <input class="form-control pliegue-input" name="pliegue_{{$pliegue->id}}" id="pliegue_{{$pliegue->id}}" type="text" data-pliegue-key="{{$pliegue->id}}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">{{$pliegue->unidad_de_medida}}</span>
                                        </div>
                                    </div>
                                </div>

                                @if ($loop->iteration % 2 == 0)
                                    </div>
                                    <div class="row mt-3">
                                @endif

                            @endforeach
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="float-right">
                                    <button type="button" class="btn btn-success calcular-button" id="realizar-calculos-button">
                                        Realizar cálculos
                                    </button>
                                </div>
                                <div class="float-left">
                                    <form action="{{route('gestion-pliegues-cutaneos.create')}}" method="GET">
                                        @csrf

                                        <button type="button" class="btn btn-primary nuevo-pliegue-button">
                                            Nuevo pliegue cutáneo
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3" id="resultados">

                        </div>

                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col">
                        <label for="diagnostico">Diagnóstico <span class="text-muted">(*)</span></label>
                        <textarea class="form-control" name="diagnostico" id="diagnostico" cols="30" rows="5"></textarea>
                        @error('diagnostico')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>

                <div id="resultados">

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
                                // Si el usuario confirma, envía el formulario
                                button.closest('form').submit();
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
                                // Si el usuario confirma, envía el formulario
                                button.closest('form').submit();
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
                                        document.getElementById('diagnostico').value = data.diagnostico;

                                        //Mostramos los resultados en el div resultados en input:hidden
                                        document.getElementById('resultados').innerHTML = `
                                            <div class="col-md-12 mt-3"> <!-- Resultados de los cálculos -->
                                                <h5>Resultados de los cálculos</h5>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="imc">IMC</label>
                                                <input class="form-control" name="imc" id="imc" type="text" value="${data.imc}" disabled>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="peso_ideal">Peso Ideal</label>
                                                <input class="form-control" name="peso_ideal" id="peso_ideal" type="text" value="${data.pesoIdeal}" disabled>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="masa_grasa">Masa Grasa</label>
                                                <input class="form-control" name="masa_grasa" id="masa_grasa" type="text" value="${data.masaGrasa}" disabled>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="masa_osea">Masa Ósea</label>
                                                <input class="form-control" name="masa_osea" id="masa_osea" type="text" value="${data.masaOsea}" disabled>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="masa_residual">Masa Residual</label>
                                                <input class="form-control" name="masa_residual" id="masa_residual" type="text" value="${data.masaResidual}" disabled>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="masa_muscular">Masa Muscular</label>
                                                <input class="form-control" name="masa_muscular" id="masa_muscular" type="text" value="${data.masaMuscular}" disabled>
                                            </div>
                                        `;

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
