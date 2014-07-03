<div id="contenedor">
    <div id="contenedor-1-1" class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h1>Estadísticas de los estudiantes <small> <?= $nombre_curso ?></small></h1> </h1>
            </div>
        </div>
        <div id="contenedor-1-2" class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="text-center">  Estudiantes matriculados: <?= $cantidadMatriculas ?> </h3>
                            <hr>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Distribución de niveles</h3>
                                </div>
                                <div class="panel-body">
                                    <center> <div id="distribucion-niveles"></div> </center>
                                </div>
                            </div>

                            <script>

                                function distribucionNiveles() {

                                    // Create the data table.
                                    var data = new google.visualization.DataTable();
                                    data.addColumn('string', 'Topping');
                                    data.addColumn('number', 'Slices');
                                    data.addRows([
<?php foreach ($distribucionNiveles as $row) { ?>
                                            ['<?= $row->nombre ?>', <?= $row->cantidad ?>],
<?php } ?>
                                    ]);

                                    // Set chart options
                                    var options = {
                                        'height': 400};

                                    // Instantiate and draw our chart, passing in some options.
                                    var chart = new google.visualization.PieChart(document.getElementById('distribucion-niveles'));
                                    chart.draw(data, options);
                                }
                            </script>
                        </div>
                        <div class="col-md-6">

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
$fila = "['Fecha'";
foreach ($niveles as $nivel) {
    $fila.=",'Nivel {$nivel->id_nivel}'";
}
$fila .= "],";
echo $fila;
$current = $fechaInicio;
$end = Date('Y-m-d');
$startDate = strtotime($current);
$endDate = strtotime($end);
$i = 0;
$t = sizeof($distribucionNivelesPorDia);
while ($startDate <= $endDate) {



    $fila = "['" . dateToxAxis($current) . "'";
    foreach ($niveles as $nivel) {
        if (isset($distribucionNivelesPorDia[$current][$nivel->id_nivel])) {
            $fila.= "," . round($distribucionNivelesPorDia[$current][$nivel->id_nivel] / $cantidadMatriculas * 100);
        } else {
            $fila.= ",0";
        }
    }
    $fila .= "],";
    echo $fila;
    $current = date("Y-m-d", $startDate = strtotime('+1 day', $startDate));
}
?>
                                    ]);


                                    var options = {
                                        vAxis: {title: 'Cantidad de estudiantes matriculados %',
                                        },
                                       
                                       
                                        'height': 400};
                                    // Instantiate and draw our chart, passing in some options.
                                    var chart = new google.visualization.LineChart(document.getElementById('distribucion-niveles-por-dia'));
                                    chart.draw(data, options);
                                }
                            </script>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <hr>
                            <h3 class="text-center">  Estudiantes conectados: <?= $cantidadEstudiantesConectados ?> </h3>
                            <hr>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





