<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Plan de Seguimiento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        h1{
            text-align: center;
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 20px;
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

    <footer style="position: absolute; bottom: 0; width: 100%; text-align: center;">
        <table style="width: 100%;">
            <tr>
                <td style="text-align: center;">
                    NutriSoft - Sistema de Gestión nutricional
                </td>
            </tr>
        </table>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>
