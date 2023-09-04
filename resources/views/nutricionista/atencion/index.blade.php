@extends('adminlte::page')

@section('title', 'Lista de usuarios')

@section('content_header')
    <h1>Horas y días de atención</h1>
@stop

@section('content')

    <a class="btn btn-primary" href="{{route('gestion-atencion.consultaForm')}}">Agregar Días y horarios de atención</a>

    <table class="table table-dark table-striped mt-4">
        <thead>
            <tr>
                <th scope="col">Días</th>
                <th scope="col">Hora mañana</th>
                <th scope="col">Hora tarde</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @if ($nutricionista)
                <tr>
                    <td>
                        @foreach ($nutricionista->diasAtencion as $dia)
                            {{ $dia->dia }}
                        @endforeach
                    </td>
                    <td>{{ $nutricionista->hora_inicio_maniana }} - {{ $nutricionista->hora_fin_maniana }}</td>
                    <td>{{ $nutricionista->hora_inicio_tarde }} - {{ $nutricionista->hora_fin_tarde }}</td>
                    <td>
                        <form action="{{ route('gestion-atencion.destroy', $nutricionista->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="Eliminar" class="btn btn-danger">
                        </form>
                    </td>
                </tr>
            @else
                <tr>
                    <td colspan="4">No se encontraron registros de días y horarios de atención.</td>
                </tr>
            @endif
        </tbody>
    </table>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
