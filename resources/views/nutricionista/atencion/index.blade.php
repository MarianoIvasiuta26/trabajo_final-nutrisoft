@extends('adminlte::page')

@section('title', 'Horarios de atención')

@section('content_header')
    <h1>Horas y días de atención</h1>
@stop

@section('content')

    <a class="btn btn-primary" href="{{route('gestion-atencion.consultaForm')}}">Agregar Días y horarios de atención</a>

    <div class="container mt-3">
        <table id="horarios-atencion" class="table table-dark table-striped mt-4">
            <thead>
                <tr>
                    <th scope="col">Días</th>
                    <th scope="col">Horario Mañana</th>
                    <th scope="col">Acciones</th>
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

                @endif
            --}}

                @if (isset($nutricionista))
                    @foreach ($dias as $dia)
                        @if ($dia->seleccionado == true)
                            <tr>
                                <td>{{ $dia->dia }}</td>
                                @php $horarioManana = ''; $horarioTarde = ''; @endphp
                                @foreach ($horarios as $horario)
                                    @if ($horario->dia_atencion_id == $dia->id)
                                        @foreach ($horas as $hora)
                                            @if ($hora->id == $horario->hora_atencion_id)
                                                @if ($hora->etiqueta == 'Maniana')
                                                    @php $horarioManana = $hora->hora_inicio . ' - ' . $hora->hora_fin; @endphp
                                                @elseif ($hora->etiqueta == 'Tarde')
                                                    @php $horarioTarde = $hora->hora_inicio . ' - ' . $hora->hora_fin; @endphp
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                                <td>
                                    @if ($horarioManana)
                                        {{ $horarioManana }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-3">
                                            <form action="{{ route('gestion-atencion.edit', $horario->id) }}" method="GET">
                                                @csrf
                                                <button type="submit" class="btn btn-primary">
                                                    <span class="far fa-edit"></span>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-3">
                                            <form action="{{ route('gestion-atencion.destroy', $horario->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <span class="far fa-trash-alt"></span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if ($horarioTarde)
                                        {{ $horarioTarde }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-3">
                                            <form action="{{ route('gestion-atencion.edit', $horario->id) }}" method="GET">
                                                @csrf
                                                <button type="submit" class="btn btn-primary">
                                                    <span class="far fa-edit"></span>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-3">
                                            <form action="{{ route('gestion-atencion.destroy', $horario->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <span class="far fa-trash-alt"></span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function(){
            var table = $('#horarios-atencion').DataTable({
                responsive: true,
                autoWidth: false,
                "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ turnos por página",
                    "zeroRecords": "No se encontró ningún horario de atención.",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros de horarios de atención.",
                    "infoFiltered": "(filtrado de _MAX_ horarios de atención totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                }
            });
        });

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{session('success')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: "{{session('error')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif
    </script>
@stop
