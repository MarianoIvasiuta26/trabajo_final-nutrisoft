@extends('adminlte::page')

@section('title', 'NutriSoft')

@section('content_header')
    <h1>Dashboard</h1>
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
