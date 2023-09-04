@extends('adminlte::page')

@section('title', 'Agregar nuevo usuario')

@section('content_header')
    <h1>Registrars días y horarios de atención</h1>
@stop

@section('content')
        <form action="{{ route('gestion-atencion.guardarHorarios') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Días de Atención</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="dias_atencion[]" value="Lunes" id="lunes">
                <label class="form-check-label" for="lunes">Lunes</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="dias_atencion[]" value="Martes" id="martes">
                <label class="form-check-label" for="martes">Martes</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="dias_atencion[]" value="Miércoles" id="miercoles">
                <label class="form-check-label" for="miercoles">Miércoles</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="dias_atencion[]" value="Jueves" id="jueves">
                <label class="form-check-label" for="jueves">Jueves</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="dias_atencion[]" value="Viernes" id="viernes">
                <label class="form-check-label" for="viernes">Viernes</label>
            </div>

        </div>

        <div class="mb-3">
            <label for="hora_inicio_maniana" class="form-label">Hora de Inicio (Mañana)</label>
            <input type="time" name="hora_inicio_maniana" id="hora_inicio_maniana" class="form-control">
        </div>

        <div class="mb-3">
            <label for="hora_fin_maniana" class="form-label">Hora de Fin (Mañana)</label>
            <input type="time" name="hora_fin_maniana" id="hora_fin_maniana" class="form-control">
        </div>

        <div class="mb-3">
            <label for="hora_inicio_tarde" class="form-label">Hora de Inicio (Tarde)</label>
            <input type="time" name="hora_inicio_tarde" id="hora_inicio_tarde" class="form-control">
        </div>

        <div class="mb-3">
            <label for="hora_fin_tarde" class="form-label">Hora de Fin (Tarde)</label>
            <input type="time" name="hora_fin_tarde" id="hora_fin_tarde" class="form-control">
        </div>



        <a href="{{ route('gestion-atencion.index') }}" class="btn btn-secondary" tabindex="7">Cancelar</a>
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
