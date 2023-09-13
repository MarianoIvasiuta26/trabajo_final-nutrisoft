@extends('adminlte::page')

@section('title', 'Lista de patologias')

@section('content_header')
    <h1>Lista de Patologías</h1>
@stop

@section('content')

    <a class="btn btn-primary" href="{{route('gestion-patologias.create')}}">Agregar nueva Patología</a>

    <table class="table table-dark table-striped mt-4">
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
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
