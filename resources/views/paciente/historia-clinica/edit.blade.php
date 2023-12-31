@extends('adminlte::page')

@section('title', 'Mi Historia Clínica')

@section('content_header')

@stop

@section('content')
    <div class="col-md-12">
        <div class="card card-dark">
            <div class="card-header">
                <h5>Datos Físicos</h5>
            </div>
            <div id="datosFisicos" class="card-body">
                <form action="{{route('historia-clinica.update', $historiaClinica->id)}}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <label for="peso" class="form-label">Peso</label>
                            <div class="input-group">
                                <input value="{{$historiaClinica->peso}}" class="form-control" name="peso" id="peso" type="text">
                                <div class="input-group-append">
                                    <span class="input-group-text">kg</span>
                                </div>
                            </div>
                            @error('altura')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="altura" class="form-label">Altura</label>
                            <div class="input-group">
                                <input value="{{$historiaClinica->altura}}" class="form-control" name="altura" id="altura" type="text">
                                <div class="input-group-append">
                                    <span class="input-group-text">cm</span>
                                </div>
                            </div>
                            @error('altura')
                                <span class="text-danger">{{$message}}</span>
                            @enderror

                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label for="circ_munieca" class="form-label">Circunferencia de Muñeca</label>
                            <div class="input-group">
                                <input value="{{$historiaClinica->circunferencia_munieca}}" class="form-control" name="circ_munieca" id="circ_munieca" type="text">
                                <div class="input-group-append">
                                    <span class="input-group-text">cm</span>
                                </div>
                            </div>
                            @error('circ_munieca')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="circ_cintura" class="form-label">Circunferencia de Cintura</label>
                            <div class="input-group">
                                <input value="{{$historiaClinica->circunferencia_cintura}}" class="form-control" name="circ_cintura" id="circ_cintura" type="text">
                                <div class="input-group-append">
                                    <span class="input-group-text">cm</span>
                                </div>
                            </div>
                            @error('circ_munieca')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="circ_cadera" class="form-label">Circunferencia de Cadera</label>
                            <div class="input-group">
                                <input value="{{$historiaClinica->circunferencia_cadera}}" class="form-control" name="circ_cadera" id="circ_cadera" type="text">
                                <div class="input-group-append">
                                    <span class="input-group-text">cm</span>
                                </div>
                            </div>
                            @error('circ_munieca')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="circ_pecho" class="form-label">Circunferencia de Pecho</label>
                            <div class="input-group">
                                <input value="{{$historiaClinica->circunferencia_pecho}}" class="form-control" name="circ_pecho" id="circ_pecho" type="text">
                                <div class="input-group-append">
                                    <span class="input-group-text">cm</span>
                                </div>
                            </div>
                            @error('circ_pecho')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="estilo_vida" class="form-label">Estilo de vida actual</label>
                            <select id="estilo_vida" class="form-select @error('estilo_vida') is-invalid @enderror" name="estilo_vida">
                                <option value="">Elija una opción...</option>
                                <option value="Sedentario" @if ($historiaClinica->estilo_vida == 'Sedentario') selected @endif>Sedentario</option>
                                <option value="Ligeramente activo" @if ($historiaClinica->estilo_vida == 'Ligeramente activo') selected @endif>Ligeramente activo</option>
                                <option value="Moderadamente activo" @if ($historiaClinica->estilo_vida == 'Moderadamente activo') selected @endif>Moderadamente activo</option>
                                <option value="Muy activo" @if ($historiaClinica->estilo_vida == 'Muy activo') selected @endif>Muy activo</option>
                                <option value="Extra activo" @if ($historiaClinica->estilo_vida == 'Extra activo') selected @endif>Extra activo</option>
                            </select>

                            @error('estilo_vida')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="objetivo_salud" class="form-label">Objetivo de salud</label>
                            <select name="objetivo_salud" id="objetivo_salud" class="form-select @error('objetivo_salud') is-invalid @enderror">
                                <option value="">Elija una opción...</option>
                                <option value="Adelgazar" @if ($historiaClinica->objetivo_salud == 'Adelgazar') selected @endif>Adelgazar</option>
                                <option value="Ganar masa muscular" @if ($historiaClinica->objetivo_salud == 'Ganar masa muscular') selected @endif>Ganar masa muscular</option>
                                <option value="Nutrición deportiva" @if ($historiaClinica->objetivo_salud == 'Nutrición deportiva') selected @endif>Nutrición deportiva</option>
                                <option value="Nutrición por enfermedad" @if ($historiaClinica->objetivo_salud == 'Nutrición por enfermedad') selected @endif>Nutrición por enfermedad</option>
                            </select>

                            @error('objetivo_salud')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="float-right">
                                <button type="submit" class="btn btn-success">Guardar</button>
                                <a href="{{ route('historia-clinica.index') }}" class="btn btn-danger" tabindex="7">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Inicializa las pestañas al cargar la página
        $(document).ready(function () {
            $('.nav-tabs a').click(function () {
                $(this).tab('show');
            });
        });
    </script>

@stop
