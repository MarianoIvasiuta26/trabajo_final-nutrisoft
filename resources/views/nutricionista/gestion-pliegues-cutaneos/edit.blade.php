@extends('adminlte::page')

@section('title', 'Editar Pliegue Cutáneo')

@section('content_header')
@stop

@section('content')
    <div class="card card-dark mt-3">
        <div class="card-header">
            <h5>Editar Pliegue Cutáneo</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('gestion-pliegues-cutaneos.update', $pliegue->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <label for="pliegue">Pliegue cutáneo(*)</label>
                        <input value="{{$pliegue->nombre_pliegue}}" type="text" name="pliegue" id="pliegue" class="form-control" tabindex="2">

                        @error('pliegue')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="unidad_de_medida">Unidad de medida(*)</label>
                        <select class="form-select" name="unidad_de_medida" id="unidad_de_medida">
                            <option value="">Seleccione una opción </option>
                            <option value="mm"
                                @if ($pliegue->unidad_de_medida == 'mm')
                                    selected
                                @endif
                            >Milímetros (mm)</option>
                            <option value="cm"
                            @if ($pliegue->unidad_de_medida == 'cm')
                                selected
                            @endif
                            >Centímetros (cm)</option>
                            <option value="in"
                            @if ($pliegue->unidad_de_medida == 'in')
                                selected
                            @endif
                            >Pulgadas (in)</option>
                            <option value="µm"
                            @if ($pliegue->unidad_de_medida == 'µm')
                                selected
                            @endif
                            >Micrómetros (µm)</option>
                            <option value="mils"
                            @if ($pliegue->unidad_de_medida == 'mils')
                                selected
                            @endif
                            >Miles de pulgadas (mils)</option>
                            <option value="decimilimetros"
                            @if ($pliegue->unidad_de_medida == 'decimilimetros')
                                selected
                            @endif
                            >Decenas de milímetros (decimilímetros)</option>
                        </select>

                        @error('unidad_de_medida')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label for="descripcion">Descripción</label>
                        <textarea name="descripcion" id="descripcion" cols="30" rows="5" class="form-control" tabindex="3">{{old('descripcion', $pliegue->descripcion)}}</textarea>

                        @error('descripcion')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="alert alert-warning mt-3" role="alert">
                    Los campos marcados con un (*) son obligatorios.
                </div>

                <div>
                    <form action="{{ route('gestion-pliegues-cutaneos.index') }}">
                        @csrf

                        <button type="button" class="btn btn-danger cancelar-button">
                            Cancelar
                        </button>
                    </form>

                    <button type="button" id="guardar-button" class="btn btn-success guardar-button">Guardar</button>
                </div>
            </form>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <style>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script> console.log('Hi!'); </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
         //SweetAlert
         const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
         document.addEventListener('DOMContentLoaded', function () {
            // Selecciona todos los botones de eliminar con la clase 'delete-button'
            const cancelarButtons = document.querySelectorAll('.cancelar-button');

            // Agrega un controlador de clic a cada botón de eliminar
            cancelarButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    // Muestra un SweetAlert de confirmación
                    swalWithBootstrapButtons.fire({
                        title: '¿Estás seguro de cancelar la edición?',
                        text: 'Esta acción redirigirá a la vista con todos los pliegues cutáneos.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, cancelar edición',
                        cancelButtonText: 'No, volver a edición.',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Si el usuario confirma, envía el formulario
                            button.closest('form').submit();
                        }
                    });
                });
            });
        });

        //SweetAlert
        document.addEventListener('DOMContentLoaded', function () {
            // Selecciona todos los botones de eliminar con la clase 'delete-button'
            const guardarButtons = document.querySelectorAll('.guardar-button');

            // Agrega un controlador de clic a cada botón de eliminar
            guardarButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    // Muestra un SweetAlert de confirmación
                    swalWithBootstrapButtons.fire({
                        title: '¿Estás seguro de editar el pliegue cutáneo?',
                        text: 'Esta acción modificará la información actual del pliegue cutáneo.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, editar pliegue cutáneo',
                        cancelButtonText: 'No, cancelar edición',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Si el usuario confirma, envía el formulario
                            button.closest('form').submit();
                        }
                    });
                });
            });
        });
    </script>

@stop
