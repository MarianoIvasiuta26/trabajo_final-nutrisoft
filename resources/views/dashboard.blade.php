@extends('adminlte::page')

@section('title', 'NutriSoft')

@section('content_header')
    <h1></h1>
@stop

@section('content')
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
<!--
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>150</h3>
                        <p>New Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        -->

        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

@stop

@section('js')
    <script>

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

@stop
