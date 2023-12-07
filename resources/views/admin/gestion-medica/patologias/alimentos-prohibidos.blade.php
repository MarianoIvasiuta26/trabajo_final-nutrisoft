@extends('adminlte::page')

@section('title', 'Alimentos prohibidos en Patologias')

@section('content_header')
    <h1>Alimentos prohibidos en Patologias</h1>
@stop

@section('content')


    <div class="card card-dark">
        <div class="card-header">
            <h5>Alimentos prohibidos en Patologias</h5>
        </div>

        <div class="card-body">

            <form action="{{route('prohibiciones-patologias.store')}}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <h6>Selecciona un Alimento:</h6>
                        <select name="alimentos[]" class="form-select" id="alimentos" data-placeholder="Alimentos..." multiple>
                            <option value="">Selecciona un alimento</option>
                            @foreach ($alimentos as $alimento)
                                <option @if(old('alimento_id', null) == $alimento->id) selected @endif value="{{ $alimento->id }}">{{ $alimento->alimento }}</option>
                            @endforeach
                        </select>

                        @error('alimento_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <h6>Selecciona una patologia:</h6>
                        <select name="patologias[]" class="form-select" id="patologias" data-placeholder="Patologias..." multiple>
                            <option value="">Ninguna</option>
                            @foreach ($patologias->groupBy('grupo_patologia') as $grupo_patologia => $patologias_del_grupo)
                                <optgroup label="{{$grupo_patologia}}">
                                    @foreach ($patologias_del_grupo as $patologia)
                                        <option value="{{$patologia->id}}">{{$patologia->patologia}}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('patologias')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                <div class="row mt-3">
                    <div class="col">
                        <div class="float-right">
                            <button type="button" class="btn btn-success asociar-button">Prohibir alimento en patologia</button>
                        </div>
                    </div>
                </div>

            </form>
            <div class="mt-4">
                <h5>Prohibiciones Actuales:</h5>
                <table class="table table-dark" id="prohibiciones" >
                    <thead>
                        <tr>
                            <th>Alimento</th>
                            <th>Tipo de Patologías</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($prohibiciones as $prohibido)
                            <tr>
                                <td>
                                    @foreach ($alimentos as $alimento)
                                        @if ($alimento->id == $prohibido->alimento_id)
                                            {{ $alimento->alimento }}
                                        @endif
                                    @endforeach
                                </td>

                                <td>
                                    @foreach ($patologias as $patologia)
                                        @if ($patologia->id == $prohibido->patologia_id)
                                            {{ $patologia->patologia }}
                                        @endif
                                    @endforeach
                                </td>

                                <td>
                                    <div>
                                        <form action="{{ route('prohibiciones-patologias.edit', $prohibido->id) }}" method="GET"style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-warning">
                                                <span class="far fa-edit"></span>
                                            </button>
                                        </form>
                                        <form action="{{ route('prohibiciones-patologias.destroy', $prohibido->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger delete-button">
                                                <span class="far fa-trash-alt"></span>
                                            </button>
                                        </form>
                                    </div>

                                </td>
                            </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

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
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        $( '#alimentos' ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            closeOnSelect: false,
        } );

        $( '#patologias' ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            closeOnSelect: false,
        } );

        $(document).ready(function(){
            $('#prohibiciones').DataTable({
                responsive: true,
                autoWidth: false,
                "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ prohibiciones por página",
                    "zeroRecords": "No se encontró ninguna prohibición",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay prohibiciones",
                    "infoFiltered": "(filtrado de _MAX_ prohibiciones totales)",
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

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{session('success')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: "{{session('error')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif

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
            const guardarButtons = document.querySelectorAll('.asociar-button');

            // Agrega un controlador de clic a cada botón de eliminar
            guardarButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    // Muestra un SweetAlert de confirmación
                    swalWithBootstrapButtons.fire({
                        title: '¿Estás seguro de prohibir el alimento a las alergias seleccionadas?',
                        text: 'Luego no se recomendará este alimento en la dieta de los pacientes con estas alergias.',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#198754',
                        confirmButtonText: 'Sí, prohibir alimento.',
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

        document.addEventListener('DOMContentLoaded', function () {
            // Selecciona todos los botones de eliminar con la clase 'delete-button'
            const deleteButtons = document.querySelectorAll('.delete-button');

            // Agrega un controlador de clic a cada botón de eliminar
            deleteButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    // Muestra un SweetAlert de confirmación
                    swalWithBootstrapButtons.fire({
                        title: '¿Estás seguro?',
                        text: 'Esta acción eliminará el alimento recomendado a la dieta.',
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
    </script>
@stop
