@extends('adminlte::page')

@section('title', 'Lista de alimentos')

@section('content_header')
    <h1>Lista de Alimentos</h1>
@stop

@section('content')

    <a class="btn btn-primary" href="gestion-alimentos/create">Agregar nuevo alimento</a>

    <div class="container mt-3">
        <table id="tabla-alimentos" class="table table-dark table-striped mt-4">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Alimento</th>
                    <th scope="col">Grupo de alimento</th>
                    <th scope="col">Estacional</th>
                    <th scope="col">Estacion</th>
                    <th scope="col">Valores nutricionales</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($alimentos as $alimento)
                    <tr>
                        <td>{{$alimento->id}}</td>
                        <td>{{$alimento->alimento}}</td>
                        <td>
                            @foreach ($grupos as $grupo)
                                @if ($grupo->id == $alimento->grupo_alimento_id)
                                    {{$grupo->grupo}}
                                @endif
                            @endforeach
                        </td>
                        <td>{{$alimento->estacional}}</td>
                        <td>{{$alimento->estacion}}</td>
                        <td><a href="#">Ver valores nutricionales</a></td>
                        <td>
                            <a class="btn btn-info" href="{{ route('gestion-alimentos.edit', $alimento->id) }}">Editar</a>
                            <form action="{{ route('gestion-alimentos.destroy', $alimento->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Borrar</button>
                            </form>
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
            var table = $('#tabla-alimentos').DataTable({
                responsive: true,
                autoWidth: false,
                "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ alimentos por página",
                    "zeroRecords": "No se encontró ningún alimento",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros de alimentos",
                    "infoFiltered": "(filtrado de _MAX_ alimentos totales)",
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
