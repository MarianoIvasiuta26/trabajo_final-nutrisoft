@extends('adminlte::page')

@section('title', 'Planes de Seguimiento')

@section('content_header')
@stop

@section('content')


    <div class="card card-dark mt-3">
        <div class="card-header">
            <h5>Planes de seguimiento por confirmar</h5>
        </div>

        <div class="card-body">
            <table id="planes-confirmacion" class="table table-striped">
                <thead>
                    <tr>
                        <th>Fecha de Generación</th>
                        <th>Paciente correspondiente</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($planesAConfirmar as $plan)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($plan->consulta->turno->fecha)->format('d/m/Y')}}</td>
                            <td>{{ $plan->paciente->user->apellido }}, {{ $plan->paciente->user->name }}</td>
                            <td>
                                <form action="{{ route('plan-seguimiento.consultarPlanGenerado', ['pacienteId'=>$plan->paciente_id, 'turnoId' => $plan->consulta->turno->id, 'nutricionistaId' => $plan->consulta->nutricionista_id]) }}" method="GET" style="display: inline-block;">
                                    @csrf

                                    <button class="btn btn-primary btn-sm" type="submit">
                                        <i class="bi bi-eye"></i>
                                        Ver
                                    </button>
                                </form>

                                <form id="confirmar-form" action="{{route('plan-seguimiento.confirmarPlan', $plan->id)}}" method="POST" class="d-inline-block">
                                    @csrf

                                    <button type="button" class="btn btn-success btn-sm confirmar-button">Confirmar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card card-dark mt-3">
        <div class="card-header">
            <h5>Historial de Planes de seguimiento generados</h5>
        </div>

        <div class="card-body">
            <table id="historial-planes" class="table table-striped">
                <thead>
                    <tr>
                        <th>Fecha de Generación</th>
                        <th>Paciente correspondiente</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($planesGenerados as $plan)
                        @if ($plan->estado != 2)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($plan->consulta->turno->fecha)->format('d/m/Y')}}</td>
                                <td>{{ $plan->paciente->user->apellido }}, {{ $plan->paciente->user->name }}</td>
                                <td>
                                    @if ($plan->estado == 0)
                                        <span class="badge bg-warning">Inactivo</span>
                                    @endif

                                    @if ($plan->estado == 1)
                                        <span class="badge bg-success">Activo</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('plan-seguimiento.show', $plan->id) }}" method="GET" style="display: inline-block;">
                                        @csrf

                                        <button class="btn btn-primary btn-sm" type="submit">
                                            <i class="bi bi-eye"></i>
                                            Ver
                                        </button>
                                    </form>
                                    <a href="{{ route('plan-seguimiento.pdf', $plan->id) }}" target="_blank" class="btn btn-secondary btn-sm">
                                        <i class="bi bi-printer"></i>
                                        Imprimir
                                    </a>
                                </td>
                            </tr>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

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
        @if (session('errorPlanNoEncontrado'))
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: "{{session('errorPlanNoEncontrado')}}",
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

        //Datatable planes a confirmar
        $(document).ready(function(){
            $('#planes-confirmacion').DataTable({
                responsive: true,
                autoWidth: false,
                "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ planes por página",
                    "zeroRecords": "No se encontró ningún plan de alimentación pendiente para su confirmación.",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay planes de alimentación pendientes para su confirmación.",
                    "infoFiltered": "(filtrado de _MAX_ planes totales)",
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

        //Datatable historial de planes
        $(document).ready(function(){
            $('#historial-planes').DataTable({
                responsive: true,
                autoWidth: false,
                "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ planes por página",
                    "zeroRecords": "No se encontró ningún plan de seguimiento.",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay planes de seguimiento existentes.",
                    "infoFiltered": "(filtrado de _MAX_ planes totales)",
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
