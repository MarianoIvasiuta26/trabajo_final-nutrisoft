@extends('adminlte::page')

@section('title', 'Mi Historia Clínica')

@section('content_header')

@stop

@section('content')
    <div class="col-md-12">
        <div class="card card-dark">
            <div class="card-header">
                <h5>Datos Médicos</h5>
            </div>
            <div id="datosMedicos" class="card-body">
                <form action="{{route('datos-medicos.update', $historiaClinica->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <h5>Anamnesis Alimentaria</h5>
                        <div class="col-md-6">
                            <label for="gustos" class="form-label">Seleccione sus alimentos preferidos</label>
                            <select name="alimentos_gustos[]" class="form-select" id="gustos" data-placeholder="Alimentos preferidos..." multiple>
                                <option value="">Ninguna</option>
                                @foreach ($alimentos->groupBy('grupo_alimento') as $grupo_alimento => $alimentos_del_grupo)
                                    <optgroup label="{{$grupo_alimento}}">
                                        @foreach ($alimentos_del_grupo as $alimento)
                                            <option value="{{$alimento->id}}" @if ($anamnesisPaciente->alimento_id == $alimento->id)
                                                selected
                                            @endif>{{$alimento->alimento}}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="no_gustos" class="form-label">Seleccione los alimentos que no le guste</label>
                            <select name="alimentos_no_gustos[]" class="form-select" id="no_gustos" data-placeholder="Alimentos que no guste..." multiple>
                                <option value="">Ninguna</option>
                                @foreach ($alimentos->groupBy('grupo') as $grupo_alimento => $alimentos_del_grupo)
                                    <optgroup label="{{$grupo_alimento}}">
                                        @foreach ($alimentos_del_grupo as $alimento)
                                            <option value="{{$alimento->id}}" @if ($anamnesisPaciente->alimento_id == $alimento->id)
                                                selected
                                            @endif>{{$alimento->alimento}}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <h5>Alergias</h5>
                        <div class="col-md-12">
                            <label for="alergias" class="form-label">Seleccione las alergias que posee</label>
                            <select name="alergias[]" class="form-select" id="alergias" data-placeholder="Alergias..." multiple>
                                <option value="">Ninguna</option>
                                @foreach ($alergias->groupBy('grupo_alergia') as $grupo_alergia => $alergias_del_grupo)
                                    <optgroup label="{{$grupo_alergia}}">
                                        @foreach ($alergias_del_grupo as $alergia)
                                            <option value="{{$alergia->id}}" @if ($datosMedicos->alergia_id == $alergia->id)
                                                selected
                                            @endif>{{$alergia->alergia}}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3" id="cirugias-container">
                        <div class="col-md-9">
                            <h5>Cirugías</h5>
                        </div>
                        <div class="col-md-3">
                            <button type="button" id="agregar-cirugia" class="btn btn-primary btn-sm float-right">Agregar Cirugía</button>
                        </div>
                        @foreach ($cirugiasPaciente as $cirugiaPaciente)
                            <div class="cirugia-entry">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <select name="cirugias[]" class="form-select">
                                            <option value="">Seleccione una cirugía</option>
                                            @foreach ($cirugias->groupBy('grupo_cirugia') as $grupo_cirugia => $cirugias_del_grupo)
                                                <optgroup label="{{$grupo_cirugia}}">
                                                    @foreach ($cirugias_del_grupo as $cirugia)
                                                        <option value="{{$cirugia->id}}" @if ($cirugiaPaciente->cirugia_id == $cirugia->id)
                                                            selected
                                                        @endif>{{$cirugia->cirugia}}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="number" name="tiempo[]" class="form-control tiempo-input" placeholder="Tiempo" value="{{$cirugiaPaciente->tiempo}}">
                                            <select name="unidad[]" class="form-select unidad-select">
                                                <option value="dias" @if ($cirugiaPaciente->unidad_tiempo == 'dias')
                                                    selected
                                                @endif>Días</option>
                                                <option value="semanas" @if ($cirugiaPaciente->unidad_tiempo == 'semanas')
                                                    selected
                                                @endif>Semanas</option>
                                                <option value="meses" @if ($cirugiaPaciente->unidad_tiempo == 'meses')
                                                    selected
                                                @endif>Meses</option>
                                                <option value="anios" @if ($cirugiaPaciente->unidad_tiempo == 'anios')
                                                    selected
                                                @endif>Años</option>
                                            </select>
                                            <form action="">
                                                <button type="button" class="btn btn-danger remove-cirugia"><i class="bi bi-x"></i></button>
                                            </form>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>


                    <div class="row mt-3">
                        <h5>Patologías</h5>
                        <div class="col-md-12">
                            <label for="patologias" class="form-label">Seleccione las patologías que posee</label>
                            <select name="patologias[]" class="form-select" id="patologias" data-placeholder="Patologías..." multiple>
                                <option value="">Ninguna</option>
                                @foreach ($patologias->groupBy('grupo_patologia') as $grupo_patologia => $patologias_del_grupo)
                                    <optgroup label="{{$grupo_patologia}}">
                                        @foreach ($patologias_del_grupo as $patologia)
                                            <option value="{{$patologia->id}}" @if ($datosMedicos->patologia_id == $patologia->id)
                                                selected
                                            @endif>{{$patologia->patologia}}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <h5>Intolerancias</h5>
                        <div class="col-md-12">
                            <label for="intolerancias" class="form-label">Seleccione las intolerancias que posee</label>
                            <select name="intolerancias[]" class="form-select" id="intolerancias" data-placeholder="Intolerancias..." multiple>
                                <option value="">Ninguna</option>
                                @foreach ($intolerancias as $intolerancia)
                                    <option value="{{$intolerancia->id}}" @if ($datosMedicos->intolerancia_id == $intolerancia->id)
                                        selected
                                    @endif>{{$intolerancia->intolerancia}}</option>
                                @endforeach
                            </select>
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

    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />


    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

        $( '#patologias' ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            closeOnSelect: false,
        } );

        $( '#intolerancias' ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            closeOnSelect: false,
        } );

        //Función para agregar y eliminar cirugías
        $(document).ready(function() {
            // Manejar clic en el botón "Agregar Cirugía"
            $('#agregar-cirugia').click(function() {
                var nuevaCirugia = $('.cirugia-entry:first').clone();
                nuevaCirugia.find('select').val('');
                nuevaCirugia.find('input').val('');
                nuevaCirugia.appendTo('#cirugias-container');
            });

            // Manejar clic en el botón "x" para eliminar una entrada de cirugía
            $('#cirugias-container').on('click', '.remove-cirugia', function() {
                $(this).closest('.cirugia-entry').remove();
            });

        });
    </script>

@stop
