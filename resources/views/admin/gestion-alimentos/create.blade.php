@extends('adminlte::page')

@section('title', 'Agregar nuevo Alimento')

@section('content_header')
    <h1>Agregar nuevo Alimento</h1>
@stop

@section('content')
    <div class="card card-dark">
        <div class="card-header">
            <ul class="nav nav-tabs justify-content-center card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#datos-alimento">Datos de Alimento</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#valor-nutricional">Valores Nutricionales</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div id="datos-alimento" class="tab-pane show active">
                    <form action="{{ route('gestion-alimentos.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="alimento" class="form-label">Alimento</label>
                            <input type="text" name="alimento" id="alimento" class="form-control" tabindex="2">
                        </div>
                        <div class="row">
                            <label for="grupo_alimento">Grupo Alimento</label>
                            <div class="col-10 mb-3">
                                <select class="form-select" name="grupo_alimento" id="grupo_alimento">
                                    <option value="0">Seleccione una opción...</option>
                                    @foreach ($grupos as $grupo)
                                        <option value="{{ $grupo->id }}">{{ $grupo->grupo }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-2 mb-3">
                                <a href="{{route('gestion-grupos-alimento.create')}}" class="btn btn-primary">Nuevo</a>
                            </div>

                        </div>

                        @if(session('success'))
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: '{{ session('success') }}',
                                });
                            </script>
                            @endif

                            @if(session('error'))
                                <script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: '{{ session('error') }}',
                                    });
                                </script>
                            @endif

                        <div class="row mb-3">
                            <div class="col">
                                <label for="estacional">Estacional</label>
                                <select class="form-select" name="estacional" id="estacional">
                                    <option value="">Seleccione una opción...</option>
                                    <option value="0">No</option>
                                    <option value="1">Si</option>
                                </select>
                            </div>

                            <div class="col">
                                <label for="estacion">Estacion</label>
                                <select class="form-select" name="estacion" id="estacion">
                                    <option value="">Seleccione una opción...</option>
                                    <option value="Ninguna">Ninguna</option>
                                    <option value="Verano">Verano</option>
                                    <option value="Invierno">Invierno</option>
                                    <option value="Otonio">Otoño</option>
                                    <option value="Primavera">Primavera</option>
                                </select>
                            </div>
                        </div>
                        <a href="{{ route('gestion-alimentos.index') }}" class="btn btn-danger" tabindex="7">Cancelar</a>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </form>
                </div>

                {{-- Form de Valores Nutricionales --}}
                <div id="valor-nutricional" class="tab-pane">
                    <form action="{{ route('gestion-alimentos.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <label for="fuente">Fuente</label>
                            <div class="col-10 mb-3">
                                <select class="form-select" name="fuente" id="fuente">
                                    <option value="">Seleccione una opción...</option>
                                    @foreach ($fuentes as $fuente)
                                        <option value="{{ $fuente->id }}">{{ $fuente->fuente }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2 mb-3">
                                <a href="{{ route('gestion-fuentes.create') }}" class="btn btn-primary">Nuevo</a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label>Nutrientes</label>
                            </div>

                            <!-- Pestañas desplegables para Macronutrientes y Micronutrientes -->
                            <div class="accordion" id="nutrientTabs">
                                <!-- Macronutrientes -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="macronutrientHeading">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#macronutrientCollapse" aria-expanded="true" aria-controls="macronutrientCollapse">
                                            Macronutrientes
                                        </button>
                                    </h2>
                                    <div id="macronutrientCollapse" class="accordion-collapse collapse show" aria-labelledby="macronutrientHeading">
                                        <div class="accordion-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre del Nutriente</th>
                                                        <th>Unidad de Medida</th>
                                                        <th>Valor</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($nutrientes as $nutriente)
                                                        @if ($nutriente->tipo_nutriente_id == 1)
                                                            <tr>
                                                                <td>{{ $nutriente->nombre_nutriente }}</td>
                                                                <td>
                                                                    <input type="text" name="nutriente_unidad_{{ $nutriente->id }}" class="form-control" placeholder="Unidad de Medida">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="nutriente_valor_{{ $nutriente->id }}" class="form-control" placeholder="Valor">
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Micronutrientes -->
                                <div class="accordion-item mb-3">
                                    <h2 class="accordion-header" id="micronutrientHeading">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#micronutrientCollapse" aria-expanded="false" aria-controls="micronutrientCollapse">
                                            Micronutrientes
                                        </button>
                                    </h2>
                                    <div id="micronutrientCollapse" class="accordion-collapse collapse" aria-labelledby="micronutrientHeading">
                                        <div class="accordion-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre del Nutriente</th>
                                                        <th>Unidad</th>
                                                        <th>Valor</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($nutrientes as $nutriente)
                                                        @if ($nutriente->tipo_nutriente_id == 2)
                                                            <tr>
                                                                <td>{{ $nutriente->nombre_nutriente }}</td>
                                                                <td>
                                                                    <input type="text" name="nutriente_unidad_{{ $nutriente->id }}" class="form-control" placeholder="Unidad">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="nutriente_valor_{{ $nutriente->id }}" class="form-control" placeholder="Valor">
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin de pestañas desplegables -->
                        </div>

                        <a href="{{ route('gestion-alimentos.index') }}" class="btn btn-danger" tabindex="7">Cancelar</a>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </form>
                </div>


            </div>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>
        // Inicializa las pestañas al cargar la página
        $(document).ready(function () {
            $('.nav-tabs a').click(function () {
                $(this).tab('show');
            });
        });


    </script>
@stop
