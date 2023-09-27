@extends('adminlte::page')

@section('title', 'Lista de patologias')

@section('content_header')
    <h1>Lista de Patologías</h1>
@stop

@section('content')

    <a class="btn btn-primary" href="{{route('gestion-patologias.create')}}">Agregar nueva Patología</a>

    <div class="container mt-3">
        <table id="tabla-patologias" class="table table-dark table-striped mt-4">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Patología</th>
                    <th scope="col">Grupo Patología</th>
                    {{--<th scope="col">Alimentos Prohibidos</th>
                    <th scope="col">Actividades Prohibidas</th>--}}
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($patologias as $patologia)
                    <tr>
                        <td>{{$patologia->id}}</td>
                        <td>{{$patologia->patologia}}</td>
                        <td>{{$patologia->grupo_patologia}}</td>
                        <td>
                            <a class="btn btn-info" href="{{ route('gestion-patologias.edit', $patologia->id) }}">Editar</a>
                            <a class="btn btn-danger" href="{{route('gestion-patologias.destroy', $patologia->id)}}">Borrar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
            var table = $('#tabla-patologias').DataTable({
                responsive: true,
                autoWidth: false,
                "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ patologías por página",
                    "zeroRecords": "No se encontró ninguna patología",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros de patologías",
                    "infoFiltered": "(filtrado de _MAX_ patologías totales)",
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
