@extends('adminlte::page')

@section('title', 'Turnos Pendientes')

@section('content_header')
@stop

@section('content')


    <div class="card card-dark mt-3">
        <div class="card-header">
            <h5>Planes de alimentación por confirmar</h5>
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
                            <td>{{ \Carbon\Carbon::parse($plan->created_at)->format('d/m/Y')}}</td>
                            <td>{{ $plan->paciente->user->apellido }}, {{ $plan->paciente->user->name }}</td>
                            <td>
                                <form action="{{ route('plan-alimentacion.consultarPlanGenerado', ['pacienteId'=>$plan->paciente_id, 'turnoId' => $plan->consulta->turno->id, 'nutricionistaId' => $plan->consulta->nutricionista_id]) }}" method="GET" style="display: inline-block;">
                                    @csrf

                                    <button class="btn btn-primary btn-sm" type="submit">Ver</button>
                                </form>

                                <form action="#" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('PUT')

                                    <button type="submit" class="btn btn-success btn-sm">Confirmar</button>
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
            <h5>Historial de Planes de alimentación generados</h5>
        </div>

        <div class="card-body">
            <table id="planes-confirmacion" class="table table-striped">
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
                                <td>{{ \Carbon\Carbon::parse($plan->created_at)->format('d/m/Y')}}</td>
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
                                    <form action="{{ route('plan-alimentacion.consultarPlanGenerado', ['pacienteId'=>$plan->paciente_id, 'turnoId' => $plan->consulta->turno->id, 'nutricionistaId' => $plan->consulta->nutricionista_id]) }}" method="GET" style="display: inline-block;">
                                        @csrf

                                        <button class="btn btn-primary btn-sm" type="submit">Ver</button>
                                    </form>
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

    </script>
@stop
