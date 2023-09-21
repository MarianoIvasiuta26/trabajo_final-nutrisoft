@extends('adminlte::page')

@section('title', 'Mis turnos')

@section('content_header')
    <h1>Mis Turnos - {{auth()->user()->name}}</h1>
@stop

@section('content')

    @if(auth()->user()->tipo_usuario === 'Paciente' && !app('App\Http\Controllers\PacienteController')->hasCompletedHistory())

        <div class="alert alert-warning" role="alert">
            <h5>Historia Clínica icompleta</h5>
            Parece que aún no has completado tu Historia Clínica. <br>
            Para tener acceso a esta funcionalidad del sistema, necesita completar su historia clínica. <br>
            Haga click en el siguiente enlace para completar su historia clínica:
            <br><a href="{{ route('historia-clinica.create') }}" class="alert-link">Completar mi Historia Clínica</a>
        </div>

    @else

        <div class="card card-dark">
            <div class="card-header">
                <h5>Historial de Turnos</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="turnos">
                    <thead>
                    <tr>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Especialidad</th>
                        <th scope="col">Profesional</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($turnos as $turno)
                        @if ($turno->paciente_id == $paciente->id)
                            <tr>
                                <td>{{ $turno->fecha }}</td>
                                <td>{{ $turno->hora }}</td>
                                <td>{{ $turno->especialidad }}</td>
                                <td>{{ $turno->profesional }}</td>
                                <td>{{ $turno->estado }}</td>
                                <td>
                                    <a href="{{ route('turnos.show', $turno->id) }}" class="btn btn-primary">Ver</a>
                                    <a href="{{ route('turnos.edit', $turno->id) }}" class="btn btn-warning">Editar</a>
                                    <form action="{{ route('turnos.destroy', $turno->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>

                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="6">No hay turnos registrados</td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>
            </div>
    @endif

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
