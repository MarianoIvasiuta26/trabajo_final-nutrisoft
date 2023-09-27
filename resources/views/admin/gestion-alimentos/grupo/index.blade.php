@extends('adminlte::page')

@section('title', 'Lista de Grupo de Alimentos')

@section('content_header')
    <h1>Lista de Grupo de Alimentos</h1>
@stop

@section('content')

    <a class="btn btn-primary" href="{{route('gestion-grupos-alimento.create')}}">Agregar nuevo Grupo de Alimento</a>

    <div class="container mt-3">
        <table id="tabla-grupo" class="table table-dark table-striped mt-4">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Grupo de Alimento</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupos as $grupo)
                    <tr>
                        <td>{{$grupo->id}}</td>
                        <td>{{$grupo->grupo}}</td>
                        <td>
                            <div class="row">
                                <a class="btn btn-info" href="{{ route('gestion-grupos-alimento.edit', $grupo->id) }}">Editar</a>
                                <form action="{{route('gestion-grupos-alimento.destroy', $grupo->id)}}" method="post">
                                    <a style="margin-left: 10px;" class="btn btn-danger">Borrar</a>
                                </form>
                            </div>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop

@section('css')
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
        var table = $('#tabla-grupo').DataTable({
            responsive: true,
            autoWidth: false,
            "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
            "language": {
                "lengthMenu": "Mostrar _MENU_ grupos por página",
                "zeroRecords": "No se encontró ningún grupo",
                "info": "Mostrando la página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros de grupos",
                "infoFiltered": "(filtrado de _MAX_ grupos totales)",
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
