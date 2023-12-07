@extends('adminlte::page')

@section('title', 'Menú semanal')

@section('content_header')

@stop

@section('content')

    <div class="card card-dark mt-3">
        <div class="card-header">
            <h5 class="card-title">Recetas</h5>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget = "collapse" title= "collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row mt-3">
                <table class="table table-striped" id="tabla-recetas">
                    <thead>
                        <tr>
                            <th scope="col">Receta</th>
                            <th scope="col">Tiempo Preparación</th>
                            <th scope="col">Porciones</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recetas as $receta)
                            <tr>
                                <td>{{$receta->nombre_receta}}</td>
                                <td>
                                    @if ($receta->tiempo_preparacion == 0 && $receta->unidad_de_tiempo->nombre_unidad_tiempo == 'Sin unidad de tiempo')
                                        {{$receta->unidad_de_tiempo->nombre_unidad_tiempo}}
                                    @else
                                        {{$receta->tiempo_preparacion}} {{$receta->unidad_de_tiempo->nombre_unidad_tiempo}}
                                    @endif
                                </td>
                                <td>
                                    {{$receta->porciones}}
                                </td>
                                <td>
                                    <div class="row g-1">
                                        <div class="col-auto">
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#showReceta{{$receta->id}}" class="btn btn-primary btn-sm"><i class="bi bi-eye"></i></button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach($recetas as $receta)
        <!-- Modal Editar Receta -->
        <div class="modal fade" id="showReceta{{$receta->id}}" data-bs-backdrop="static" tabindex="-1" aria-labelledby="showReceta{{$receta->id}}Label" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="showReceta{{$receta->id}}Label">Receta: {{$receta->nombre_receta}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input disabled type="text" class="form-control" id="nombre_receta" name="nombre_receta" placeholder="Nombre de la receta" required  value="{{$receta->nombre_receta}}" @if($errors->has('nombre_receta')) value="{{old('nombre_receta')}}" @endif>
                                    <label for="nombre_receta">Nombre de la receta</label>

                                    @error('nombre_receta')
                                    <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input disabled type="text" class="form-control" id="porciones" name="porciones" placeholder="Porciones" required value="{{$receta->porciones}}" @if($errors->has('porciones')) value="{{old('porciones')}}" @endif>
                                    <label for="porciones">Porciones</label>

                                    @error('porciones')
                                    <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input disabled type="text" class="form-control" id="tiempo_preparacion" name="tiempo_preparacion" placeholder="Tiempo de preparación" required  value="{{$receta->tiempo_preparacion}}" @if($errors->has('tiempo_preparacion')) value="{{old('tiempo_preparacion')}}" @endif>
                                    <label for="tiempo_preparacion">Tiempo de preparación</label>

                                    @error('tiempo_preparacion')
                                    <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <select disabled class="form-select" id="unidad_de_tiempo" name="unidad_de_tiempo" aria-label="Floating label select example" required>
                                        <option selected disabled value="">Seleccione una unidad de tiempo</option>
                                        @foreach($unidadesTiempo as $unidad_de_tiempo)
                                            <option @if($receta->unidad_de_tiempo_id == $unidad_de_tiempo->id) selected @endif value="{{$unidad_de_tiempo->id}}" @if($errors->has('unidad_de_tiempo')) selected @endif>{{$unidad_de_tiempo->nombre_unidad_tiempo}}</option>
                                        @endforeach
                                    </select>
                                    <label for="unidad_de_tiempo">Unidad de tiempo</label>

                                    @error('unidad_de_tiempo')
                                    <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-floating">
                                    <textarea disabled class="form-control" placeholder="Preparación" id="preparacion" name="preparacion" style="height: 100px" required>{{$receta->preparacion}}@if($errors->has('preparacion')) {{old('preparacion')}} @endif</textarea>
                                    <label for="preparacion">Preparación</label>

                                    @error('preparacion')
                                    <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Sección de Ingredientes -->
                        <div class="accordion accordion mt-3" id="accordionEdit">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-accordionEdit">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-accordionEdit-content" aria-expanded="false" aria-controls="flush-accordionEdit-content">
                                        Ingredientes
                                    </button>
                                </h2>
                                <div id="flush-accordionEdit-content" class="accordion-collapse collapse" aria-labelledby="flush-accordionEdit" data-bs-parent="#accordionEdit">
                                    <div class="accordion-body">
                                        <p>Seleccione los ingredientes de la lista o agréguelos:</p>

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Alimento</th>
                                                    <th>Cantidad</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($ingredientes as $ingrediente)
                                                    @if ($receta->id == $ingrediente->receta_id && $ingrediente->cantidad != 0 && $ingrediente->unidad_medida_por_comida->nombre_unidad_medida != 'Sin unidad de medida')
                                                        <tr>
                                                            <td>{{$ingrediente->alimento->alimento}}</td>
                                                            <td>
                                                                {{$ingrediente->cantidad}} {{$ingrediente->unidad_medida_por_comida->nombre_unidad_medida}}
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
                        <div class="row mt-3">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <textarea disabled class="form-control" placeholder="Recursos externos" id="recursos_externos" name="recursos_externos" style="height: 100px" >{{$receta->recursos_externos}}@if($errors->has('recursos_externos')) {{old('recursos_externos')}}@endif</textarea>
                                    <label for="recursos_externos">Recursos externos</label>

                                    @error('recursos_externos')
                                    <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        //Datatable Tags
        $(document).ready(function(){
            $('#tabla-recetas').DataTable({
                responsive: true,
                autoWidth: false,
                "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_",
                    "zeroRecords": "No se encontró ninguna receta",
                    "info": "",
                    "infoEmpty": "No hay recetas",
                    "infoFiltered": "(filtrado de _MAX_ recetas totales)",
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
