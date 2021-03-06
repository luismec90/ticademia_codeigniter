<div id="contenedor">
    <div id="contenedor-1-1" class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h1>Estadísticas de los materiales <small> <?= $nombre_curso ?></small></h1> </h1>
            </div>
        </div>
        <div id="contenedor-1-2" class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="text-center"> Cantidad de PDFs: <?= $cantidadPDFs[0]->cantidad ?> - Cantidad de videos: <?= $cantidadVideos[0]->cantidad ?></h3>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Distribución de PDFs vistos por día</h3>
                        </div>
                        <div class="panel-body">
                            <center> <div id="visitas-pdfs">

                                </div> </center>
                        </div>
                    </div>
                    <script>
                        function visitasPdfs() {

                            // Create the data table.
                            var data = new google.visualization.DataTable();
                            data.addColumn('string', 'Topping');
                            data.addColumn('number', 'Visitas');
                            data.addRows([
<?php
$current = $fechaInicio;
$end = Date('Y-m-d');
$startDate = strtotime($current);
$endDate = strtotime($end);
$i = 0;
$t = sizeof($pdfVisitas);
while ($startDate <= $endDate) {
    if ($i < $t && $pdfVisitas[$i]->fecha == $current) {
        echo "['" . dateToxAxis($current) . "',{$pdfVisitas[$i]->visitas}],";
        $i++;
    } else {
        echo "['" . dateToxAxis($current) . "',0],";
    }
    $current = date("Y-m-d", $startDate = strtotime('+1 day', $startDate));
}
?>
                            ]);

                            // Set chart options
                            var options = {
                                'height': 400};

                            // Instantiate and draw our chart, passing in some options.
                            var chart = new google.visualization.LineChart(document.getElementById('visitas-pdfs'));
                            chart.draw(data, options);
                        }

                    </script>
                </div>
              <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Diagrama de líneas y barras con cantidad de videos vistos y porcentaje promedio de visualización vs. tiempo (en dias), desde el dia de inicio hasta el día actual</h3>
                        </div>
                        <div class="panel-body">
                            <center> <div id="visitas-reproduccion">

                                </div> </center>
                        </div>
                    </div>
                    <script>
                        function visitasReproduccion() {

                            var data = google.visualization.arrayToDataTable([
<?php
echo "['Fecha', 'Visitas', 'Porcentaje promedio de reproducción (%)'],";

$current = $fechaInicio;
$end = Date('Y-m-d');
$startDate = strtotime($current);
$endDate = strtotime($end);
$t = sizeof($videoVisitas);
$i = 0;
$t2 = sizeof($tiempoPromedioReproduccion);
$j = 0;
while ($startDate <= $endDate) {
    if ($i < $t && $videoVisitas[$i]->fecha == $current) {
        echo "['" . dateToxAxis($current) . "',{$videoVisitas[$i]->visitas},";
        $i++;
    } else {
        echo "['" . dateToxAxis($current) . "',0,";
    }

    if ($j < $t2 && $tiempoPromedioReproduccion[$j]->fecha == $current) {
        echo "".round($tiempoPromedioReproduccion[$j]->minutos*60/$tiempoPromedioReproduccion[$j]->duracion*100)."],";
        $j++;
    } else {
        echo "0],";
    }
    $current = date("Y-m-d", $startDate = strtotime('+1 day', $startDate));
}
?>
                            ]);


                            var options = {
                                vAxes: {0: {title:'Cantidad de videos vistos',logScale: false, minValue: 0},
                                    1: {title:'Porcentaje promedio de reproducción (%)',logScale: false, minValue: 0, maxValue: 100}},
                                series: {
                                    0: {targetAxisIndex: 0},
                                    1: {targetAxisIndex: 1},
                                },
                                height: 400

                            };
                            var chart = new google.visualization.ComboChart(document.getElementById('visitas-reproduccion'));
                            chart.draw(data, options);
                        }

                    </script>
                </div>
            </div>
<!--            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Tiempo promedio reproducción por día en minutos</h3>
                        </div>
                        <div class="panel-body">
                            <center> <div id="tiempo-promedio-reproduccion">

                                </div> </center>
                        </div>
                    </div>
                    <script>
                        function tiempoPromedioReproduccion() {

                            // Create the data table.
                            var data = new google.visualization.DataTable();
                            data.addColumn('string', 'Topping');
                            data.addColumn('number', 'Tiempo promedio de reproducción en minutos');
                            data.addRows([
<?php
$current = $fechaInicio;
$end = Date('Y-m-d');
$startDate = strtotime($current);
$endDate = strtotime($end);
$i = 0;
$t = sizeof($tiempoPromedioReproduccion);
while ($startDate <= $endDate) {
    if ($i < $t && $tiempoPromedioReproduccion[$i]->fecha == $current) {
        echo "['" . dateToxAxis($current) . "',{$tiempoPromedioReproduccion[$i]->minutos}],";
        $i++;
    } else {
        echo "['" . dateToxAxis($current) . "',0],";
    }
    $current = date("Y-m-d", $startDate = strtotime('+1 day', $startDate));
}
?>
                            ]);

                            // Set chart options
                            var options = {
                                'height': 400};

                            // Instantiate and draw our chart, passing in some options.
                            var chart = new google.visualization.LineChart(document.getElementById('tiempo-promedio-reproduccion'));
                            chart.draw(data, options);
                        }

                    </script>
                </div>
                    <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Distribución de videos vistos por día</h3>
                        </div>
                        <div class="panel-body">
                            <center> <div id="visitas-videos">

                                </div> </center>
                        </div>
                    </div>
                    <script>
                        function visitasVideos() {

                            // Create the data table.
                            var data = new google.visualization.DataTable();
                            data.addColumn('string', 'Topping');
                            data.addColumn('number', 'Visitas');
                            data.addRows([
<?php
$current = $fechaInicio;
$end = Date('Y-m-d');
$startDate = strtotime($current);
$endDate = strtotime($end);
$i = 0;
$t = sizeof($videoVisitas);
while ($startDate <= $endDate) {
    if ($i < $t && $videoVisitas[$i]->fecha == $current) {
        echo "['" . dateToxAxis($current) . "',{$videoVisitas[$i]->visitas}],";
        $i++;
    } else {
        echo "['" . dateToxAxis($current) . "',0],";
    }
    $current = date("Y-m-d", $startDate = strtotime('+1 day', $startDate));
}
?>
                            ]);

                            // Set chart options
                            var options = {
                                'height': 400};

                            // Instantiate and draw our chart, passing in some options.
                            var chart = new google.visualization.LineChart(document.getElementById('visitas-videos'));
                            chart.draw(data, options);
                        }

                    </script>
                </div>
              
            </div>-->
        </div>
    </div>
</div>
