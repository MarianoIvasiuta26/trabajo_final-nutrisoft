@extends('adminlte::page')

@section('title', 'Historial de Turnos')

@section('content_header')
    <h1>Historial de Turnos</h1>
@stop

@section('content')

    <div class="card card-dark">
        <div class="card-header">
            <h5>Historial de Turnos</h5>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-4 mb-3">
                    <label for="filtro-fecha" class="form-label">Filtrar por Fecha:</label>
                    <input type="text" class="form-control" id="filtro-fecha">
                </div>
                <div class="col-4 mb-3">
                    <label for="filtro-hora" class="form-label">Filtrar por Hora:</label>
                    <input type="text" class="form-control" id="filtro-hora">
                </div>
                <div class="col-4 mb-3">
                    <label for="filtro-estado" class="form-label">Filtrar por Estado:</label>
                    <select class="form-select" id="filtro-estado">
                        <option value="">Todos</option>
                        <option value="Pendiente">Pendiente</option>
                        <option value="Cancelado">Cancelado</option>
                        <option value="Realizado" selected>Realizado</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-4 mb-3">
                    <label for="filtro-tipo-consulta" class="form-label">Filtrar por Tipo de Consulta:</label>
                    <select class="form-select" id="filtro-tipo-consulta">
                        <option value="">Todos</option>
                        @foreach ($tipoConsultas as $tipoConsulta)
                            <option value="{{ $tipoConsulta->tipo_consulta }}">{{ $tipoConsulta->tipo_consulta }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4 mb-3">
                    <label for="filtro-objetivo-salud" class="form-label">Filtrar por Objetivo de Salud:</label>
                    <input type="text" class="form-control" id="filtro-objetivo-salud">
                </div>
                <div class="col-4 mb-3">
                    <label for="filtro-paciente" class="form-label">Filtrar por Paciente:</label>
                    <input type="text" class="form-control" id="filtro-paciente">
                </div>
            </div>

            <table id="historial-turnos" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Paciente</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Tipo de consulta</th>
                        <th scope="col">Objetivo de salud</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($turnos as $turno)
                        @foreach ($pacientes as $paciente)
                            @if ($paciente->id == $turno->paciente_id)
                                <tr>
                                    <td>
                                        {{ $turno->fecha }}
                                    </td>

                                    <td>
                                        {{ $turno->hora }}
                                    </td>

                                    <td>

                                        {{ $paciente->user->name }} {{ $paciente->user->apellido }}

                                    </td>

                                    <td>
                                        {{ $turno->estado }}
                                    </td>

                                    <td>
                                        @foreach ($tipoConsultas as $tipoConsulta)
                                            @if ($tipoConsulta->id == $turno->tipo_consulta_id)
                                                {{ $tipoConsulta->tipo_consulta }}
                                            @endif
                                        @endforeach
                                    </td>

                                    <td>
                                        @foreach ($historiasClinicas as $historiaClinica)
                                            @if ($historiaClinica->paciente_id == $paciente->id)
                                                {{ $historiaClinica->objetivo_salud }}
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function(){
            var table = $('#historial-turnos').DataTable({
                responsive: true,
                autoWidth: false,
                "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ turnos por página",
                    "zeroRecords": "No se encontró ningún turno",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros de turnos",
                    "infoFiltered": "(filtrado de _MAX_ turnos totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                },
                "order": [[ 0, "desc" ]],
            });

            // Aplicar los filtros personalizados
            $('#filtro-fecha').on('keyup', function(){
                table.column(0).search(this.value).draw(); // Columna 0 para la fecha
            });

            $('#filtro-hora').on('keyup', function(){
                table.column(1).search(this.value).draw(); // Columna 1 para la hora
            });

            $('#filtro-estado').on('change', function(){
                table.column(3).search(this.value).draw(); // Columna 3 para el estado
            });

            //Filtro estado or defecto
            var filtroEstado = $('#filtro-estado');
            filtroEstado.val('Realizado');
            table.column(3).search('Realizado').draw();

            $('#filtro-tipo-consulta').on('change', function(){
                table.column(4).search(this.value).draw(); // Columna 4 para el tipo de consulta
            });

            $('#filtro-objetivo-salud').on('keyup', function(){
                table.column(5).search(this.value).draw(); // Columna 5 para el objetivo de salud
            });

            $('#filtro-paciente').on('keyup', function(){
                table.column(2).search(this.value).draw(); // Columna 2 para el paciente
            });
        });
    </script>
@stop
