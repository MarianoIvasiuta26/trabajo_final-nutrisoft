@extends('adminlte::page')

@section('title', 'Lista de Nutrientes')

@section('content_header')
    <h1>Lista de Nutrientes</h1>
@stop

@section('content')

    <a class="btn btn-primary" href="{{route('gestion-nutrientes.create')}}">Agregar nuevo Nutriente</a>

    <table class="table table-dark table-striped mt-4">
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
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
