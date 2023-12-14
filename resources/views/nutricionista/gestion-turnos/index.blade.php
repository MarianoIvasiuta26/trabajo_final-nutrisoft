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
    @endif

    @if (session('successConPlanSeguimientoGenerado'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('successConPlanSeguimientoGenerado') }}
            <form action="{{ route('plan-seguimiento.consultarPlanGenerado', ['pacienteId' => session('pacienteId'), 'turnoId' => session('turnoId'), 'nutricionistaId' => session('nutricionistaId')]) }}" method="get">
                @csrf
                <button type="submit" class="btn btn-primary">Consultar Plan</button>
            </form>
        </div>
    @endif

    @if (session('successConPlanesGenerados'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('successConPlanesGenerados') }}
            <div class="row mt-3">
                <div class="col-auto">
                    <form action="{{ route('plan-alimentacion.planesAlimentacionAConfirmar')}}" method="get">
                        @csrf
                        <button type="submit" class="btn btn-primary">Sección planes de alimentación</button>
                    </form>
                </div>

                <div class="col-auto">
                    <form action="{{ route('plan-seguimiento.planesSeguimientoAConfirmar') }}" method="get">
                        @csrf
                        <button type="submit" class="btn btn-info">Sección planes de seguimiento</button>
                    </form>
                </div>
            </div>

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
                        <th scope="col">Motivo</th>
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
                                        {{ \Carbon\Carbon::parse($turno->fecha)->format('d-m-Y') }}
                                        </td>
                                        <td>
                                            {{ $turno->hora }}
                                        </td>
                                        <td>
                                            {{ $paciente->user->name }} {{ $paciente->user->apellido }}
                                        </td>
                                        <td>
                                            {{ $turno->motivo_consulta }}
                                        </td>
                                        <td>
                                            <a class="btn btn-success" href="{{route('gestion-turnos-nutricionista.iniciarConsulta', $turno->id)}}">Iniciar consulta</a>
                                            <form id="inasistencia-form" action="{{ route('gestion-turnos-nutricionista.confirmarInasistencia', $turno->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                <button type="button" class="btn btn-danger marcar-inasistencia">No asistió</button>
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
            <h5>Turnos pendientes</h5>
        </div>

        <div class="card-body">
            <table id="turnos-semana" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Paciente</th>
                        <th scope="col">Motivo</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $turnosPendientesEncontrados = false;
                    @endphp

                    @foreach ($turnos as $turno)
                        @if ($turno->fecha != $fechaActual && $turno->estado == 'Pendiente')
                            @foreach ($pacientes as $paciente)
                                @if ($paciente->id == $turno->paciente_id && $turno->estado == 'Pendiente')
                                    @php
                                        $turnosPendientesEncontrados = true;
                                    @endphp
                                    <tr>
                                        <td>
                                        {{ \Carbon\Carbon::parse($turno->fecha)->format('d-m-Y') }}
                                        </td>
                                        <td>
                                            {{ $turno->hora }}
                                        </td>
                                        <td>
                                            {{ $paciente->user->name }} {{ $paciente->user->apellido }}
                                        </td>
                                        <td>
                                            {{ $turno->motivo_consulta }}
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
    <!-- Moment.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <!-- datetime-moment CDN -->
    <script src="https://cdn.datatables.net/datetime-moment/2.6.1/js/dataTables.dateTime.min.js"></script>

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

        @if (session('successConPlanesGenerados'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{session('successConPlanesGenerados')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif

        @if (session('successConPlanSeguimientoGenerado'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{session('successConPlanSeguimientoGenerado')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{session('success')}}",
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

        @if (session('errorPlanesNoGenerados'))
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: "{{session('errorPlanesNoGenerados')}}",
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
                },
                order: [[ 0, "desc" ]],
                columnDefs: [
                    {
                        targets: 0, // Índice de la columna de fecha
                        type: 'datetime-moment',
                        render: function (data, type, row) {
                            return type === 'sort' ? moment(data, 'DD-MM-YYYY').format('YYYY-MM-DD') : data;
                        }
                    }
                ]
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
                },
                order: [[ 0, "asc" ]],
                columnDefs: [
                    {
                        targets: 0, // Índice de la columna de fecha
                        type: 'datetime-moment',
                        render: function (data, type, row) {
                            return type === 'sort' ? moment(data, 'DD-MM-YYYY').format('YYYY-MM-DD') : data;
                        }
                    }
                ]
            });
        });

        //SweetAlert Confirmar inasistencia
        document.addEventListener('DOMContentLoaded', function () {
            const confirmarInasistencia = document.querySelectorAll('.marcar-inasistencia');

            confirmarInasistencia.forEach(button => {
                button.addEventListener('click', function () {
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: true
                        })

                        swalWithBootstrapButtons.fire({
                        title: '¿Está seguro de marcar la inasistencia del paciente?',
                        text: "Al confirmar no se podrá modificar el estado del turno.",
                        icon: 'question',
                        showCancelButton: true,
                        cancelButtonText: '¡No, cancelar!',
                        confirmButtonColor: '#198754',
                        confirmButtonText: '¡Confirmar inasistencia!',
                        cancelButtonColor: '#d33',
                        reverseButtons: true
                        }).then((result) => {
                        if (result.isConfirmed) {
                            //Envia el form
                            const form = document.getElementById('inasistencia-form');
                            form.submit();
                        } else if (
                            /* Read more about handling dismissals below */
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            swalWithBootstrapButtons.fire(
                            '¡No se marcó la inasistencia!',
                            'El plan aún no se asoció al paciente, puede realizar modificaciones en el mismo.',
                            'error'
                            )
                        }
                    })
                });
            });
        });
    </script>
@stop
