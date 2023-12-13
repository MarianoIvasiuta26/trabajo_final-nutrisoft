<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte - Frecuencia de Tratamientos</title>

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
            <h1>Reporte - Frecuencia de Tratamientos </h1>
            <p>{{ $fechaActual }}</p>
        </div>
    </div>

    <div class="container">
        <div class="hijo">
            <h1 class="textContainer">Datos tabulares</h1>

            <table class="table table-striped" id="tabla-tratamientos">
                <thead>
                    <tr>
                        <th scope="col">Tratamiento</th>
                        <th scope="col">Fecha de alta</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($todosTratamientos as $tratamiento)
                        @foreach ($tratamientosPorPaciente as $porPaciente)
                            @if ($porPaciente->tratamiento_id == $tratamiento->id)
                                <tr>
                                    <td>
                                        {{ $tratamiento->tratamiento }}
                                    </td>
                                    <td>
                                        {{\Carbon\Carbon::parse($porPaciente->fecha_alta)->format('d/m/Y')}}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>

            <h1 class="textContainer">Gráfico</h1>

            <canvas id="myChart" style="display:block; width:100%; height:450px;"></canvas>

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

    <script>
        //Gráfico 1 - Frecuencia de tratamientos
        var ctx = document.getElementById('myChart').getContext('2d');
        console.log('Labels:', <?= json_encode($labels) ?>);
        console.log('Data:', <?= json_encode($data) ?>);

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($labels) ?>,
                datasets: [{
                    label: 'Frecuencia de Tratamientos',
                    data: <?= json_encode($data) ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 5
                        }
                    }
                },
                responsive: true,
            }
        });
    </script>
</body>
</html>
