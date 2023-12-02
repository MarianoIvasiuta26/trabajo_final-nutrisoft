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
                    <a class="btn btn-warning btn-sm" data-bs-toggle="collapse" href="#filtros" role="button" aria-expanded="false" aria-controls="filtros">
                        <i class="bi bi-funnel"></i>Filtros
                    </a>

                    <div class="collapse" id="filtros">
                        <div class="card card-body mt-2">
                            <form action="{{route('auditoria.filtros')}}" method="GET">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="fecha_desde">Desde:</label>
                                        <input class="form-control" type="date" name="fecha_desde" value="{{ old('fecha_desde', $fechaInicio) }}">

                                        @error( 'fecha_desde' )
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="fecha_hasta">Hasta:</label>
                                        <input class="form-control" type="date" name="fecha_hasta" value="{{ old('fecha_hasta', $fechaFin) }}">

                                        @error('fecha_hasta')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="justify-end float-right" style="display: inline-block;">
                                    <button class="btn btn-primary btn-sm" type="submit">Filtrar</button>
                                    <a href="{{route('auditoria.clearFilters')}}" class="btn btn-danger btn-sm">Borrar filtros</a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="mt-3">
                        <table class="table table-striped" id="tabla-auditoria">
                            <thead>
                                <tr>
                                    <th scope="col">Usuario</th>
                                    <th scope="col">Acción</th>
                                    <th scope="col">Objeto</th>
                                    <th scope="col">Fecha y hora</th>
                                    <th scope="col">Valor nuevo</th>
                                    <th scope="col">Valor antiguo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($audits as $auditoria)
                                    <tr>
                                        <td>{{ $auditoria->user ? $auditoria->user->name : 'Sistema' }}</td>
                                        <td>{{ __($auditoria->event) }}</td>
                                        <td>{{ class_basename($auditoria->auditable_type) }}</td>
                                        <td>{{ $auditoria->created_at }}</td>
                                        <td>{!! nl2br(e($auditoria->new_value)) !!}</td>
                                        <td>{!! nl2br(e($auditoria->old_value)) !!}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
    <!-- Moment.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <!-- datetime-moment CDN -->
    <script src="https://cdn.datatables.net/datetime-moment/2.6.1/js/dataTables.dateTime.min.js"></script>

    <script>

        //Datatable auditoría
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
                },
                order: [[ 0, "desc" ]],
                columnDefs: [
                    {
                        targets: 0, // Índice de la columna de fecha
                        type: 'datetime-moment',
                        render: function (data, type, row) {
                            return type === 'sort' ? moment(data, 'DD-MM-YYYY').format('YYYY-MM-DD') : data;
                        }
                    }
                ],
            });
        });
    </script>
@stop
