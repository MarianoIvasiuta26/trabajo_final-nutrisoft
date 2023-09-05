@extends('adminlte::page')

@section('title', 'Mi Historia Clínica')

@section('content_header')
    <h1>Completar Historia Clínica</h1>
@stop

@section('content')


    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-dark">
                    <div class="card-header">
                        Datos Personales
                    </div>
                    <div class="card-body">
                        <form class="row g-3" action="{{route('historia-clinica.store')}}" method="POST">
                           @csrf
                            <div class="col-md-6">
                                <label for="dni" class="form-label">DNI</label>
                                <input type="text" class="form-control" id="dni">
                            </div>
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefono">
                            </div>

                            <div class="col-md-4">
                                <label for="sexo" class="form-label">Sexo</label>
                                <select id="sexo" class="form-select">
                                <option selected>Elija una opción...</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="edad" class="form-label">Edad</label>
                                <input type="number" class="form-control" id="edad">
                            </div>

                            <div class="col-md-4">
                                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="fecha_nacimiento">
                            </div>


                            <span>Seleccione los días que tiene disponibles:</span>
                            <div class="col-md-2">
                                <div class="icheck-primary">
                                    <input value="Lunes" type="checkbox" id="diasFijos-lunes" />
                                    <label for="diasFijos-lunes">Lunes</label>
                                </div>
                                <div class="icheck-primary">
                                    <input value="Martes" type="checkbox" id="diasFijos-martes" />
                                    <label for="diasFijos-martes">Martes</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="icheck-primary">
                                    <input value="Miercoles" type="checkbox" id="diasFijos-miercoles" />
                                    <label for="diasFijos-miercoles">Miércoles</label>
                                </div>
                                <div class="icheck-primary">
                                    <input value="Jueves" type="checkbox" id="diasFijos-jueves" />
                                    <label for="diasFijos-jueves">Jueves</label>
                                </div>
                            </div>
                            
                            <span>Seleccione las horas disponibles:</span>
                            <select class="selectpicker" multiple title="Seleccione las horas de la mañana disponibles..." data-style="btn-success" data-width="fit" data-live-search="true" data-size="5">
                                <option>8:00</option>
                                <option>8:15</option>
                                <option>8:30</option>
                                <option>8:45</option>
                                <option>9:00</option>
                                <option>9:15</option>
                                <option>9:30</option>
                                <option>9:45</option>
                                <option>10:00</option>
                                <option>10:15</option>
                                <option>10:30</option>
                                <option>10:45</option>
                                <option>11:00</option>
                                <option>11:15</option>
                                <option>11:30</option>
                                <option>11:45</option>
                                <option data-divider="true" value="12:00">12:00</option>
                            </select>
                            <select class="selectpicker" data-style="btn-success" multiple title="Seleccione las horas de la tarde disponibles..." data-width="fit" data-size="5" data-live-search="true">
                                <option>16:30</option>
                                <option>16:45</option>
                                <option>17:00</option>
                                <option>17:15</option>
                                <option>17:30</option>
                                <option>17:45</option>
                                <option>18:00</option>
                                <option>18:15</option>
                                <option>18:30</option>
                                <option>18:45</option>
                                <option>19:00</option>
                                <option>19:15</option>
                                <option>19:30</option>
                            </select>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card card card-dark">
                    <div class="card-header">
                        Días y Horas Fijos disponibles
                    </div>
                    <div class="card-body">
                        <form class="row g-3" action="{{route('historia-clinica.store')}}" method="POST">


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">

        </div>
        <div class="card-body">

        </div>
    </div>


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/css/bootstrap-select.min.css" rel="stylesheet">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>

    </script>
@stop
