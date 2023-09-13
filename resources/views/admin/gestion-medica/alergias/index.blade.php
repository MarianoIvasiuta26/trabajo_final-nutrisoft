@extends('adminlte::page')

@section('title', 'Lista de alergias')

@section('content_header')
    <h1>Lista de Alergias</h1>
@stop

@section('content')

    <a class="btn btn-primary" href="{{route('gestion-alergias.create')}}">Agregar nueva Alergia</a>

    <table class="table table-dark table-striped mt-4">
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
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
