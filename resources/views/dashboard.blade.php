@extends('adminlte::page')

@section('title', 'NutriSoft')

@section('content_header')
    <h1></h1>
@stop

@section('content')
    <!--
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>¡Bienvenido, {{auth()->user()->name}}!</strong> Has iniciado sesión correctamente.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                    </div>

                    @if(auth()->user()->tipo_usuario === 'Paciente' && !app('App\Http\Controllers\PacienteController')->hasCompletedHistory())

                        <div class="alert alert-warning" role="alert">
                            Parece que aún no has completado tu Historia Clínica. <br>
                            Haga click en el siguiente enlace para completar su historia clínica:
                            <a href="{{ route('historia-clinica.create') }}" class="alert-link">Completar mi Historia Clínica</a>
                        </div>

                    @endif

                    @if(auth()->user()->tipo_usuario === 'Paciente' && app('App\Http\Controllers\PacienteController')->hasCompletedHistory())
                        @if (!app('App\Http\Controllers\PacienteController')->hasCompletedDatosMedicos() || !app('App\Http\Controllers\PacienteController')->hasCompletedCirugias() || !app('App\Http\Controllers\PacienteController')->hasCompletedAnamnesis())
                            <div class="alert alert-warning" role="alert">
                                Parece que aún no has terminado de completar tu Historia Clínica. Recuerda que es importante que lo completes para tener acceso a todas las funcionalidades del sistema.<br>
                                Haga click en el siguiente enlace para completar su historia clínica:
                                <a href="{{ route('historia-clinica.create') }}" class="alert-link">Continuar completando mi Historia Clínica</a>
                            </div>
                        @endif
                    @endif




                </div>
            </div>
        </div>
    -->

    <div style="padding: 2%;" class="card-header text-white bg-success ">
        <h3 style="text-align: center;">¡Bienvenido, {{ Auth::user()->name }}!</h3>
        <h5 style="text-align: center;">NutriSoft - Sistema de Gestión Nutricional</h5>
    </div>

    
    @role('Nutricionista')
        <div class="row mt-3">
            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ count($turnosPendientes)}}</h3>
                        <p>Turnos pendientes</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{route('gestion-turnos-nutricionista.index')}}" class="small-box-footer">Ir a Turnos <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{count($inasistencias)}}</h3>
                        <p>Inasistencias</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{route('gestion-turnos-nutricionista.showHistorialTurnos')}}" class="small-box-footer">Historial turnos <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{count($consultas)}}</h3>
                        <p>Consultas brindadas</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{route('gestion-turnos-nutricionista.showHistorialTurnos')}}" class="small-box-footer">Ver consultas <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{count($turnosCancelados)}}</h3>
                        <p>Turnos cancelados</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{route('gestion-turnos-nutricionista.showHistorialTurnos')}}" class="small-box-footer">Historial turnos <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{count($planesAlimentacionAConfirmar)}}</h3>
                        <p>Planes alimentación a confirmar</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{route('plan-alimentacion.planesAlimentacionAConfirmar')}}" class="small-box-footer">Planes de alimentación <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-6">
                <div class="small-box bg-dark   ">
                    <div class="inner">
                        <h3>{{count($planesSeguimientoAConfirmar)}}</h3>
                        <p>Planes seguimiento a confirmar</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{route('plan-seguimiento.planesSeguimientoAConfirmar')}}" class="small-box-footer">Planes de Seguimiento <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="card card-dark mt-3">
            <div class="card-header">
                <h5 class="card-title">Turnos del día</h5>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget = "collapse" title= "collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                @if(count($turnosDelDia) > 0)
                    <table class="table table-striped table-hover" id="tabla-turnos-hoy">
                        <thead>
                        <tr>
                            <th scope="col">Paciente</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Hora</th>
                            <th scope="col">Estado</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($turnosDelDia as $turno)
                            <tr>
                                <td>{{$turno->paciente->user->apellido}}, {{$turno->paciente->user->name}}</td>
                                <td>{{$turno->fecha}}</td>
                                <td>{{$turno->hora}}</td>
                                <td>{{$turno->estado}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info">
                        No hay turnos para mostrar.
                    </div>
                @endif
            </div>
        </div>
    @endrole

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

@stop

@section('js')
    <script>

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function(){
            $('#tabla-turnos-hoy').DataTable({
                responsive: false,
                autoWidth: false,
                "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_",
                    "zeroRecords": "No se encontró ningún registro",
                    "info": "",
                    "infoEmpty": "No hay registros",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
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
