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

        @foreach ($turnos as $turno)
            @if ($turno->paciente_id == $paciente->id)
                @if ($turno->estado == 'Pendiente')
                    <div class="alert alert-warning" role="alert">
                        <h5>Turno pendiente</h5>
                        Usted tiene un turno pendiente para el día {{ $turno->fecha }} a las {{ $turno->hora }} hs.
                        <br>Para cancelar el turno, haga click en el siguiente enlace:
                        <br><a href="{{ route('turnos.destroy', $turno->id) }}" class="alert-link">Cancelar turno</a>
                    </div>
                @endif
            @endif

        @endforeach

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
                        <th scope="col">Tipo de consulta</th>
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
                                <td>
                                    @foreach ($tipo_consultas as $tipoConsulta)
                                        @if ($tipoConsulta->id == $turno->tipo_consulta_id)
                                            {{ $tipoConsulta->tipo_consulta }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $turno->estado }}</td>
                                <td>
                                    <a href="{{ route('turnos.show', $turno->id) }}" class="btn btn-primary">Ver</a>
                                    @if ($turno->estado == 'Pendiente')
                                        <a href="{{ route('turnos.edit', $turno->id) }}" class="btn btn-warning">Editar</a>
                                    @endif
                                    @if ($turno->estado == 'Pendiente')
                                        <form action="{{ route('turnos.destroy', $turno->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Cancelar</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="5">No hay turnos registrados</td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>
            </div>
    @endif

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@stop
