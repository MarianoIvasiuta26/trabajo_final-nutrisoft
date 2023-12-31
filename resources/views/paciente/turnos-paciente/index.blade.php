@extends('adminlte::page')

@section('title', 'Mis turnos')

@section('content_header')

@stop

@section('content')

    @if(auth()->user()->tipo_usuario === 'Paciente' && !app('App\Http\Controllers\PacienteController')->hasCompletedHistory())

        <div class="alert alert-warning mt-3" role="alert">
            <h5>Registro incompleto</h5>
            Parece que aún no ha completado su registro. <br>
            Para tener acceso a esta funcionalidad del sistema, necesita completar el registro. <br>
            Haga click en el siguiente enlace para completar:
            <br><a href="{{ route('historia-clinica.create') }}" class="alert-link">Completar registro</a>
        </div>

    @else

        @foreach ($turnos as $turno)
            @if ($turno->paciente_id == $paciente->id)
                @if ($turno->estado == 'Pendiente')
                    <div class="alert alert-warning mt-3" role="alert">
                        <h5>Turno pendiente</h5>
                        Usted tiene un turno pendiente para el día {{ \Carbon\Carbon::parse($turno->fecha)->format('d-m-Y') }} a las {{ $turno->hora }} hs.
                        <br>Para cancelar el turno, haga click en el siguiente botón:
                        <br>
                        <form action="{{ route('turnos.destroy', $turno->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger cancelar-turno-button mt-3">Cancelar turno</button>
                        </form>
                    </div>
                @endif
            @endif

        @endforeach

        <div class="card card-dark mt-3">
            <div class="card-header">
                <h3>Historial de Turnos</h3>
            </div>
            <div class="card-body">
                <table id="tabla-mis-turnos" class="table table-striped" id="turnos">
                    <thead>
                    <tr>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Tipo de consulta</th>
                        <th scope="col">Motivo de consulta</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($turnos as $turno)
                        @if ($turno->paciente_id == $paciente->id)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($turno->fecha)->format('d/m/Y') }}</td>
                                <td>{{ $turno->hora }}</td>
                                <td>
                                    @foreach ($tipo_consultas as $tipoConsulta)
                                        @if ($tipoConsulta->id == $turno->tipo_consulta_id)
                                            {{ $tipoConsulta->tipo_consulta }}
                                        @endif
                                    @endforeach
                                </td>
                                <td> {{ $turno->motivo_consulta }} </td>

                                <td>
                                    <span class="badge bg-{{$turno->estado == 'Cancelado' ? 'danger' : ($turno->estado == 'Realizado' ? 'success' : ($turno->estado == 'Inasistencia' ? 'secondary' : 'warning'))}}">
                                        {{ $turno->estado }}
                                    </span>
                                </td>

                                <td>
                                    @if ($turno->estado == 'Realizado')
                                        <a href="{{ route('turnos.show', $turno->id) }}" class="btn btn-primary btn-sm">Ver</a>
                                    @endif
                                {{--   @if ($turno->estado == 'Pendiente')
                                        <a href="{{ route('turnos.edit', $turno->id) }}" class="btn btn-warning">Editar</a>
                                    @endif--}}
                                    @if ($turno->estado == 'Pendiente')
                                        <form action="{{ route('turnos.destroy', $turno->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm cancelar-turno-button">Cancelar</button>
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
    <!-- Moment.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <!-- datetime-moment CDN -->
    <script src="https://cdn.datatables.net/datetime-moment/2.6.1/js/dataTables.dateTime.min.js"></script>

    <script>

//Respuestas Flash del controlador con SweetAlert
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

        @if(session('info'))
            Swal.fire({
                icon: 'info',
                title: '¡Información!',
                text: "{{session('info')}}",
                showConfirmButton: false,
                timer: 3000
            })
        @endif

        $(document).ready(function() {
            $('[data-bs-toggle="popover"]').popover();
        });

        $(document).ready(function(){
            var table = $('#tabla-mis-turnos').DataTable({
                responsive: true,
                autoWidth: false,
                "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ turnos por página",
                    "zeroRecords": "No se encontró ningún turno",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros de turnos",
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

         //SweetAlert
        /*
        document.addEventListener('DOMContentLoaded', function () {
            const cancelarButtons = document.querySelectorAll('.cancelar-turno-button');

            cancelarButtons.forEach(button => {
                button.addEventListener('click', function () {
                    Swal.fire({
                        title: '¿Estás seguro de cancelar el turno?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#198754',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, cancelar turno',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                        }).then((result) => {
                        if (result.isConfirmed) {
                            //Envia el form
                            const form = this.closest('form');
                            form.submit();
                        }
                    })
                });
            });
        });
        */

    </script>
@stop
