@extends('adminlte::page')

@section('title', 'Lista de usuarios')

@section('content_header')
    <h1>Lista de usuarios</h1>
@stop

@section('content')

    <a class="btn btn-primary" href="gestion-usuarios/create">Agregar nuevo usuario</a>

    <table class="table table-dark table-striped mt-4">
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
                        <a class="btn btn-info" href="{{ route('gestion-usuarios.edit', $usuario->id) }}">Editar</a>
                        <button class="btn btn-danger">Borrar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
