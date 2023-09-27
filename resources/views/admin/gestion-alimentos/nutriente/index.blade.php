@extends('adminlte::page')

@section('title', 'Lista de Nutrientes')

@section('content_header')
    <h1>Lista de Nutrientes</h1>
@stop

@section('content')

    <a class="btn btn-primary" href="{{route('gestion-nutrientes.create')}}">Agregar nuevo Nutriente</a>

    <div class="container mt-3">
        <table id="tabla-nutrientes" class="table table-dark table-striped mt-4">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nutriente</th>
                    <th scope="col">Tipo Nutriente</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($nutrientes as $nutriente)
                    <tr>
                        <td>{{$nutriente->id}}</td>
                        <td>{{$nutriente->nombre_nutriente}}</td>
                        <td>
                            @foreach ($tipo_nutrientes as $tipo_nutriente)
                                @if ($tipo_nutriente->id == $nutriente->tipo_nutriente_id)
                                    {{$tipo_nutriente->tipo_nutriente}}
                                @endif
                            @endforeach
                        </td>
                        <td>
                            <div class="row">
                                <a class="btn btn-info" href="{{ route('gestion-nutrientes.edit', $nutriente->id) }}">Editar</a>
                                <form action="{{route('gestion-nutrientes.destroy', $nutriente->id)}}" method="post">
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
        var table = $('#tabla-nutrientes').DataTable({
            responsive: true,
            autoWidth: false,
            "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
            "language": {
                "lengthMenu": "Mostrar _MENU_ nutrientes por página",
                "zeroRecords": "No se encontró ningún nutriente",
                "info": "Mostrando la página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros de nutrientes",
                "infoFiltered": "(filtrado de _MAX_ nutrientes totales)",
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
