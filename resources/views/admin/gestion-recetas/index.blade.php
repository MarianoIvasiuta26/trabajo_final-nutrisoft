@extends('adminlte::page')

@section('title', 'Gestión de Recetas')

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
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addReceta">
                Nueva Receta
            </button>

            <div class="row mt-3">
                <table class="table table-striped" id="tabla-recetas">
                    <thead>
                        <tr>
                            <th scope="col">Receta</th>
                            <th scope="col">Ingredientes</th>
                            <th scope="col">Tiempo Preparación</th>
                            <th scope="col">Porciones</th>
                            <th scope="col">Recursos externos</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recetas as $receta)
                            <tr>
                                <td>{{$receta->nombre_receta}}</td>
                                <td>
                                    @foreach($receta->ingredientes as $ingrediente)
                                        {{$ingrediente->alimento->alimento}}<br>
                                    @endforeach
                                </td>
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
                                    {{$receta->recursos_externos}}
                                </td>
                                <td>
                                    <div class="row g-1">
                                        <div class="col-auto">
                                            <a href="" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                                        </div>
                                        <div class="col-auto">
                                            <form action="{{route('gestion-recetas.destroy', $receta->id)}}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                            </form>
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

    <!-- Modal Agregar Receta -->
    <div class="modal fade" id="addReceta" data-bs-backdrop="static" tabindex="-1" aria-labelledby="addRecetaLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="addRecetaLabel">Nueva Receta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('gestion-recetas.store')}}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="nombre_receta" name="nombre_receta" placeholder="Nombre de la receta" required>
                                    <label for="nombre_receta">Nombre de la receta</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="porciones" name="porciones" placeholder="Porciones" required>
                                    <label for="porciones">Porciones</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="tiempo_preparacion" name="tiempo_preparacion" placeholder="Tiempo de preparación" required>
                                    <label for="tiempo_preparacion">Tiempo de preparación</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="unidad_de_tiempo" name="unidad_de_tiempo" aria-label="Floating label select example" required>
                                        <option selected disabled value="">Seleccione una unidad de tiempo</option>
                                        @foreach($unidades_de_tiempo as $unidad_de_tiempo)
                                            <option value="{{$unidad_de_tiempo->id}}">{{$unidad_de_tiempo->nombre_unidad_tiempo}}</option>
                                        @endforeach
                                    </select>
                                    <label for="unidad_de_tiempo">Unidad de tiempo</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" placeholder="Recursos externos" id="recursos_externos" name="recursos_externos" style="height: 100px" required></textarea>
                                    <label for="recursos_externos">Recursos externos</label>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Preparación" id="preparacion" name="preparacion" style="height: 100px" required></textarea>
                                    <label for="preparacion">Preparación</label>
                                </div>
                            </div>
                        </div>

                        <!-- Sección de Ingredientes -->
                        <div class="accordion accordion-flush mt-3" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                        Ingredientes
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <p>Seleccione los ingredientes de la lista o agréguelos:</p>

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Alimento</th>
                                                    <th>Cantidad</th>
                                                    <th>Seleccionar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($ingredientes as $ingrediente)
                                                    @if ($ingrediente->cantidad != 0 && $ingrediente->unidad_medida_por_comida->nombre_unidad_medida != 'Sin unidad de medida')
                                                        <tr>
                                                            <td>{{$ingrediente->alimento->alimento}}</td>
                                                            <td>
                                                                {{$ingrediente->cantidad}} {{$ingrediente->unidad_medida_por_comida->nombre_unidad_medida}}
                                                            </td>
                                                            <td>
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox" name="ingredientes_seleccionados[]" value="{{$ingrediente->id}}" id="switch_{{$ingrediente->id}}">
                                                                    <label class="form-check-label" for="switch_{{$ingrediente->id}}">Seleccionar</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <button type="button" class="btn btn-success mt-3" onclick="agregarIngrediente()">Agregar Ingrediente</button>

                                        <!-- Sección para cada Ingrediente -->
                                        <div id="ingredientes-section" class="row mt-3">
                                            <!-- Los ingredientes seleccionados se agregarán dinámicamente aquí -->
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                            </div>

                    </form>
                </div>
            </div>
        </div>
    </div>




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

        //Mensajes fhash

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '{{session('success')}}',
                showConfirmButton: false,
                timer: 1500
            })
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'success',
                title: '{{session('error')}}',
                showConfirmButton: false,
                timer: 1500
            })
        @endif

        function agregarIngrediente() {
            // Clonar la sección de ingrediente y agregarla al contenedor
            const ingredienteContainer = document.getElementById('ingredientes-section');
            const nuevoIngrediente = document.createElement('div');
            nuevoIngrediente.classList.add('row', 'mb-3', 'align-items-center');

            nuevoIngrediente.innerHTML = `
                <div class="col-md-4">
                    <div class="form-floating">
                        <select name="alimentos[]" class="form-select" placeholder="Alimento" required>
                            <option value="" selected>Selecciona el alimento</option>
                            @foreach($alimentos as $alimento)
                                <option value="{{$alimento->id}}">{{$alimento->alimento}}</option>
                            @endforeach
                        </select>
                        <label for="alimento">Alimento</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="cantidades[]" placeholder="Cantidad" required>
                        <label for="cantidad">Cantidad</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select" name="unidades_de_medida[]" placeholder="Unidad de medida" required>
                            <option value="" selected>Selecciona la unidad de medida</option>
                            @foreach($unidades_de_medida as $unidad_de_medida)
                                <option value="{{$unidad_de_medida->id}}">{{$unidad_de_medida->nombre_unidad_medida}}</option>
                            @endforeach
                        </select>
                        <label for="unidad_de_medida">Unidad de medida</label>
                    </div>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarIngrediente(this)"><i class="bi bi-trash"></i></button>
                </div>
            `;

            ingredienteContainer.appendChild(nuevoIngrediente);
        }

        function eliminarIngrediente(elemento) {
            // Obtener el elemento padre y eliminarlo
            const ingredienteContainer = document.getElementById('ingredientes-section');
            const padre = elemento.parentNode.parentNode; // Dos niveles arriba para llegar al div.row
            ingredienteContainer.removeChild(padre);
        }

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
