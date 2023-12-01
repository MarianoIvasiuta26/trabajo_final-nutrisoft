@extends('adminlte::page')

@section('title', 'Roles y Permisos')

@section('content_header')

@stop

@section('content')

    <div class="card card-dark mt-3">
        <div class="card-header">
            <h3 class="card-title">Roles y Permisos</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget = "collapse" title= "collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRol">
                Nuevo Rol
            </button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPermiso">
                Nuevo Permiso
            </button>

            <div class="row mt-3">
                <table id="tabla-roles" class="table table-dark table-striped mt-4">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Permisos</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $rol)
                            <tr>
                                <td>{{$rol->id}}</td>
                                <td>{{$rol->name}}</td>
                                <td>
                                    @foreach ($permisos as $permiso)
                                        @if ($rol->hasPermissionTo($permiso->name))
                                            <span class="badge bg-success">{{$permiso->name}}</span>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col">
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editRol">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        </div>
                                        <div class="col">
                                            <form action="{{ route('gestion-rolesYPermisos.destroy', $rol->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Modal Nuevo rol -->
            <div class="modal fade" id="addRol" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addRolLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addRolLabel">Nuevo rol</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('gestion-rolesYPermisos.store')}}" method="POST" id="form-addRol">
                                @csrf

                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del rol...">
                                </div>

                                <div class="mb-3">
                                    <label for="permisos" class="form-label">Permisos</label>
                                    <select name="permisos[]" class="form-select" id="permisos" data-placeholder="Permisos..." multiple>
                                        <option value="">Selecciona un permiso</option>
                                        @foreach ($permisos as $permiso)
                                            <option @if(in_array($permiso->id, old('permisos', []))) selected @endif value="{{ $permiso->id }}">{{ $permiso->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary add-rol">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Nuevo permiso -->
            <div class="modal fade" id="addPermiso" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addPermisoLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addPermisoLabel">Nuevo permiso</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('gestion-rolesYPermisos.storePermiso')}}" method="POST" id="form-addPermiso">
                                @csrf

                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del permiso...">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary add-permiso">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal editar rol -->
            <div class="modal fade" id="editRol" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editRolLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editRolLabel">Editar rol</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('gestion-rolesYPermisos.update', $rol->id)}}" method="POST" id="form-editRol">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del rol..." value="{{$rol->name}}">
                                </div>

                                <div class="mb-3">
                                    <label for="permisos" class="form-label">Permisos</label>
                                    <select name="permisos[]" class="form-select" id="permisos" data-placeholder="Permisos..." multiple>
                                        <option value="">Selecciona un permiso</option>
                                        @foreach ($permisos as $permisoAEvaluar)
                                            <option
                                                @if($rol->hasPermissionTo($permisoAEvaluar->name))
                                                    selected
                                                @endif

                                                value="{{ $permiso->id }}">{{ $permiso->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary add-permiso">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Permisos -->

    <div class="card card-dark mt-3">
        <div class="card-header">
            <h3 class="card-title">Permisos</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget = "collapse" title= "collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row mt-3">
                <table id="tabla-permisos" class="table table-dark table-striped mt-4">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Permiso</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permisos as $permiso)
                            <tr>
                                <td>{{$permiso->id}}</td>
                                <td>{{$permiso->name}}</td>
                                <td>
                                    <div class="row">
                                        <div class="col">
                                            <a class="btn btn-warning btn-sm" href="">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <form action="{{ route('gestion-rolesYPermisos.destroyPermiso', $permiso->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                             <!-- Modal editar permiso -->
                            <div class="modal fade" id="editPermiso" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editPermisoLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editPermisoLabel">Nuevo permiso</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('gestion-rolesYPermisos.updatePermiso', $permiso->id)}}" method="POST" id="form-editPermiso">
                                                @csrf
                                                @method('PUT')

                                                <div class="mb-3">
                                                    <label for="nombre" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del permiso..." value="{{$permiso->name}}">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                            <button type="button" class="btn btn-primary add-permiso">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function(){
        var table = $('#tabla-roles').DataTable({
            responsive: true,
            autoWidth: false,
            "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
            "language": {
                "lengthMenu": "Mostrar _MENU_ usuarios por página",
                "zeroRecords": "No se encontró ningún turno",
                "info": "Mostrando la página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros de usuarios",
                "infoFiltered": "(filtrado de _MAX_ usuarios totales)",
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

     //Select2
     $( '#permisos' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        closeOnSelect: false,
    } );

    //SweetAlert para guardar nuevo rol
    document.addEventListener('DOMContentLoaded', function () {
        const guardarRol = document.querySelectorAll('.add-rol');

        guardarRol.forEach(button => {
            button.addEventListener('click', function () {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: true
                    })

                    swalWithBootstrapButtons.fire({
                    title: '¿Está seguro de guardar rol con sus permisos?',
                    text: "Al confirmar se guardará el rol y los permisos asociados.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: '¡Guardar rol!',
                    confirmButtonColor: '#3085d6',
                    cancelButtonText: '¡No, cancelar!',
                    cancelButtonColor: '#d33',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.isConfirmed) {
                        //Envia el form
                        const form = document.getElementById('form-addRol');
                        form.submit();
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                        '¡No se guardó el rol con sus permisos!'
                        )
                    }
                })
            });
        });
    });

    //SweetAlert para guardar nuevo permiso
    document.addEventListener('DOMContentLoaded', function () {
        const guardarRol = document.querySelectorAll('.add-permiso');

        guardarRol.forEach(button => {
            button.addEventListener('click', function () {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: true
                    })

                    swalWithBootstrapButtons.fire({
                    title: '¿Está seguro de guardar el nuevo permiso?',
                    text: "Al confirmar se guardará permiso.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: '¡Guardar permiso!',
                    confirmButtonColor: '#3085d6',
                    cancelButtonText: '¡No, cancelar!',
                    cancelButtonColor: '#d33',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.isConfirmed) {
                        //Envia el form
                        const form = document.getElementById('form-addPermiso');
                        form.submit();
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                        '¡No se guardó el permiso!'
                        )
                    }
                })
            });
        });
    });

    //Mensajes fhash

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '{{session('success')}}',
            showConfirmButton: false,
            timer: 1500
        })
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'success',
            title: '{{session('error')}}',
            showConfirmButton: false,
            timer: 1500
        })
    @endif

</script>
@stop
