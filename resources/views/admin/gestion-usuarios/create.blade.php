@extends('adminlte::page')

@section('title', 'Agregar nuevo usuario')

@section('content_header')
    <h1>Agregar nuevo usuario</h1>
@stop

@section('content')
        <form action="{{ route('gestion-usuarios.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" tabindex="2">
        </div>
        <div class="mb-3">
            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido" class="form-control" tabindex="3">
        </div>
        <div class="mb-3">
            <label for="tipo_usuario" class="form-label">Rol</label>
            <select name="tipo_usuario" id="tipo_usuario" class="form-control" tabindex="4">
                <option value="Administrador">Administrador</option>
                <option value="Nutricionista">Nutricionista</option>
                <option value="Paciente">Paciente</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" tabindex="5">
        </div>

        <a href="{{ route('gestion-usuarios.index') }}" class="btn btn-secondary" tabindex="7">Cancelar</a>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

@stop
