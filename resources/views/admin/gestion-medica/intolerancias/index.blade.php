@extends('adminlte::page')

@section('title', 'Lista de intolerancias')

@section('content_header')
    <h1>Lista de Intolerancias</h1>
@stop

@section('content')

    <a class="btn btn-primary" href="{{route('gestion-intolerancias.create')}}">Agregar nueva Intolerancia</a>

    <table class="table table-dark table-striped mt-4">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Intolerancia</th>
                {{--<th scope="col">Alimentos Prohibidos</th>
                <th scope="col">Actividades Prohibidas</th>--}}
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($intolerancias as $intolerancia)
                <tr>
                    <td>{{$intolerancia->id}}</td>
                    <td>{{$intolerancia->intolerancia}}</td>
                    <td>
                        <a class="btn btn-info" href="{{ route('gestion-intolerancias.edit', $intolerancia->id) }}">Editar</a>
                        <a class="btn btn-danger" href="{{route('gestion-intolerancias.destroy', $intolerancia->id)}}">Borrar</a>
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
