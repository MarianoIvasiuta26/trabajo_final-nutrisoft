@extends('adminlte::page')

@section('title', 'Turnos Pendientes')

@section('content_header')
    <h1>Turnos pendientes</h1>
@stop

@section('content')

    @if (session('successConPlanGenerado'))

        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('successConPlanGenerado') }}
            <form action="{{ route('plan-alimentacion.consultarPlanGenerado', ['pacienteId' => session('pacienteId'), 'turnoId' => session('turnoId'), 'nutricionistaId' => session('nutricionistaId')]) }}" method="get">
                @csrf
                <button type="submit" class="btn btn-primary">Consultar Plan</button>
            </form>
        </div>

        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('successConPlanSeguimientoGenerado') }}
            <form action="{{ route('plan-seguimiento.consultarPlanGenerado', ['pacienteId' => session('pacienteId'), 'turnoId' => session('turnoId'), 'nutricionistaId' => session('nutricionistaId')]) }}" method="get">
                @csrf
                <button type="submit" class="btn btn-primary">Consultar Plan</button>
            </form>
        </div>

        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('successConPlanesGenerados') }}
            <form action="{{ route('plan-seguimiento.consultarPlanGenerado', ['pacienteId' => session('pacienteId'), 'turnoId' => session('turnoId'), 'nutricionistaId' => session('nutricionistaId')]) }}" method="get">
                @csrf
                <button type="submit" class="btn btn-primary">Consultar Plan de Segumiento</button>
            </form>
            <form action="{{ route('plan-alimentacion.consultarPlanGenerado', ['pacienteId' => session('pacienteId'), 'turnoId' => session('turnoId'), 'nutricionistaId' => session('nutricionistaId')]) }}" method="get">
                @csrf
                <button type="submit" class="btn btn-info">Consultar Plan de Alimentación</button>
            </form>
        </div>
    @endif

    <div class="card card-dark">
        <div class="card-header">
            <h5>Turnos del día</h5>
        </div>

        <div class="card-body">
            <table id="turnos-dia" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Paciente</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $turnosPendientesEncontrados = false;
                    @endphp

                    @foreach ($turnos as $turno)
                        @if ($turno->fecha == $fechaActual && $turno->estado == 'Pendiente')
                            @foreach ($pacientes as $paciente)
                                @if ($paciente->id == $turno->paciente_id && $turno->estado == 'Pendiente')
                                    @php
                                        $turnosPendientesEncontrados = true;
                                    @endphp
                                    <tr>
                                        <td>
                                        {{ $turno->fecha }}
                                        </td>
                                        <td>
                                            {{ $turno->hora }}
                                        </td>
                                        <td>
                                            {{ $paciente->user->name }} {{ $paciente->user->apellido }}
                                        </td>
                                        <td>
                                            <a class="btn btn-success" href="{{route('gestion-turnos-nutricionista.iniciarConsulta', $turno->id)}}">Iniciar consulta</a>
                                            <form action="{{ route('gestion-turnos-nutricionista.confirmarInasistencia', $turno->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">No asistió</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <div class="card card-dark">
        <div class="card-header">
            <h5>Turnos de la semana</h5>
        </div>

        <div class="card-body">
            <table id="turnos-semana" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Paciente</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $turnosPendientesEncontrados = false;
                    @endphp

                    @foreach ($turnosSemanaPendiente as $turnoSemana)
                        @if ($turnoSemana->fecha != $fechaActual && $turnoSemana->estado == 'Pendiente')
                            @foreach ($pacientes as $paciente)
                                @if ($paciente->id == $turnoSemana->paciente_id && $turnoSemana->estado == 'Pendiente')
                                    @php
                                        $turnosPendientesEncontrados = true;
                                    @endphp
                                    <tr>
                                        <td>
                                        {{ $turnoSemana->fecha }}
                                        </td>
                                        <td>
                                            {{ $turnoSemana->hora }}
                                        </td>
                                        <td>
                                            {{ $paciente->user->name }} {{ $paciente->user->apellido }}
                                        </td>
                                        <td>
                                            <a class="btn btn-success" href="{{route('gestion-turnos-nutricionista.iniciarConsulta', $turno->id)}}">Iniciar consulta</a>
                                            <form action="{{ route('gestion-turnos-nutricionista.confirmarInasistencia', $turno->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">No asistió</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">


@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        //Respuestas Flash del controlador con SweetAlert
        @if (session('successConPlanGenerado'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{session('successConPlanGenerado')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif

        @if (session('successSinPlanGenerado'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{session('successSinPlanGenerado')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif

        @if (session('successPlanConfirmado'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{session('successPlanConfirmado')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif

        @if (session('errorPlanNoEncontrado'))
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: "{{session('errorPlanNoEncontrado')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif

        @if (session('errorPlanNoGenerado'))
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: "{{session('errorPlanNoGenerado')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif

        $(document).ready(function(){
            $('#turnos-dia').DataTable({
                responsive: true,
                autoWidth: false,
                "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ turnos por página",
                    "zeroRecords": "No se encontró ningún turno pendiente para el día de hoy",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay turnos pendientes para el día de hoy",
                    "infoFiltered": "(filtrado de _MAX_ turnos totales)",
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

        $(document).ready(function(){
            $('#turnos-semana').DataTable({
                responsive: true,
                autoWidth: false,
                "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ turnos por página",
                    "zeroRecords": "No se encontró ningún turno pendiente para esta semana",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay turnos pendientes para esta semana",
                    "infoFiltered": "(filtrado de _MAX_ turnos totales)",
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
    </script>
@stop
