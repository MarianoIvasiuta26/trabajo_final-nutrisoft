@extends('adminlte::page')

@section('title', 'Editar usuario')

@section('content_header')
    <h1>Editar usuario</h1>
@stop

@section('content')
    <form action="{{route('gestion-usuarios.update', $usuario->id)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{$usuario->name}}">
        </div>
        <div class="mb-3">
            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido" class="form-control" value="{{$usuario->apellido}}">
        </div>
        <div class="mb-3">
            <label for="tipo_usuario" class="form-label">Rol</label>
            <select name="tipo_usuario" id="tipo_usuario" class="form-control" tabindex="6">
                <option value="Administrador" @if ($usuario->tipo_usuario === 'Administrador') selected @endif>Administrador</option>
                <option value="Nutricionista" @if ($usuario->tipo_usuario === 'Nutricionista') selected @endif>Nutricionista</option>
                <option value="Paciente" @if ($usuario->tipo_usuario === 'Paciente') selected @endif>Paciente</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{$usuario->email}}">
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