@extends('adminlte::page')

@section('title', 'Lista de alergias')

@section('content_header')
    <h1>Lista de Alergias</h1>
@stop

@section('content')

    <a class="btn btn-primary" href="{{route('gestion-alergias.create')}}">Agregar nueva Alergia</a>

    <div class="container mt-3">
        <table id="tabla-alergias" class="table table-dark table-striped mt-4">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Alergia</th>
                    <th scope="col">Grupo Alergia</th>
                    {{--<th scope="col">Alimentos Prohibidos</th>--}}
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($alergias as $alergia)
                    <tr>
                        <td>{{$alergia->id}}</td>
                        <td>{{$alergia->alergia}}</td>
                        <td>{{$alergia->grupo_alergia}}</td>
                       {{-- <td>
                            @foreach ($alimentos_prohibidos as $alimento)
                                @if ($alimento->alergia_id == $alergia->id)
                                    {{$alimento->alimento}}<br>
                                @endif
                            @endforeach
                        </td>--}}
                        <td>
                            <a class="btn btn-info" href="{{ route('gestion-alergias.edit', $alergia->id) }}">Editar</a>
                            <a class="btn btn-danger" href="{{route('gestion-alergias.destroy', $alergia->id)}}">Borrar</a>
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
            var table = $('#tabla-alergias').DataTable({
                responsive: true,
                autoWidth: false,
                "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ alergias por página",
                    "zeroRecords": "No se encontró ninguna alergia",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros de alergias",
                    "infoFiltered": "(filtrado de _MAX_ alergias totales)",
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
