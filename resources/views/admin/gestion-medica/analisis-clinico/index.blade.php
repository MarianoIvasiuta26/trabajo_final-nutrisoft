@extends('adminlte::page')

@section('title', 'Lista de alergias')

@section('content_header')
    <h1>Lista de Alergias</h1>
@stop

@section('content')

    <a class="btn btn-primary" href="{{route('gestion-analisis.create')}}">Agregar nueva Alergia</a>

    <table class="table table-dark table-striped mt-4">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tipo</th>
                <th scope="col">Clase</th>
                <th scope="col">Nombre</th>
                <th scope="col">Medida</th>
                <th scope="col">Valor Referencia</th>
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
                        <a class="btn btn-info" href="{{ route('gestion-analisis.edit', $usuario->id) }}">Editar</a>
                        <a class="btn btn-danger" href="{{route('gestion-analisis.destroy', $usuario->id)}}">Borrar</a>
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
