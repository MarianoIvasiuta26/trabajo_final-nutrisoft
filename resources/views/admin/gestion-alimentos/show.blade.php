@extends('adminlte::page')

@section('title', 'Valores nutricionales')

@section('content_header')

@stop

@section('content')

    <div class="card card-dark mt-3">
        <div class="card-header">
            <h3>Valores nutricionales - {{$alimento->alimento}}</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped mt-4">
                <thead>
                    <tr>
                        <th scope="col">Alimento</th>
                        <th scope="col">Grupo de alimento</th>
                        <th scope="col">Estacional</th>
                        <th scope="col">Estacion</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$alimento->alimento}}</td>
                        <td>
                            @foreach ($grupos as $grupo)
                                @if ($grupo->id == $alimento->grupo_alimento_id)
                                    {{$grupo->grupo}}
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @if ($alimento->estacional == 0)
                                No
                            @else
                                Si
                            @endif
                        </td>
                        <td>{{$alimento->estacion}}</td>
                    </tr>
                </tbody>
            </table>

            <div class="accordion accordion-flush mt-3" id="valorNutricional">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        <h5>Valores Nutricionales</h5>
                    </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <table class="table table-striped" id="consultas">
                                <thead>
                                    <tr>
                                        <th scope="col">Nutriente</th>
                                        <th scope="col">Tipo</th>
                                        <th scope="col">Valor</th>
                                        <th scope="col">Unidad de medida</th>
                                        <th scope="col">Fuente de información nutricional</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($valoresNutricionales as $valor)
                                        <tr>
                                            <td>{{$valor->nutriente->nombre_nutriente}}</td>

                                            <td> {{$valor->nutriente->tipoNutriente->tipo_nutriente}} </td>

                                            <td>{{$valor->valor}}</td>

                                            <td>{{$valor->unidad}}</td>

                                            <td>{{$valor->fuenteAlimento->fuente}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <a class="btn btn-danger mt-3" href="{{route('gestion-alimentos.index')}}">Volver</a>

        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function(){
            var table = $('#tabla-alimentos').DataTable({
                responsive: true,
                autoWidth: false,
                "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ alimentos por página",
                    "zeroRecords": "No se encontró ningún alimento",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros de alimentos",
                    "infoFiltered": "(filtrado de _MAX_ alimentos totales)",
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
