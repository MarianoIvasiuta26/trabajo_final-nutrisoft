@extends('adminlte::page')

@section('title', 'Lista de usuarios')

@section('content_header')
    <h1>Lista de usuarios</h1>
@stop

@section('content')

    <a class="btn btn-primary" href="gestion-usuarios/create">Agregar nuevo usuario</a>

    <div class="container mt-3">
        <table id="tabla-usuarios" class="table table-dark table-striped mt-4">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Rol</th>
                    <th scope="col">Email</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td>{{$usuario->id}}</td>
                        <td>{{$usuario->name}}</td>
                        <td>{{$usuario->apellido}}</td>
                        <td>{{$usuario->tipo_usuario}}</td>
                        <td>{{$usuario->email}}</td>
                        <td>
                            <div class="row">
                                <div class="col">
                                    <a class="btn btn-info" href="{{ route('gestion-usuarios.edit', $usuario->id) }}">Editar</a>
                                </div>
                                <div class="col">
                                    <form action="{{ route('gestion-usuarios.destroy', $usuario->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Borrar</button>
                                    </form>
                                </div>
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
        var table = $('#tabla-usuarios').DataTable({
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
</script>
@stop
