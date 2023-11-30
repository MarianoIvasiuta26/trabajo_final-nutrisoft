@extends('adminlte::page')

@section('title', 'Auditoría')

@section('content_header')
@stop

@section('content')

    <div class="card card-dark mt-3">
        <div class="card-header">
            <h5>Auditoría</h5>
        </div>
        <div class="card-body">
            <div class="row mt-2">
                <div class="col-md-12">
                    <table class="table table-striped" id="tabla-auditoria">
                        <thead>
                            <tr>
                                <th scope="col">Usuario</th>
                                <th scope="col">Acción</th>
                                <th scope="col">Objeto modificado</th>
                                <th scope="col">Fecha y hora</th>
                                <th scope="col">Valor nuevo</th>
                                <th scope="col">Valor antiguo</th>
                                <th scope="col">Dirección ip</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($audits as $auditoria)
                                <tr>
                                    <td>{{ $auditoria->user ? $auditoria->user->name : 'Sistema' }}</td>
                                    <td>{{ $auditoria->event }}</td>
                                    <td>{{$auditoria->auditable_type}}</td>
                                    <td>{{ $auditoria->created_at }}</td>
                                    <td>{{ json_encode($auditoria->new_values) }}</td>
                                    <td>{{ json_encode($auditoria->old_values) }}</td>
                                    <td>{{ $auditoria->ip_address }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>

        //Datatable tratamientos
        $(document).ready(function(){
            $('#tabla-auditoria').DataTable({
                responsive: true,
                autoWidth: false,
                "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_",
                    "zeroRecords": "No se encontró ninguna auditoría",
                    "info": "",
                    "infoEmpty": "No hay auditorías disponibles",
                    "infoFiltered": "(filtrado de _MAX_ auditorías totales)",
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
    </script>
@stop
