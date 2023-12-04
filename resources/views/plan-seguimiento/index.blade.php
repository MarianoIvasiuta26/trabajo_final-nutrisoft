@extends('adminlte::page')

@section('title', 'Mis Planes de Seguimiento')

@section('content_header')
@stop

@section('content')


    <div class="card card-dark mt-3">
        <div class="card-header">
            <h5>Mis planes de Seguimiento</h5>
        </div>

        <div class="card-body">
            <table id="mis-planes" class="table table-striped">
                <thead>
                    <tr>
                        <th>Fecha de Generación</th>
                        <th>Profesional</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($planesPaciente as $plan)
                        @if ($plan->estado != 2)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($plan->consulta->turno->fecha)->format('d/m/Y')}}</td>
                                <td>{{ $plan->consulta->nutricionista->user->apellido }}, {{ $plan->consulta->nutricionista->user->name }}</td>
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
    <!-- Moment.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <!-- datetime-moment CDN -->
    <script src="https://cdn.datatables.net/datetime-moment/2.6.1/js/dataTables.dateTime.min.js"></script>

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

        //Datatable historial de planes
        $(document).ready(function(){
            $('#mis-planes').DataTable({
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
                },
                "order": [
                    [0, 'desc'] // Columna 0 (Fecha de Generación) en orden descendente
                ],
                columnDefs: [
                    {
                        targets: 0, // Índice de la columna de fecha
                        type: 'datetime-moment',
                        render: function (data, type, row) {
                            return type === 'sort' ? moment(data, 'DD-MM-YYYY').format('YYYY-MM-DD') : data;
                        }
                    },
                    {
                        targets: 2, // Índice de la columna de estado
                        render: function (data, type, row) {
                            if (data === 'Inactivo') {
                                return 0; // Asigna un valor numérico para ordenar
                            } else if (data === 'Activo') {
                                return 1; // Asigna un valor numérico para ordenar
                            }
                            return data;
                        }
                    }
                ]
            });
        });

         //SweetAlert Confirmar plan
         document.addEventListener('DOMContentLoaded', function () {
            const confirmarPlan = document.querySelectorAll('.confirmar-button');

            confirmarPlan.forEach(button => {
                button.addEventListener('click', function () {
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: true
                        })

                        swalWithBootstrapButtons.fire({
                        title: '¿Está seguro de guardar el plan de alimentación generado?',
                        text: "Al confirmar se asociará el plan al paciente correspondiente.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: '¡Confirmar plan!',
                        confirmButtonColor: '#3085d6',
                        cancelButtonText: '¡No, cancelar!',
                        cancelButtonColor: '#d33',
                        reverseButtons: true
                        }).then((result) => {
                        if (result.isConfirmed) {
                            //Envia el form
                            const form = document.getElementById('confirmar-form');
                            form.submit();
                        } else if (
                            /* Read more about handling dismissals below */
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            swalWithBootstrapButtons.fire(
                            '¡No se guardó el plan de alimentación!',
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
