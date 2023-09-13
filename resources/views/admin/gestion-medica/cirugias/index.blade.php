@extends('adminlte::page')

@section('title', 'Lista de cirugías')

@section('content_header')
    <h1>Lista de Cirugías</h1>
@stop

@section('content')

    <a class="btn btn-primary" href="{{route('gestion-cirugias.create')}}">Agregar nueva Cirugía</a>

    <table class="table table-dark table-striped mt-4">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Cirugía</th>
                <th scope="col">Grupo Cirugía</th>
                {{--<th scope="col">Alimentos Prohibidos</th>
                <th scope="col">Actividades Prohibidas</th>--}}
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cirugias as $cirugia)
                <tr>
                    <td>{{$cirugia->id}}</td>
                    <td>{{$cirugia->cirugia}}</td>
                    <td>{{$cirugia->grupo_cirugia}}</td>
                    <td>
                        <a class="btn btn-info" href="{{ route('gestion-cirugias.edit', $cirugia->id) }}">Editar</a>
                        <a class="btn btn-danger" href="{{route('gestion-cirugias.destroy', $cirugia->id)}}">Borrar</a>
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
