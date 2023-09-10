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
                <th scope="col">Horario Mañana</th>
                <th scope="col">Horario Tarde</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            {{--
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
            @endif--}}

            {{--
            @if (isset($nutricionista))
                @if ($nutricionista->horariosAtencion->count() > 0)
                    @foreach ($nutricionista->horariosAtencion as $horario)
                        <tr>
                            <td>
                                @if ($horario->diasAtencion)
                                    @foreach ($horario->diasAtencion as $dia)
                                        {{ $dia->dia }}
                                    @endforeach
                                @endif
                            </td>

                            <td>
                                @if ($horario->hora_atencion_id->count() > 0)
                                    @if ($horario->horasAtencion->etiqueta == 'Maniana')
                                        {{ $horario->horasAtencion->hora_inicio }} - {{ $horario->horasAtencion->hora_fin }}
                                    @endif
                                @endif

                            </td>

                            <td>
                                @if ($horario->horasAtencion->etiqueta == 'Tarde')
                                    {{ $horario->horasAtencion->hora_inicio }} - {{ $horario->horasAtencion->hora_fin }}
                                @endif
                            </td>

                            <td>
                                <form action="{{ route('gestion-atencion.destroy', $nutricionista->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="Eliminar" class="btn btn-danger">
                                </form>
                            </td>
                        </tr>
                    @endforeach

                @else
                    <tr>
                        <td colspan="4">No se encontraron registros de días y horarios de atención.</td>
                    </tr>
                @endif
            @else

            @endif --}}

            @if (isset($nutricionista))

                    @forelse ($horarios as $horario)
                        <tr>
                            <td>
                                @forelse ($dias as $dia)
                                    @if ($dia->id == $horario->dia_atencion_id)
                                        {{ $dia->dia }}
                                    @endif
                                @empty
                                   <h5> No hay días de atención</h5>
                                @endforelse
                            </td>

                            <td>
                                @foreach ($horas as $hora)
                                    @if ($hora->etiqueta == 'Maniana' && $horario->hora_atencion_id == $hora->id)
                                        {{ $hora->hora_inicio }} - {{ $hora->hora_fin }}
                                    @endif
                                @endforeach
                            </td>

                            <td>
                                @foreach ($horas as $hora)
                                    @if ($hora->etiqueta == 'Tarde' && $horario->hora_atencion_id == $hora->id)
                                        {{ $hora->hora_inicio }} - {{ $hora->hora_fin }}
                                    @endif
                                @endforeach
                            </td>

                            <td>
                                <form action="{{ route('gestion-atencion.destroy', $nutricionista->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="Eliminar" class="btn btn-danger">
                                </form>
                            </td>
                        </tr>
                    @empty
                        <td colspan="4">No se encontraron registros de días y horarios de atención.</td>
                    @endforelse
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
