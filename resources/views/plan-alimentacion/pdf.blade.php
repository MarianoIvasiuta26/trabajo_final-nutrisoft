<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mis Planes de Alimentación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>

        @page {
            margin: 3cm 0cm 0cm 0cm;
        }
        body {
            font-family: 'Arial', sans-serif;
        }
        /*
        h5{
            font-family: 'Arial', sans-serif;
        }

        h1{
            font-family: 'Arial', sans-serif;
            margin-bottom: 20px;
            text-align: center;
        }
        */

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
            <h1 class="textContainer">Información del Plan</h1>

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

            <table class="table table-striped table-hover">
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

            <h1 class="textContainer">Plan de Alimentación</h1>

            @foreach($comidas as $comida)
                @if ($comida->nombre_comida != 'Sin comida')
                    <h5>
                        @if ($comida->nombre_comida == 'Media maniana')
                            Media mañana
                        @else
                            {{ $comida->nombre_comida }}
                        @endif
                    </h5>
                    <table class="table table-striped table-hover">
                        <thead class="cabecera">
                            <tr>
                                <th>Alimento</th>
                                <th>Cantidad</th>
                                <th>Unidad de medida</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($detallesPlan as $detallePlan)
                                @foreach ($alimentos as $alimento)
                                    @if ($detallePlan->horario_consumicion == $comida->nombre_comida && $detallePlan->alimento_id == $alimento->id)
                                        <tr>
                                            <td>{{ $alimento->alimento }}</td>
                                            <td>{{ $detallePlan->cantidad }}</td>
                                            <td>{{ $detallePlan->unidad_medida }}</td>
                                            <td>{{ $detallePlan->observacion }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="4"><p>No hay alimentos asignados para este horario</p></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                @endif
            @endforeach
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(270, 820, "Página $PAGE_NUM de $PAGE_COUNT", $font, 10);
            ');
        }
    </script>
</body>
</html>
