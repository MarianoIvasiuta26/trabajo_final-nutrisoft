@extends('adminlte::page')

@section('title', 'Lista de Grupo de Alimentos')

@section('content_header')
    <h1>Lista de Grupo de Alimentos</h1>
@stop

@section('content')

    <a class="btn btn-primary" href="{{route('gestion-fuentes.create')}}">Agregar nuevo Grupo de Alimento</a>

    <table class="table table-dark table-striped mt-4">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Fuente</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fuentes as $fuente)
                <tr>
                    <td>{{$fuente->id}}</td>
                    <td>{{$fuente->fuente}}</td>
                    <td>
                        <div class="row">
                            <a class="btn btn-info" href="{{ route('gestion-fuentes.edit', $fuente->id) }}">Editar</a>
                            <form action="{{route('gestion-fuentes.destroy', $fuente->id)}}" method="post">
                                <a style="margin-left: 10px;" class="btn btn-danger">Borrar</a>
                            </form>
                        </div>

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
