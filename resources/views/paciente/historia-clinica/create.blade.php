@extends('adminlte::page')

@section('title', 'Mi Historia Clínica')

@section('content_header')
    <h1 style="text-align:center;">Completar Historia Clínica</h1>
@stop

@section('content')

    <div class="container mt-4">
        <div class="row">
            <!--Form datos personales-->
            <div class="col-md-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <button class="btn btn-link float-right" onclick="toggleCard('datosPersonales')">
                            <i class="fa fa-minus"></i>
                        </button>
                        <h5>Datos Personales</h5>
                    </div>
                    <div id="datosPersonales" class="card-body">
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


                            <div class="col-12">
                                <div class="float-right">
                                    <button type="submit" class="btn btn-success">Guardar</button>
                                    <a href="{{ route('gestion-usuarios.index') }}" class="btn btn-danger" tabindex="7">Cancelar</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!--Form días y horas disponibles para adelantamiento de turnos -->
            <div class="col-md-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <button class="btn btn-link float-right" onclick="toggleCard('diasYHoras')">
                            <i class="fa fa-plus"></i>
                        </button>
                        <h5>Días y Horas Fijos disponibles</h5>
                    </div>
                    <div id="diasYHoras" class="card-body" style="display: none;">
                        <form action="{{route('historia-clinica.store')}}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Seleccione los días que tiene disponibles:</h5>
                                    @foreach ($horarios as $horario)
                                        @foreach ($dias as $dia)
                                            @if ($dia->id == $horario->dia_atencion_id)
                                                <div class="col-md-2">
                                                    <div class="icheck-primary">
                                                        <input value="{{$dia->dia}}" type="checkbox" id="diasFijos-{{$dia->dia}}" name="diasFijos[]"/>
                                                        <label for="diasFijos-{{$dia->dia}}">{{$dia->dia}}</label>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </div>
                                <!-- Horas -->
                                <div class="col-md-6">
                                    <h5>Seleccione las horas disponibles:</h5>
                                    <div class="row">
                                        <select name="horasFijas[]" class="selectpicker" multiple title="Seleccione las horas de la mañana disponibles..." data-style="btn-success" data-width="fit" data-live-search="true" data-size="5">
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
                                            <option value="12:00">12:00</option>
                                        </select>
                                    </div>

                                    <div class="row">
                                        <select class="selectpicker mt-4" data-style="btn-success" multiple title="Seleccione las horas de la tarde disponibles..." data-width="fit" data-size="5" data-live-search="true">
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
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="float-right">
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                        <a href="{{ route('gestion-usuarios.index') }}" class="btn btn-danger" tabindex="7">Cancelar</a>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!--Form datos físicos-->
            <div class="col-md-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <button class="btn btn-link float-right" onclick="toggleCard('datosFisicos')">
                            <i class="fa fa-plus"></i>
                        </button>
                        <h5>Datos Físicos</h5>
                    </div>
                    <div id="datosFisicos" class="card-body" style="display: none;">
                        <form action="{{route('historia-clinica.store')}}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="peso" class="form-label">Peso</label>
                                    <input type="number" class="form-control" id="peso">
                                </div>
                                <div class="col-md-6">
                                    <label for="altura" class="form-label">Altura</label>
                                    <input type="number" class="form-control" id="altura">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label for="circ_munieca" class="form-label">Circunferencia de Muñeca</label>
                                    <input type="number" class="form-control" id="circ_munieca">
                                </div>

                                <div class="col-md-3">
                                    <label for="circ_cintura" class="form-label">Circunferencia de Cintura</label>
                                    <input type="number" class="form-control" id="circ_cintura">
                                </div>

                                <div class="col-md-3">
                                    <label for="circ_cadera" class="form-label">Circunferencia de Cadera</label>
                                    <input type="number" class="form-control" id="circ_cadera">
                                </div>

                                <div class="col-md-3">
                                    <label for="circ_pecho" class="form-label">Circunferencia de Pecho</label>
                                    <input type="number" class="form-control" id="circ_pecho">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="estilo_vida" class="form-label">Estilo de vida actual</label>
                                    <select id="estilo_vida" class="form-select">
                                        <option selected>Elija una opción...</option>
                                        <option value="Sedentario">Sedentario</option>
                                        <option value="Actividad Física regular">Actividad Física regular</option>
                                        <option value="Actividad Física intensa">Actividad Física intensa</option>
                                        <option value="Poca actividad física"> Poca actividad física</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="objetivo_salud" class="form-label">Objetivo de salud</label>
                                    <select id="objetivo_salud" class="form-select">
                                        <option selected>Elija una opción...</option>
                                        <option value="Adelgazar">Adelgazar</option>
                                        <option value="Ganar masa muscular">Ganar masa muscular</option>
                                        <option value="Nutrición deportiva">Nutrición deportiva</option>
                                        <option value="Nutrición por enfermedad"> Nutrición por enfermedad</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="float-right">
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                        <a href="{{ route('gestion-usuarios.index') }}" class="btn btn-danger" tabindex="7">Cancelar</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--Form datos médicos-->
            <div class="col-md-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <button class="btn btn-link float-right" onclick="toggleCard('datosMedicos')">
                            <i class="fa fa-plus"></i>
                        </button>
                        <h5>Datos Médicos</h5>
                    </div>
                    <div id="datosMedicos" class="card-body" style="display: none;">
                        <form action="{{route('historia-clinica.store')}}" method="POST">
                            @csrf


                            <div class="row">
                                <h5>Anamnesis Alimentaria</h5>
                                <div class="col-md-6">
                                    <label for="gustos" class="form-label">Seleccione sus alimentos preferidos</label>
                                    <select name="alimentos_gustos[]" class="form-select" id="gustos" data-placeholder="Alimentos preferidos..." multiple>

                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="no_gustos" class="form-label">Seleccione los alimentos que no le guste</label>
                                    <select name="alimentos_no_gustos[]" class="form-select" id="no_gustos" data-placeholder="Alimentos que no guste..." multiple>

                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <h5>Alergias</h5>
                                <div class="col-md-6">
                                    <label for="alergias" class="form-label">Seleccione las alergias que posee</label>
                                    <select name="alergias[]" class="form-select" id="alergias" data-placeholder="Alergias..." multiple>
                                        <option value="">Ninguna</option>
                                        <optgroup label="Alergia a Frutos secos">
                                            <option value="">Nueces</option>
                                            <option value="">Almendras</option>
                                            <option value="">Avellanas</option>
                                            <option value="">Pistachos</option>
                                            <option value="">Anacardos</option>

                                        </optgroup>

                                        <optgroup label="Alergia al Pescado">
                                            <option value="">Salmón</option>
                                            <option value="">Atún</option>
                                            <option value="">Trucha</option>
                                            <option value="">Sardinas</option>
                                            <option value="">Bacalao</option>
                                            <option value="">Merluza</option>
                                        </optgroup>

                                        <optgroup label="Alergia a Mariscos">
                                            <option value="">Camarón</option>
                                            <option value="">Langosta</option>
                                            <option value="">Cangrejo</option>
                                            <option value="">Ostras</option>
                                            <option value="">Mejillones</option>
                                        </optgroup>

                                        <optgroup label="Otras alergias">
                                            <option value="">Maní</option>
                                            <option value="">Huevo y derivados</option>
                                            <option value="">Leche y derivados</option>
                                            <option value="">Soja y derivados</option>
                                            <option value="">Trigo y gluten</option>
                                            <option value="">Apio</option>
                                            <option value="">Sésamo</option>
                                            <option value="">Sulfitos</option>
                                            <option value="">Lupino</option>
                                            <option value="">Moluscos</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <h5>Cirugías</h5>
                                <div class="col-md-6">
                                    <label for="cirugias" class="form-label">Seleccione las cirugías que se realizó</label>
                                    <select name="cirugias[]" class="form-select" id="cirugias" data-placeholder="Cirugías..." multiple>
                                        <option value="">Ninguna</option>
                                        <optgroup label="Cirugia reciente">
                                            <option value="">Cirugía oral</option>
                                            <option value="">Apendicetomía</option>
                                        </optgroup>

                                        <optgroup label="Cirugía Gastrointestinal">
                                            <option value="">Resección intestinal</option>
                                            <option value="">cirugía de pérdida de peso</option>
                                        </optgroup>

                                        <optgroup label="Cirugía Cardíaca o Vascular">
                                            <option value="">Bypass de arteria coronaria</option>
                                            <option value="">Cirugía de válvula cardíaca</option>
                                            <option value="">Cirugía de aneurisma aórtico</option>
                                            <option value="">Cirugía de arteria carótida</option>
                                        </optgroup>

                                        <optgroup label="Cirugía Bariátrica">
                                            <option value="">Bypass gástrico</option>
                                            <option value="">Banda gástrica</option>
                                        </optgroup>

                                        <optgroup label="Cirugía de Órganos Vitales">
                                            <option value="">Cirugía de Hígado</option>
                                            <option value="">Cirugía de Páncreas</option>
                                            <option value="">Cirugía de Riñón</option>
                                            <option value="">Cirugía de Pulmón</option>
                                            <option value="">Cirugía de Vejiga</option>
                                            <option value="">Cirugía de Próstata</option>
                                            <option value="">Cirugía de Vesícula Biliar</option>
                                            <option value="">Cirugía de Bazo</option>
                                            <option value="">Cirugía de Intestino Delgado</option>
                                            <option value="">Cirugía de Intestino Grueso</option>
                                            <option value="">Cirugía de Colon o Recto</option>
                                        </optgroup>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="tiempoCirugia">¿Hace cuánto tiempo se realizó la cirugía?</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control form-control-sm" id="tiempoCirugia">
                                        <select name="periodoCirugia" id="periodoCirugia" class="form-select form-select-sm">
                                            <option value="Dias">Días</option>
                                            <option value="Semanas">Semanas</option>
                                            <option value="Meses">Meses</option>
                                            <option value="Años">Años</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="row mt-3">
                                <h5>Patologías</h5>
                                <div class="col-md-6">

                                </div>
                            </div>

                            <div class="row mt-3">
                                <h5>Intolerancias</h5>
                                <div class="col-md-6">

                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>



@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/css/bootstrap-select.min.css" rel="stylesheet">

    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <style>
        .card-body {
            display: none;
        }

    </style>



@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

   <script>
        function toggleCard(cardId) {
            const card = document.getElementById(cardId);
            const icon = card.previousElementSibling.querySelector("i.fa");

            if (card.style.display === "none" || card.style.display === "") {
                card.style.display = "block";
                icon.classList.remove("fa-plus");
                icon.classList.add("fa-minus");
            } else {
                card.style.display = "none";
                icon.classList.remove("fa-minus");
                icon.classList.add("fa-plus");
            }
        }

        // Abrir el primer card al cargar la página
        document.addEventListener("DOMContentLoaded", function () {
            const primerCard = document.getElementById("datosPersonales");
            const iconPrimerCard = primerCard.previousElementSibling.querySelector("i.fa");

            primerCard.style.display = "block";
            iconPrimerCard.classList.remove("fa-plus");
            iconPrimerCard.classList.add("fa-minus");
        });

        //SELECT2
        $( '#gustos' ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            closeOnSelect: false,
        } );

        $( '#no_gustos' ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            closeOnSelect: false,
        } );

        $( '#alergias' ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            closeOnSelect: false,
        } );

        $( '#cirugias' ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            closeOnSelect: false,
        } );

    </script>

@stop
