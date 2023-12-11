<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Plan de Seguimiento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        /*
        h1{
            text-align: center;
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        */
        @page {
            margin: 3cm 0cm 0cm 0cm;
        }
        body {
            font-family: 'Arial', sans-serif;
        }

        #header{
            position: fixed;
            top: -3cm;
            left: 0cm;
            width: 100%;
        }

        .infoHeader{
            float: left;
            margin-left: 1cm;
            margin-top: 0.5cm;
            width: 100%;
        }


        .imgHeader{
            float: left;
            width: 3cm;
        }


        #footer{
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            width: 100%;
        }

        .textFooter{
            text-align: center;
            width: 100%
        }

        .container{
            width: 100%;
            margin-top: 1cm;
        }

        .textContainer{
            text-align: center;
        }

        table{
            width: 100%;
            border: 1px solid black;
        }

        .cabecera{
            background-color: #343a40;
            color: white;
        }

    </style>

</head>
<body>
    <div id="header">
        <img class="imgHeader" src="{{public_path('img/logo.jpeg')}}" alt="">
        <div class="infoHeader">
            <h1>NutriSoft - Sistema de Gestión Nutricional </h1>
            <p>{{ $fechaActual }}</p>
        </div>
    </div>

    <div id="footer">
    </div>

    <div class="container">
        <div class="hijo">
            <h1>Información del Plan</h1>

            <table class="table table-striped table-hover">
                <thead class="cabecera">
                    <tr style="text-align: center;">
                        <th>Fecha generación</th>
                        <th>Profesional</th>
                        <th>Descripción del Plan</th>
                    </tr>
                </thead>

                <tbody>
                    <tr style="text-align: center;">
                        <td>{{ \Carbon\Carbon::parse($plan->consulta->turno->fecha)->format('d/m/Y')}}</td>
                        <td>{{$plan->consulta->nutricionista->user->apellido}}, {{$plan->consulta->nutricionista->user->name}}</td>
                        <td>{{$plan->descripcion}}</td>
                    </tr>
                </tbody>
            </table>

            <br>

            <table class="table table-striped table-hover" id="tabla-plan">
                <thead class="cabecera">
                    <tr style="text-align: center;">
                        <th>Paciente</th>
                        <th>IMC</th>
                        <th>Peso actual</th>
                        <th>Altura actual</th>
                        <th>Objetivo de salud</th>
                    </tr>
                </thead>

                <tbody>
                    <tr style="text-align: center;">
                        <td>{{$plan->paciente->user->apellido}}, {{$plan->paciente->user->name}}</td>
                        <td>{{$plan->consulta->imc_actual}}</td>
                        <td>{{$plan->consulta->peso_actual}} kg</td>
                        <td>{{$plan->consulta->altura_actual}} cm</td>
                        <td>{{$plan->paciente->historiaClinica->objetivo_salud}}</td>
                    </tr>
                </tbody>
            </table>

            <br>

            <h1>Plan de Seguimiento</h1>

            <table class="table table-striped table-hover">
                <thead class="cabecera">
                    <tr>
                        <th>Actividad</th>
                        <th>Tipo de actividad</th>
                        <th>Duración</th>
                        <th>Recursos externos</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($detallesPlan as $detalle)
                        @foreach ($actividadesRecomendadas as $recomendada)
                            @foreach ($tiposActividades as $tipoActividad)
                                @foreach ($actividadesPorTipo as $tipo)
                                    @foreach ($unidadesTiempo as $tiempo)
                                        @foreach ($actividades as $actividad)
                                            @if ($detalle->act_rec_id == $recomendada->id && $actividad->id == $detalle->actividad_id && $detalle->actividad_id == $tipo->actividad_id && $detalle->tiempo_realizacion == $recomendada->duracion_actividad && $detalle->unidad_tiempo_realizacion == $tiempo->nombre_unidad_tiempo && $tiempo->id == $recomendada->unidad_tiempo_id && $recomendada->act_tipoAct_id == $tipo->id && $tipoActividad->id == $tipo->tipo_actividad_id)
                                                <tr>
                                                    <td>{{ $actividad->actividad }}</td>
                                                    <td>{{$tipoActividad->tipo_actividad}}</td>
                                                    <td>{{ $detalle->tiempo_realizacion }} {{$detalle->unidad_tiempo_realizacion}}</td>
                                                    <td>{{ $detalle->recursos_externos }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="4"><p>No hay alimentos asignados para este horario</p></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(270, 820, "Página $PAGE_NUM de $PAGE_COUNT", $font, 10);
            ');
        }
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>
