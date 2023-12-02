@extends('adminlte::page')

@section('title', 'Editar Alimento')

@section('content_header')

@stop

@section('content')
    <div class="card card-dark mt-3">
        <div class="card-header">
            <h3>Editar Alimento</h3>
        </div>
        <div class="card-body">

            <form action="{{route('gestion-alimentos.update', $alimento->id)}}" method="POST">
                @csrf
                @method('PUT')

                <div class="step" id="step1">
                    <div class="mb-3">
                        <label for="alimento" class="form-label">Alimento</label>
                        <input value="{{$alimento->alimento}}" type="text" name="alimento" id="alimento" class="form-control" tabindex="2">

                        @error('alimento')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                    </div>
                    <div class="row">
                        <label for="grupo_alimento">Grupo Alimento</label>
                        <div class="col-10 mb-3">
                            <select class="form-select" name="grupo_alimento" id="grupo_alimento">
                                <option value="0">Seleccione una opción...</option>
                                @foreach ($grupos as $grupo)
                                    <option value="{{ $grupo->id }}"
                                        @if ($alimento->grupo_alimento_id == $grupo->id)
                                            selected
                                        @endif
                                        >{{ $grupo->grupo }}
                                    </option>
                                @endforeach
                            </select>

                            @error('grupo_alimento')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-2 mb-3">
                            <a href="{{route('gestion-grupos-alimento.create')}}" class="btn btn-primary">Nuevo</a>
                        </div>

                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label for="estacional">Estacional</label>
                            <select class="form-select" name="estacional" id="estacional">
                                <option value="">Seleccione una opción...</option>
                                <option value="0"
                                @if ($alimento->estacional == 0)
                                    selected
                                @endif>
                                    No
                                </option>
                                <option value="1"
                                @if ($alimento->estacional == 1)
                                    selected
                                @endif>
                                    Si
                                </option>
                            </select>
                        </div>

                        <div class="col">
                            <label for="estacion">Estacion</label>
                            <select class="form-select" name="estacion" id="estacion">
                                <option value="">Seleccione una opción...</option>
                                <option value="Ninguna" @if ($alimento->estacion == 'Ninguna')
                                    selected
                                @endif>Ninguna</option>
                                <option value="Verano" @if ($alimento->estacion == 'Verano')
                                    selected
                                @endif>Verano</option>
                                <option value="Invierno" @if ($alimento->estacion == 'Invierno')
                                    selected
                                @endif>Invierno</option>
                                <option value="Otonio" @if ($alimento->estacion == 'Otonio')
                                    selected
                                @endif>Otoño</option>
                                <option value="Primavera" @if ($alimento->estacion == 'Primavera')
                                    selected
                                @endif>Primavera</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-primary next-step">Siguiente</button>
                            <a href="{{route('gestion-alimentos.index')}}" class="btn btn-danger">Cancelar</a>
                        </div>
                    </div>
                </div>

                <div class="step" id="step2">
                    <div class="row">
                        <label for="fuente">Fuente</label>
                        <div class="col-10 mb-3">
                            <select class="form-select" name="fuente" id="fuente">
                                <option value="">Seleccione una opción...</option>
                                @foreach ($fuentes as $fuente)
                                    <option value="{{ $fuente->id }}" @if ($fuente_id == $fuente->id)
                                        selected
                                    @endif>{{ $fuente->fuente }}</option>
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
                                                                <input
                                                                @foreach ($valores as $valorNutri)
                                                                    @if ($valorNutri->nutriente_id == $nutriente->id)
                                                                        @if ($valorNutri->unidad == null)
                                                                            value=""
                                                                        @else
                                                                            value="{{$valorNutri->unidad}}"
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                                type="text" name="nutrientes[{{$nutriente->id}}][unidad]" class="form-control" placeholder="Unidad de Medida">

                                                                @error('nutrientes[{{$nutriente->id}}][unidad]')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </td>
                                                            <td>
                                                                <input
                                                                @foreach ($valores as $valorNutri)
                                                                    @if ($valorNutri->nutriente_id == $nutriente->id)
                                                                        value="{{$valorNutri->valor}}"
                                                                    @endif
                                                                @endforeach
                                                                type="text" name="nutrientes[{{$nutriente->id}}][valor]" class="form-control" placeholder="Valor">
                                                                @error('nutrientes[{{$nutriente->id}}][valor]')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                @enderror
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
                                                                <input
                                                                @foreach ($valores as $valorNutri)
                                                                    @if ($valorNutri->nutriente_id == $nutriente->id)
                                                                        @if ($valorNutri->unidad == null)
                                                                            value=""
                                                                        @else
                                                                            value="{{$valorNutri->unidad}}"
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                                type="text" name="nutrientes[{{$nutriente->id}}][unidad]" class="form-control" placeholder="Unidad">
                                                                @error('nutrientes[{{$nutriente->id}}][unidad]')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </td>
                                                            <td>
                                                                <input
                                                                @foreach ($valores as $valorNutri)
                                                                    @if ($valorNutri->nutriente_id == $nutriente->id)
                                                                        value="{{$valorNutri->valor}}"
                                                                    @endif
                                                                @endforeach
                                                                type="text" name="nutrientes[{{$nutriente->id}}][valor]" class="form-control" placeholder="Valor">
                                                                @error('nutrientes[{{$nutriente->id}}][valor]')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                @enderror
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
                    <button type="button" class="btn btn-primary prev-step">Anterior</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
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
        $(document).ready(function () {
            var currentStep = 1; // Inicialmente, estamos en la etapa 1

            // Oculta todas las etapas excepto la primera
            $(".step:not(#step1)").hide();

            // Manejador para el botón "Siguiente"
            $(".next-step").click(function () {
                // Validación personalizada si es necesario
                if (currentStep === 1) {
                    // Validación para la primera etapa
                    if (!validateStep1()) {
                        return false; // No avanzar si la validación falla
                    }
                }

                currentStep++; // Avanzar a la siguiente etapa
                showStep(currentStep);
            });

            // Manejador para el botón "Anterior"
            $(".prev-step").click(function () {
                currentStep--; // Retroceder a la etapa anterior
                showStep(currentStep);
            });

            // Función para mostrar u ocultar etapas
            function showStep(step) {
                $(".step").hide(); // Ocultar todas las etapas
                $("#step" + step).show(); // Mostrar la etapa actual
            }

            // Puedes agregar una función de validación personalizada para la primera etapa
            function validateStep1() {
                // Agrega tu lógica de validación aquí
                // Si la validación es exitosa, devuelve true; de lo contrario, false.
                return true;
            }
        });
    </script>
@stop
