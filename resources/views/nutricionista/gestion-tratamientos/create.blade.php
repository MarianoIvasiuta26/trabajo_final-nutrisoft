@extends('adminlte::page')

@section('title', 'Agregar nuevo tratamiento')

@section('content_header')
@stop

@section('content')
    <form id="crear-tratamiento" action="{{ route('gestion-tratamientos.store') }}" method="POST" onsubmit="mostrarSpinner()">
        @csrf

        <div class="card card-dark mt-3">
            <div class="card-header">
                <h5>Nuevo Tratamiento</h5>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <label for="tratamiento">Tratamiento <span class="text-muted">(*)</span></label>
                        <input type="text" name="tratamiento" class="form-control" tabindex="1">

                        @error('tratamiento')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label for="tipo_de_dieta">Tipo de dieta <span class="text-muted">(*)</span></label>
                        <select class="form-select" name="tipo_de_dieta" id="tipo_de_dieta">
                            <option value="">Seleccione un tipo de dieta para el tratamiento</option>
                            @foreach ($tiposDeDietas as $dieta)
                                <option value="{{ $dieta->id }}">{{ $dieta->tipo_de_dieta }}</option>
                            @endforeach
                        </select>

                        @error('tipo_de_dieta')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label for="actividades">Tipo de Actividades <span class="text-muted">(*)</span></label>
                        <select name="actividades[]" class="form-select" id="actividades" data-placeholder="Actividades..." multiple>
                            <option value="">Selecciona una actividad</option>
                            @foreach ($tiposActividades as $tipoActividad)
                                <option @if(in_array($tipoActividad->id, old('actividades', []))) selected @endif value="{{ $tipoActividad->id }}">{{ $tipoActividad->tipo_actividad }}</option>

                            @endforeach
                        </select>

                        @error('actividades')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <span class="text-muted">Los datos con la etiqueta (*) significa que son obligatorios</span>

                    <div class="col-12">
                        <div class="float-right">
                            <a type="button" href="{{ route('gestion-tratamientos.index') }}" id="cancelar-button" class="btn btn-danger" tabindex="7">Cancelar</a>
                            <button type="submit" class="btn btn-success" id="guardar-button">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function mostrarSpinner() {
            let timerInterval;
            // Muestra la alerta al enviar el formulario
            Swal.fire({
                title: "Creando nuevo tratamiento",
                html: "Cargando...",
                didOpen: () => {
                    Swal.showLoading();
                    const timer = Swal.getPopup().querySelector("b");
                    timerInterval = setInterval(() => {
                    timer.textContent = `${Swal.getTimerLeft()}`;
                    }, 100);
                },
                allowOutsideClick: false,
                showCancelButton: false,
                showConfirmButton: false,
            });
            // Cancela el envío del formulario
            return false;
        }

        //Select2
        $( '#actividades' ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            closeOnSelect: false,
        } );

         document.addEventListener('DOMContentLoaded', function () {
            const cancelarButtons = document.querySelectorAll('.cancelar-button');

            cancelarButtons.forEach(button => {
                button.addEventListener('click', function () {
                    Swal.fire({
                        title: '¿Estás seguro de cancelar el registro?',
                        text: "",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, cancelar el registro'
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
