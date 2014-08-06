<?php

$idRetado = seleccionarRetado(1, 1);
echo $idRetado;
echo seleccionEvaluacion(1, 1, $idRetado);

function seleccionarRetado($idCurso, $idRetador) {
    $disponibles[1][1] = true;
    $disponibles[1][4] = true;
    $disponibles[1][5] = true;
    $disponibles[1][6] = true;
    $consultaPreguntasRetador = ejecutarQuery2("SELECT id_usuario, GROUP_CONCAT(DISTINCT id_evaluacion) as evaluaciones 
              FROM `usuario_x_evaluacion` 
             WHERE calificacion = 1  AND id_usuario = $idRetador
             GROUP BY id_usuario");

    while ($row = mysql_fetch_array($consultaPreguntasRetador)) {
        $Px = explode(",", $row['evaluaciones']);
//        var_dump($Px);
    }
    $where = "";
    $usuariosConectados = 0;
    foreach ($disponibles[$idCurso] as $key => $val) {
        if ($key != $idRetador) {
            $where.="$key,";
            $usuariosConectados++;
        }
    }
    $where = rtrim($where, ",");
    $consultaPreguntasRetados = ejecutarQuery2("
            SELECT id_usuario, GROUP_CONCAT(DISTINCT id_evaluacion) as evaluaciones 
            FROM `usuario_x_evaluacion` 
            WHERE calificacion = 1  AND  id_usuario IN ($where)
            GROUP BY id_usuario");
    $P = array();
    $idRetados = array();
    while ($row = mysql_fetch_array($consultaPreguntasRetados)) {
        array_push($P, explode(",", $row['evaluaciones']));
        array_push($idRetados, $row['id_usuario']);
    }


    $m = sizeof($Px);

    $t = 0;
    $L = $usuariosConectados;
    $V = array();
    $VP = array();
    for ($y = 0; $y < $L; $y++) {
        $c = 0;
        $i = 0;
        $j = 0;
        $Py = $P[$y];
        //Py : arreglo de enteros con las idendificaciones de las preguntas resueltas por el posible retado y
        $n = sizeof($Py); //tamaño del arreglo Py
        while ($i != $m && $j != $n) {
            if ($Px[$i] == $Py[$j]) {
                $c++;
                $i++;
                $j++;
            } else if ($Px[$i] < $Py[$j])
                $i++;
            else
                $j++;
        }
        $V[$y] = $c / $n; //Puntuacion de y (porcentaje de preguntas resueltas por el posible retado, también resueltas por el retador

        $t += $V[$y]; //Sumatoria de puntuaciones
    }

    for ($y = 0; $y < $L; $y++) {
        $VP[$y] = $V[$y] / $t; //Puntuacion relativa del posible retado y}
    }

    $y = 0;
    $d = 0;
    $a = rand() / getrandmax();
    while ($d < $a) {
        $d += $VP[$y];
        $y++;
    }
    return $idRetados[$y - 1]; //Indice del retado elegido
}

function seleccionEvaluacion($idCurso, $idRetador, $idRetado) {
    $consultaPreguntasReto = ejecutarQuery2("
                            SELECT evaluaciones.id_usuario, evaluaciones.id_evaluacion, evaluaciones.id_modulo, evaluaciones.orden, evaluaciones.dias, COALESCE(retos.aciertos,0) aciertos 

                            FROM

                            (SELECT DISTINCT U.id_usuario, U.id_evaluacion, E.id_modulo, E.orden, ABS(DATEDIFF(M.fecha_inicio, CURDATE())) AS dias
                            FROM  `usuario_x_evaluacion` U,  `evaluacion` E,  `modulo` M
                            WHERE 
                            (U.id_usuario = '$idRetador' OR U.id_usuario = '$idRetado') 
                            AND U.calificacion = 1
                            AND U.id_evaluacion = E.id_evaluacion
                            AND E.id_modulo = M.id_modulo) evaluaciones

                            LEFT JOIN 

                            (SELECT ganador, id_evaluacion, COUNT(*) AS aciertos 
                            FROM `reto` 
                            WHERE 
                            ganador = '$idRetador' OR ganador = '$idRetado' 
                            GROUP BY ganador, id_evaluacion) retos

                            ON evaluaciones.id_usuario = retos.ganador AND evaluaciones.id_evaluacion = retos.id_evaluacion

                            ORDER BY id_usuario, id_evaluacion
                            ");
    $resultSetPreguntasReto = array();
    while ($row = mysql_fetch_array($consultaPreguntasReto)) {
        array_push($resultSetPreguntasReto, $row);
    }

//mn : Cantidad de preguntas resueltas combinadas de retador y retado (filas que arroja la consulta)
    $retador = array();
    $retado = array();
    $preguntasRetador = array();
    $preguntasRetado = array();
    $moduloPreguntasRetador = array();
    $moduloPreguntasRetado = array();
    $preguntas = array();
    $preguntasP = array();
    $idPreguntas = array();
    $idModulos = array();
    $m = 0;
    $n = 0;
    foreach ($resultSetPreguntasReto as $rows) {//Por cada fila en la consulta $resultSetPreguntasReto
        if ($rows['id_usuario'] == $idRetador) {
            $retador[$m] = 60 + $rows['dias'] + 20 + $rows['orden'] + 100 * max(0, 5 - $rows['aciertos']);
            $preguntasRetador[$m] = $rows['id_evaluacion'];
            $moduloPreguntasRetador[$m] = $rows['id_modulo'];
            $m++;
        } else {
            $retado[$n] = 60 + $rows['dias'] + 20 + $rows['orden'] + 100 * max(0, 5 - $rows['aciertos']);
            $preguntasRetado[$n] = $rows['id_evaluacion'];
            $moduloPreguntasRetado[$n] = $rows['id_modulo'];
            $n++;
        }
    }
    $c = 0;
    $i = 0;
    $j = 0;
    $t = 0;
    while ($i != $m && $j != $n) {


        if ($preguntasRetador[$i] == $preguntasRetado[$j]) {

            $preguntas[$c] = ($preguntasRetador[$i] + $preguntasRetado[$j]) / 2; //Puntuacion de cada pregunta común
            $t += $preguntas[$c]; //Sumatoria de puntuaciones
            $idPreguntas[$c] = $preguntasRetador[$i];
            $idModulos[$c] = $moduloPreguntasRetador[$i];
            $c++;
            $i++;
            $j++;
        } else if ($preguntasRetador[$i] < $preguntasRetado[$j]) {

            $i++;
        } else {
            $j++;
        }
    }
    for ($k = 0; $k < $c; $k++) {
        $preguntasP[$k] = $preguntas[$k] / $t; //Puntuacion relativa de cada pregunta
    }
    $k = 0;
    $d = 0;
    $a = rand() / getrandmax();
    while ($d < $a) {
        $d += $preguntasP[$k];
        $k++;
    }

    $idPregunta = $idPreguntas[$k - 1]; //identificador de la pregunta elegida
    $idModulo = $idModulos[$k - 1]; //identificador del módulo al que pertenece
    return "resources/$idCurso/$idModulo/$idPregunta/launch.html";
}

function ejecutarQuery($query) {
    $link = mysql_connect("localhost", "root", "");
    mysql_select_db("ticademia", $link);
    mysql_query($query, $link);
    $latsId = mysql_insert_id();
    mysql_close($link);
    echo $query . "<br>";
    return $latsId;
}

function ejecutarQuery2($query) {
    $link = mysql_connect("localhost", "root", "");
    mysql_select_db("ticademia", $link);
    $r = mysql_query($query, $link);
    mysql_close($link);
    return $r;
}

/*


$Px = array(5, 8, 10, 15); // Arreglo de enteros con las idendificaciones de las preguntas resueltas por el retador
$P = array(//arreglo de enteros con las idendificaciones de las preguntas resueltas por el retador i
    array(5, 8, 10),
    array(5, 8, 9),
    array(6, 10, 12, 20),
    array(2, 5, 11)
);
$idRetados = array(2, 3, 4, 5);

$idRetador = 1;
$idRetado = $idRetados[seleccionarRetado($Px, $P, 5)];
echo $idRetado;
seleccionEvaluacion($idRetador, $idRetado);

function seleccionarRetado($Px, $P, $usuariosConectados) {
    $m = sizeof($Px);

    $t = 0;
    $L = $usuariosConectados - 1; // cantidad de usuarios conectados sin contar al retador
    $V = array();
    $VP = array();
    for ($y = 0; $y < $L; $y++) {
        $c = 0;
        $i = 0;
        $j = 0;
        $Py = $P[$y];
        //Py : arreglo de enteros con las idendificaciones de las preguntas resueltas por el posible retado y
        $n = sizeof($Py); //tamaño del arreglo Py
        while ($i != $m && $j != $n) {
            if ($Px[$i] == $Py[$j]) {
                $c++;
                $i++;
                $j++;
            } else if ($Px[$i] < $Py[$j])
                $i++;
            else
                $j++;
        }
        $V[$y] = $c / $n; //Puntuacion de y (porcentaje de preguntas resueltas por el posible retado, también resueltas por el retador

        $t += $V[$y]; //Sumatoria de puntuaciones
    }

    for ($y = 0; $y < $L; $y++) {
        $VP[$y] = $V[$y] / $t; //Puntuacion relativa del posible retado y}
    }

    $y = 0;
    $d = 0;
    $a = rand() / getrandmax();
    while ($d < $a) {
        $d += $VP[$y];
        $y++;
    }
    return $y - 1; //Indice del retado elegido
}

function seleccionEvaluacion($idRetador, $idRetado) {

    $resultSetPreguntasReto = array(
        array("id_usuario" => $idRetador, "id_evaluacion" => 1, "id_modulo" => 17, "orden" => 1, "dias" => 0, "aciertos" => 0),
        array("id_usuario" => $idRetador, "id_evaluacion" => 2, "id_modulo" => 17, "orden" => 2, "dias" => 0, "aciertos" => 0),
        array("id_usuario" => $idRetador, "id_evaluacion" => 3, "id_modulo" => 17, "orden" => 3, "dias" => 0, "aciertos" => 0),
        array("id_usuario" => $idRetado, "id_evaluacion" => 2, "id_modulo" => 17, "orden" => 2, "dias" => 0, "aciertos" => 0),
        array("id_usuario" => $idRetado, "id_evaluacion" => 3, "id_modulo" => 17, "orden" => 3, "dias" => 0, "aciertos" => 0));

//mn : Cantidad de preguntas resueltas combinadas de retador y retado (filas que arroja la consulta)
    $retador = array();
    $retado = array();
    $preguntasRetador = array();
    $preguntasRetado = array();
    $moduloPreguntasRetador = array();
    $moduloPreguntasRetado = array();
    $preguntas = array();
    $preguntasP = array();
    $idPreguntas = array();
    $idModulos = array();
    $m = 0;
    $n = 0;
    foreach ($resultSetPreguntasReto as $rows) {//Por cada fila en la consulta $resultSetPreguntasReto
        if ($rows['id_usuario'] == $idRetador) {
            $retador[$m] = 60 + $rows['dias'] + 20 + $rows['orden'] + 100 * max(0, 5 - $rows['aciertos']);
            $preguntasRetador[$m] = $rows['id_evaluacion'];
            $moduloPreguntasRetador[$m] = $rows['id_modulo'];
            $m++;
        } else {
            $retado[$n] = 60 + $rows['dias'] + 20 + $rows['orden'] + 100 * max(0, 5 - $rows['aciertos']);
            $preguntasRetado[$n] = $rows['id_evaluacion'];
            $moduloPreguntasRetado[$n] = $rows['id_modulo'];
            $n++;
        }
    }
    $c = 0;
    $i = 0;
    $j = 0;
    $t = 0;
    while ($i != $m && $j != $n) {
     
      
        if ($preguntasRetador[$i] == $preguntasRetado[$j]) {
         
            $preguntas[$c] = ($preguntasRetador[$i] + $preguntasRetado[$j]) / 2; //Puntuacion de cada pregunta común
            $t += $preguntas[$c]; //Sumatoria de puntuaciones
            $idPreguntas[$c] = $preguntasRetador[$i];
            $idModulos[$c] = $moduloPreguntasRetador[$i];
            $c++;
            $i++;
            $j++;
        } else if ($preguntasRetador[$i] < $preguntasRetado[$j]){
          
           $i++;}
        else{
        $j++;
        
        }
    }
    for ($k = 0; $k < $c; $k++) {
        $preguntasP[$k] = $preguntas[$k] / $t; //Puntuacion relativa de cada pregunta
    }
    $k = 0;
    $d = 0;
    $a = rand() / getrandmax();
    while ($d < $a) {
        $d += $preguntasP[$k];
        $k++;
    }

    echo  "<br>".$idPreguntas[$k - 1] . "<br>"; //identificador de la pregunta elegida
    echo $idModulos[$k - 1]; //identificador del módulo al que pertenece
}
*/