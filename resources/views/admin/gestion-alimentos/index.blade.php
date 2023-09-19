@extends('adminlte::page')

@section('title', 'Lista de alimentos')

@section('content_header')
    <h1>Lista de Alimentos</h1>
@stop

@section('content')

    <a class="btn btn-primary" href="gestion-alimentos/create">Agregar nuevo alimento</a>

    <table class="table table-dark table-striped mt-4">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Alimento</th>
                <th scope="col">Grupo de alimento</th>
                <th scope="col">Fuente</th>
                <th scope="col">Estacional</th>
                <th scope="col">Estacion</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alimentos as $alimento)
                <tr>
                    <td>{{$alimento->id}}</td>
                    <td>{{$alimento->alimento}}</td>
                    <td>{{$alimento->grupo_alimento}}</td>
                    <td>{{$alimento->fuente}}</td>
                    <td>{{$alimento->estacional}}</td>
                    <td>{{$alimento->estacion}}</td>
                    <td>
                        <div class="row">
                            <div class="col">
                                <a class="btn btn-info" href="{{ route('gestion-alimentos.edit', $usuario->id) }}">Editar</a>
                            </div>
                            <div class="col">
                                <form action="{{ route('gestion-alimentos.destroy', $usuario->id) }}" method="POST">
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
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
