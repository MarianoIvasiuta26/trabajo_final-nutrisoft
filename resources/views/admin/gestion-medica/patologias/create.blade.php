@extends('adminlte::page')

@section('title', 'Agregar nueva Patología')

@section('content_header')
    <h1>Agregar nueva Patología</h1>
@stop

@section('content')
    <div class="card card-dark">
        <div class="card-header">
            <h5>Nueva Patología</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('gestion-patologias.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="patologia" class="form-label">Patología</label>
                    <input type="text" name="patologia" id="patologia" class="form-control" tabindex="2">
                </div>
                <div class="mb-3">
                    <label for="grupo_patologia">Grupo Patología</label>
                    <input type="text" name="grupo_patologia" id="grupo_patologia" class="form-control" tabindex="3">
                </div>
                {{--<div class="mb-3">
                    <label for="tipo_usuario" class="form-label">Alimentos prohibidos</label>
                    <select name="alimentos_prohibidos[]" class="form-select" id="alimentos_prohibidos" data-placeholder="Alimentos prohibidos..." multiple>
                    <select name="tipo_usuario" id="tipo_usuario" class="form-control" tabindex="4">
                        @foreach ($alimentos_prohibidos as $alimento)
                            <option value="{{ $alimento->alimento }}">{{ $alimento->alimento }}</option>
                        @endforeach
                    </select>
                </div>--}}

                <a href="{{ route('gestion-patologias.index') }}" class="btn btn-secondary" tabindex="7">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@stop
