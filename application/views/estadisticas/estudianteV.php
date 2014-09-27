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
$current = $fechaInicio;
$end = Date('Y-m-d');
$startDate = strtotime($current);
$endDate = strtotime($end);
$i = 0;
$t = sizeof($distribucionNivelesPorDia);
$fila ="";
while ($startDate <= $endDate) {



    $fila .= "['" . dateToxAxis($current) . "'";
    foreach ($niveles as $nivel) {
        if (isset($distribucionNivelesPorDia[$current][$nivel->id_nivel])) {
                $fila.= "," . round($distribucionNivelesPorDia[$current][$nivel->id_nivel] / $cantidadMatriculas * 100,2);
        } else if(array_key_exists($nivel->id_nivel-1,$niveles)){
            $fila.= ",0";
        }
    }

    $fila .= "],";



    
    $current = date("Y-m-d", $startDate = strtotime('+1 day', $startDate));
}
$fila0 = "['Fecha'";
foreach ($niveles as $nivel) {
    $fila0.=",'{$nivel->nombre}'";
}
$fila0 .= "],";
echo $fila0;
echo $fila;
?>
                                    ]);


                                    var options = {
                                        hAxis: {title: 'Día del mes'},
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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Conexiones por día</h3>
                                </div>
                                <div class="panel-body">
                                    <center> <div id="conexiones-por-dia"></div> </center>
                                </div>
                            </div>

                            <script>

                                function conexionesPorDia() {

                                    // Create the data table.
                                    var data = google.visualization.arrayToDataTable([
<?php
$fila = "['Fecha','Conexiones por día'],";


echo $fila;
$current = $fechaInicio;
$end = Date('Y-m-d');
$startDate = strtotime($current);
$endDate = strtotime($end);
$i = 0;
$t = sizeof($conexionesPorDia);
while ($startDate <= $endDate) {
    $fila = "['" . dateToxAxis($current) . "'";
    if (isset($conexionesPorDia[$current])) {
        $fila.= "," . $conexionesPorDia[$current];
    } else {
        $fila.= ",0";
    }
    $fila .= "],";
    echo $fila;
    $current = date("Y-m-d", $startDate = strtotime('+1 day', $startDate));
}
?>
                                    ]);

                                    // Set chart options
                                    var options = {
                                        hAxis: {title: 'Día del mes'},
                                        vAxis: {title: 'Cantidad de estudiantes conectados'},
                                        height: 400};

                                    // Instantiate and draw our chart, passing in some options.
                                    var chart = new google.visualization.LineChart(document.getElementById('conexiones-por-dia'));
                                    chart.draw(data, options);
                                }
                            </script>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Conexiones por hora</h3>
                                </div>
                                <div class="panel-body">
                                    <center> <div id="conexiones-por-hora"></div> </center>
                                </div>
                            </div>

                            <script>

                                function conexionesPorHora() {

                                    // Create the data table.
                                    var data = google.visualization.arrayToDataTable([
<?php
$fila = "['Hora','Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],";


echo $fila;

$i = 0;

for ($i = 0; $i < 24; $i++) {
    $fila = "[$i";
    for ($j = 1; $j < 8; $j++) {
        if (isset($conexionesPorHora[$j][$i])) {
            $fila.= "," . $conexionesPorHora[$j][$i] . "";
        } else {
            $fila.= ",0";
        }
    }

    $fila .= "],";
    echo $fila;
}
?>

                                    ]);

                                    // Set chart options
                                    var options = {
                                        hAxis: {title: 'Hora del día (0-23)'},
                                        vAxis: {title: 'Cantidad de estudiantes conectados'},
                                        height: 400};

                                    // Instantiate and draw our chart, passing in some options.
                                    var chart = new google.visualization.LineChart(document.getElementById('conexiones-por-hora'));
                                    chart.draw(data, options);
                                }
                            </script>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>





