@extends('adminlte::page')

@section('title', 'Editar Intolerancia')

@section('content_header')
@stop

@section('content')
    <div class="card card-dark mt-3">
        <div class="card-header">
            <h5>Editar Intolerancia - {{$intolerancia->intolerancia}}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('gestion-intolerancias.update', $intolerancia->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="intolerancia" class="form-label">Intolerancia</label>
                    <input value="{{$intolerancia->intolerancia}}" type="text" name="intolerancia" id="intolerancia" class="form-control" tabindex="2">
                </div>
                {{--<div class="mb-3">
                    <label for="tipo_usuario" class="form-label">Alimentos prohibidos</label>
                    <select name="alimentos_prohibidos[]" class="form-select" id="alimentos_prohibidos" data-placeholder="Alimentos prohibidos..." multiple>
                    <select name="tipo_usuario" id="tipo_usuario" class="form-control" tabindex="4">
                        @foreach ($alimentos_prohibidos as $alimento)
                            <option value="{{ $alimento->alimento }}">{{ $alimento->alimento }}</option>
                        @endforeach
                    </select>
                </div>--}}

                <div>
                    <form action="{{ route('gestion-intolerancias.index') }}">
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
           buttonsStyling: true
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
                        text: 'Esta acción redirigirá a la vista con todas las intolerancias.',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'No, volver a edición.',
                        confirmButtonColor: '#198754',
                        confirmButtonText: 'Sí, cancelar edición',
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

       //SweetAlert
       document.addEventListener('DOMContentLoaded', function () {
           // Selecciona todos los botones de eliminar con la clase 'delete-button'
           const guardarButtons = document.querySelectorAll('.guardar-button');

           // Agrega un controlador de clic a cada botón de eliminar
           guardarButtons.forEach(function (button) {
               button.addEventListener('click', function () {
                   // Muestra un SweetAlert de confirmación
                   swalWithBootstrapButtons.fire({
                       title: '¿Estás seguro de editar la alergia?',
                       text: 'Esta acción modificará la información actual de la intolerancia.',
                       icon: 'warning',
                       showCancelButton: true,
                       cancelButtonText: 'No, cancelar edición',
                        confirmButtonColor: '#198754',
                       confirmButtonText: 'Sí, editar intolerancia',
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
   </script>
@stop
