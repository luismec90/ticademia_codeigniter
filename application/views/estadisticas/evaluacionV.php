<div id="contenedor">
    <div id="contenedor-1-1" class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h1>Estadísticas de las evaluaciones <small> <?= $nombre_curso ?></small></h1> </h1>
            </div>
        </div>
        <div id="contenedor-1-2" class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="text-center"> Cantidad total de evaluaciones <?= $totalEvaluaciones ?></h3>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Distribución de niveles por día</h3>
                        </div>
                        <div class="panel-body">
                            <center> <div id="distribucion-niveles-por-dia"></div> </center>
                        </div>
                    </div>
                    <script>

                        function distribucionNivelesPorDia() {
                            var data = google.visualization.arrayToDataTable([
<?php
echo "['Fecha','Evaluaciones intentadas','Evaluaciones resueltas'],";

$current = $fechaInicio;
$end = Date('Y-m-d');
$startDate = strtotime($current);
$endDate = strtotime($end);
$i = 0;
while ($startDate <= $endDate) {

    $fila = "['" . dateToxAxis($current) . "'";
    if (isset($cantidadPreguntasIntentadasPorDia[$current])) {
        $fila.= ",$cantidadPreguntasIntentadasPorDia[$current]";
    } else {
        $fila.= ",0";
    }
    if (isset($cantidadPreguntasResueltasPorDia[$current])) {
        $fila.= ",$cantidadPreguntasResueltasPorDia[$current]";
    } else {
        $fila.= ",0";
    }

    $fila .= "],";
    echo $fila;
    $current = date("Y-m-d", $startDate = strtotime('+1 day', $startDate));
}
?>
                            ]);


                            var options = {
                                vAxis: {title: 'Cantidad de evaluaciones',
                                },
                                'height': 400};
                            // Instantiate and draw our chart, passing in some options.
                            var chart = new google.visualization.LineChart(document.getElementById('distribucion-niveles-por-dia'));
                            chart.draw(data, options);
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
