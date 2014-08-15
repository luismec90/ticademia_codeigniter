<?php

namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Reto implements MessageComponentInterface {

    protected $aulas; //Contiene todas las conexiones de los estudiantes separadas por curso
    protected $diccionario;
    protected $disponibles;
    protected $enDuelo;

    public function __construct() {
        $this->aulas = array();
        $this->diccionario = array();
        $this->disponibles = array();
        $this->enDuelo = array();
    }

    public function onOpen(ConnectionInterface $conn) {
        
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg);

        if (!isset($data->id_usuario) || in_array($data->id_usuario, array(1, 4, 6))) {

            switch ($data->tipo) {
                case "inicio": // El estudiante establece la conexión
                    $resourceId = $from->resourceId; // Id de la conexion entre el cliente y el servidor

                    /* Datos enviados por el cliente */
                    $idCurso = $data->id_curso;
                    $idUsuario = $data->id_usuario;
                    $nombreUsuario = $data->nombre_usuario;
                    /* ---- */


                    if (!isset($this->diccionario[$resourceId])) {
                        $this->diccionario[$resourceId] = array("id_usuario" => $idUsuario, "id_curso" => $idCurso, "nombre_usuario" => $nombreUsuario);
                    }

                    if (!isset($this->disponibles[$idCurso][$idUsuario]) && !isset($this->enDuelo[$idCurso][$idUsuario])) {// Si no esta en disponibles y no esta en duelo es la primera vez que se conecta
                        $imagen = $this->ejecutarQuery2("SELECT nombres,apellidos,imagen,sexo FROM usuario WHERE id_usuario='$idUsuario'");
                        $row = mysql_fetch_array($imagen);
                        $this->disponibles[$idCurso][$idUsuario] = array("nombre" => $row["nombres"] . " " . $row["apellidos"], "sexo" => $row["sexo"], "imagen" => $row["imagen"]);
                        var_dump($this->disponibles);
                    }

                    $this->aulas[$idCurso][$idUsuario][$resourceId] = $from;

                    break;

                case "retar": // El estudiante establece la conexión

                    /* Datos enviados por el cliente */
                    $idCurso = $data->id_curso;
                    $idUsuario = $data->id_usuario;
                    $nombreUsuario = $data->nombre_usuario;
                    $usuarioRetado = $this->seleccionarRetado($idCurso, $idUsuario);

                    /* ---- */

                    if ($usuarioRetado == -1) {
                        $user = array();
                        $user[$idUsuario] = $nombreUsuario;
                        $dataToUser = json_encode(array("tipo" => "no_hay_oponentes", "datos" => $user));
                        foreach ($this->aulas[$idCurso][$idUsuario] as $row) {
                            $row->send($dataToUser);
                        }
                    } else {
                        $this->enDuelo[$idCurso][$idUsuario]["usuario_retado"] = $usuarioRetado;
                        unset($this->disponibles[$idCurso][$idUsuario]);
                        unset($this->disponibles[$idCurso][$usuarioRetado]);
                        $user = array();
                        $user[$idUsuario] = $nombreUsuario;
                        $dataToUser = json_encode(array("tipo" => "retado", "datos" => $user));
                        foreach ($this->aulas[$idCurso][$usuarioRetado] as $row) {
                            $row->send($dataToUser);
                        }
                    }
                    break;

                case "aceptar_reto": // EL usuario retado acepta

                    /* Datos enviados por el cliente */
                    $idCurso = $data->id_curso;
                    $idUsuario = $data->id_usuario;
                    $usuarioRetador = $data->usuario_retador;
                    $nombreUsuario = $data->nombre_usuario;
                    /* ---- */

                    if (isset($this->aulas[$idCurso][$idUsuario]) && isset($this->aulas[$idCurso][$usuarioRetador])) { // Si los dos usuarios estan conectados se puede proceder
                        $datos = $this->seleccionEvaluacion($idCurso, $usuarioRetador, $idUsuario);
                        $idEvaluacion = $datos["id_evaluacion"];
                        $ruta = $datos["ruta"];
                        $reto = array();
                        $reto["reto"] = $ruta;
                        $dataToUser = $this->dataToUserRetoAceptado($idCurso, $usuarioRetador, $idUsuario, $datos["id_modulo"], $idEvaluacion, $datos["ruta"]);

                        foreach ($this->aulas[$idCurso][$usuarioRetador] as $row) {// Se le notifica a todas las conexiones del usuario retador para que inicie el duelo
                            $row->send($dataToUser);
                        }
                        foreach ($this->aulas[$idCurso][$idUsuario] as $row) { // Se le notifica a todas las conexiones del usuario retado para que inicie el duelo
                            $row->send($dataToUser);
                        }
                    } else if (isset($this->aulas[$idCurso][$idUsuario])) { // De lo contrario si el usuario retador esta desconectado se le informa al retado que el duelo ha sido cancelado
                        $user = array();
                        $user[$idUsuario] = $data->nombre_usuario;
                        $dataToUser = json_encode(array("tipo" => "desconectado_antes", "datos" => $user));
                        foreach ($this->json[$idCurso][$idUsuario] as $row) { // se le envia el mensaje a todas las locaciones del usuario retado
                            $row->send($dataToUser); // Los datos que se envia en realidad solo es para crear un Json que recorrer con el JS
                        }
                    }
                    break;

                case "rechazar_reto":// El usuario retado rechaza

                    /* Datos enviados por el cliente */
                    $idCurso = $data->id_curso;
                    $usuarioRetador = $data->usuario_retador;
                    $usuarioRetado = $this->enDuelo[$idCurso][$usuarioRetador]["usuario_retado"];
                    $nombreUsuario = $data->nombre_usuario;
                    /* ---- */

                    $this->disponibles[$idCurso][$usuarioRetador] = true;
                    $this->disponibles[$idCurso][$usuarioRetado] = true;
                    unset($this->enDuelo[$idCurso][$usuarioRetador]);

                    if (isset($this->aulas[$idCurso][$usuarioRetador])) {// SI el usuario retador esta conectado se le notifica que el usuario retado no acepto
                        $user = array();
                        $user[$data->id_usuario] = $nombreUsuario;
                        $dataToUser = json_encode(array("tipo" => "reto_rechazado",
                            "datos" => $user));
                        foreach ($this->aulas[$idCurso][$usuarioRetador] as $row) {// se le envia el mensaje a todas las locaciones del usuario retador
                            $row->send($dataToUser);
                        }
                    }
                    unset($this->enDuelo[$idCurso][$usuarioRetador]);
                    break;

                case "enviar_respuesta":// Un usuario envio la respuesta del reto
                    /* Datos enviados por el cliente */
                    $idCurso = $data->id_curso;
                    $posibleGanador = $data->posible_ganador;
                    $nombreUsuario = $data->nombre_usuario;
                    $estatus = $data->estatus;
                    $fechaIni = $data->fecha_inicio_reto;
                    $fechaFin = $data->fecha_fin_reto;
                    /* ---- */

                    $usuarioRetador = $this->getRetador($idCurso, $posibleGanador);

                    if ($estatus == "correcto") {// si la respuesta es correcta
                        $idRetoTabla = $this->enDuelo[$idCurso][$usuarioRetador]["id_reto_tabla"]; // Obtengo el id de la tabla reto correspondiente a este duelo
                        $registroRetoTabla = $this->ejecutarQuery2("SELECT * FROM reto WHERE id_reto='$idRetoTabla'");
                        $registroRetoTabla = mysql_fetch_array($registroRetoTabla);
                        $this->ejecutarQuery("UPDATE usuario_x_modulo SET puntaje=puntaje+{$registroRetoTabla["monto"]} WHERE id_usuario='$posibleGanador' AND id_modulo=(SELECT id_modulo FROM evaluacion WHERE id_evaluacion='{$registroRetoTabla["id_evaluacion"]}')");
                        $this->ejecutarQuery("UPDATE reto SET ganador='$posibleGanador' where id_reto='$idRetoTabla'"); //Establesco al ganador en la BD
                        $perdedor = ($posibleGanador == $registroRetoTabla["retador"]) ? $registroRetoTabla["retado"] : $registroRetoTabla["retador"]; // Si el ganador es el retador perdio el retado y si el que gano es el retado perdio el retaor
                        $this->ejecutarQuery("UPDATE usuario_x_modulo SET puntaje=puntaje-{$registroRetoTabla["monto"]} WHERE id_usuario='$perdedor' AND id_modulo=(SELECT id_modulo FROM evaluacion WHERE id_evaluacion='{$registroRetoTabla["id_evaluacion"]}')");
                        /* Envio el mensaje; notifico a ambos estudiantes de quien fue el ganador */
                        $user[$posibleGanador] = $nombreUsuario;
                        $dataToUser = json_encode(array("tipo" => "ganador", "datos" => $user));
                        $this->enviarMesajeAUsuario($idCurso, $usuarioRetador, $dataToUser);
                        $this->enviarMesajeAUsuario($idCurso, $this->enDuelo[$idCurso][$usuarioRetador]["usuario_retado"], $dataToUser);
                        /* ---- */
                        $this->disponibles[$idCurso][$usuarioRetador] = true;
                        $this->disponibles[$idCurso][$this->enDuelo[$idCurso][$usuarioRetador]["usuario_retado"]] = true;
                        unset($this->enDuelo[$idCurso][$usuarioRetador]); // Elimino el duelo ps ya concluyo
                    } else if ($this->enDuelo[$idCurso][$usuarioRetador]["respuestas_enviadas"] != 0) {// Si no es correcto y un estudiante ya habia enviado una respuesta es empate
                        /* Envio el mensaje; notiico a ambos estudiantes de que es empate */
                        $user = array();
                        $user[$posibleGanador] = $nombreUsuario;
                        $dataToUser = json_encode(array("tipo" => "empate", "datos" => $user));
                        $this->enviarMesajeAUsuario($idCurso, $usuarioRetador, $dataToUser);
                        $this->enviarMesajeAUsuario($idCurso, $this->enDuelo[$idCurso][$usuarioRetador]["usuario_retado"], $dataToUser);
                        /* ---- */
                        $this->disponibles[$idCurso][$usuarioRetador] = true;
                        $this->disponibles[$idCurso][$this->enDuelo[$idCurso][$usuarioRetador]["usuario_retado"]] = true;
                        unset($this->enDuelo[$idCurso][$usuarioRetador]); // Elimino el duelo ps ya concluyo
                    } else {// de lo contrario es la primera respuetsa enviada y fue incorrecta
                        $this->enDuelo[$idCurso][$usuarioRetador]["respuestas_enviadas"] ++; //Sirve de control para declarar el empate
                    }
                    break;
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $resourceId = $conn->resourceId;
        if (isset($this->diccionario[$resourceId])) {
            $info = $this->diccionario[$resourceId];
            $idCurso = $info["id_curso"];
            $idUsuario = $info["id_usuario"];
            $nombreUsuario = $info["nombre_usuario"];

            var_dump($this->enDuelo);
            /* Verificar si el usuario estaba en duelo */

            /* Si era retador se le informa de la desconexion al retado */
            if (isset($this->enDuelo[$idCurso][$idUsuario])) {

                if (isset($this->enDuelo[$idCurso][$idUsuario]["id_reto_tabla"])) {
                    $tipo = "desconectado";
                } else {
                    $tipo = "desconectado_antes";
                }
                $idUsuarioRetado = $this->enDuelo[$idCurso][$idUsuario]["usuario_retado"];
                $user = array();
                $user[$idUsuario] = $nombreUsuario;
                $data_to_user = json_encode(array("tipo" => $tipo, "datos" => $user));
                foreach ($this->aulas[$idCurso][$this->enDuelo[$idCurso][$idUsuario]["usuario_retado"]] as $row) {
                    $row->send($data_to_user);
                }
                $this->disponibles[$idCurso][$this->enDuelo[$idCurso][$idUsuario]["usuario_retado"]] = true;
                unset($this->enDuelo[$idCurso][$this->enDuelo[$idCurso][$idUsuario]["usuario_retado"]]);
            }

            /* Si era el retado se le informa de la desconexion al retador */
            if (isset($this->enDuelo[$idCurso])) {
                foreach ($this->enDuelo[$idCurso] as $idUsuarioRetador => $val) {//recorrer todos los duelos
                    if ($val["usuario_retado"] == $idUsuario) {
                        if (isset($val["id_reto_tabla"])) {
                            $tipo = "desconectado";
                        } else {
                            $tipo = "desconectado_antes";
                        }

                        $user = array();
                        $user[$idUsuario] = $nombreUsuario;
                        $data_to_user = json_encode(array("tipo" => $tipo, "datos" => $user));
                        foreach ($this->aulas[$idCurso][$idUsuarioRetador] as $row) {
                            $row->send($data_to_user);
                        }
                        $this->disponibles[$idCurso][$idUsuarioRetador] = true;
                        unset($this->enDuelo[$idCurso][$idUsuarioRetador]);
                    }
                }
            }

            unset($this->aulas[$idCurso][$idUsuario][$resourceId]);
            unset($this->diccionario[$resourceId]);
            if (sizeof($this->aulas[$idCurso][$idUsuario]) == 0) {// Sí no tiene mas conexiones activas
                unset($this->aulas[$idCurso][$idUsuario]);
                unset($this->disponibles[$idCurso][$idUsuario]);
                unset($this->enDuelo[$idCurso][$idUsuario]);
            }
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        
    }

    function seleccionarRetado($idCurso, $idRetador) {
        // return 4;


        $consultaPreguntasRetador = $this->ejecutarQuery2("SELECT ue.id_usuario, GROUP_CONCAT(DISTINCT ue.id_evaluacion) as evaluaciones 
              FROM `usuario_x_evaluacion` ue
              JOIN usuario_x_curso uc ON ue.id_usuario=uc.id_usuario AND uc.id_curso='$idCurso'
             WHERE ue.calificacion = 1  AND ue.id_usuario = '$idRetador'
             GROUP BY ue.id_usuario");

        while ($row = mysql_fetch_array($consultaPreguntasRetador)) {
            $Px = explode(",", $row['evaluaciones']);
        }
        $where = "";
        foreach ($this->disponibles[$idCurso] as $key => $val) {
            if ($key != $idRetador) {
                $where.="$key,";
            }
        }
        $where = rtrim($where, ",");
        if ($where != "") {
            $consultaPreguntasRetados = $this->ejecutarQuery2("
           SELECT ue.id_usuario, GROUP_CONCAT(DISTINCT ue.id_evaluacion) as evaluaciones 
            FROM `usuario_x_evaluacion` ue 
            JOIN usuario_x_curso uc ON ue.id_usuario=ue.id_usuario AND uc.id_curso='$idCurso'
            WHERE ue.calificacion = 1  AND  ue.id_usuario IN ($where)
            GROUP BY ue.id_usuario");
        } else {
            $consultaPreguntasRetados = "";
        }

        $P = array();
        $idRetados = array();
        if ($consultaPreguntasRetados) {
            while ($row = mysql_fetch_array($consultaPreguntasRetados)) {
                array_push($P, explode(",", $row['evaluaciones']));
                array_push($idRetados, $row['id_usuario']);
            }
        }

        $m = sizeof($Px);

        $t = 0;
        $L = sizeof($P);
        $V = array();
        $VP = array();
        if ($L == 0) {// Si no hay oponentes devuelva -1
            return -1;
        }
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
        if ($t != 0) {
            for ($y = 0; $y < $L; $y++) {
                $VP[$y] = $V[$y] / $t; //Puntuacion relativa del posible retado y}
            }
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
        //   return array("id_evaluacion" => 1, "id_modulo" => 17, "ruta" => "resources/1/17/1/launch.html");

        $consultaPreguntasReto = $this->ejecutarQuery2("
                            SELECT evaluaciones.id_usuario, evaluaciones.id_evaluacion, evaluaciones.id_modulo, evaluaciones.orden, evaluaciones.dias, COALESCE(retos.aciertos,0) aciertos 

                            FROM

                            (SELECT DISTINCT U.id_usuario, U.id_evaluacion, E.id_modulo, E.orden, ABS(DATEDIFF(M.fecha_inicio, CURDATE())) AS dias
                            FROM  `usuario_x_evaluacion` U,  `evaluacion` E,  `modulo` M
                            WHERE 
                            (U.id_usuario = '$idRetador' OR U.id_usuario = '$idRetado') 
                            AND U.calificacion = 1
                            AND U.id_evaluacion = E.id_evaluacion
                            AND M.id_curso=1
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
        return array("id_evaluacion" => $idPregunta, "id_modulo" => $idModulo, "ruta" => "resources/$idCurso/$idModulo/$idPregunta/launch.html");
    }

    private function ejecutarQuery($query) {
        echo "$query \n";
        $link = mysql_connect("localhost", "root", "1Minerva.Unal");
        mysql_select_db("ticademia", $link);
        mysql_query($query, $link);
        $latsId = mysql_insert_id();
        mysql_close($link);
        return $latsId;
    }

    function ejecutarQuery2($query) {
        echo "$query \n";
        $link = mysql_connect("localhost", "root", "1Minerva.Unal");
        mysql_select_db("ticademia", $link);
        $r = mysql_query($query, $link);
        mysql_close($link);
        return $r;
    }

    private function getRetador($idCurso, $idUsuario) {// Obtener el retador
        if (isset($this->enDuelo[$idCurso][$idUsuario])) {
            return $idUsuario;
        }
        foreach ($this->enDuelo[$idCurso] as $key => $val) {//recorrer todos los duelos
            if ($val["usuario_retado"] == $idUsuario) { // si existe el usuario  retado
                return $key; // devolver el retador
            }
        }
        return -1; // De lo contrario devulevo -1 e indica que el duelo no existe
    }

    private function enviarMesajeAUsuario($idCurso, $idUsuario, $mensaje) {
        foreach ($this->aulas[$idCurso][$idUsuario] as $row) {
            $row->send($mensaje);
        }
    }

    private function dataToUserRetoAceptado($idCurso, $usuarioRetador, $usuarioRetado, $idModulo, $idEvaluacion, $ruta) {

        $retador = $this->ejecutarQuery2("SELECT * FROM usuario WHERE id_usuario='$usuarioRetador'");
        $row = mysql_fetch_array($retador);
        $retador = array("id_usuario" => $usuarioRetador, "nombre" => utf8_encode($row["nombres"] . " " . $row["apellidos"]), "avatar" => $row["imagen"]);


        $retado = $this->ejecutarQuery2("SELECT * FROM usuario WHERE id_usuario='$usuarioRetado'");
        $row = mysql_fetch_array($retado);
        $retado = array("id_usuario" => $usuarioRetado, "nombre" => utf8_encode($row["nombres"] . " " . $row["apellidos"]), "avatar" => $row["imagen"]);

        $oponentesDummies = array();
        $i = 1;
        foreach ($this->disponibles[$idCurso] as $row) {
            array_push($oponentesDummies, $row["imagen"]);
            if ($i >= 19) {
                break;
            }
            $i++;
        }
        if ($i < 20) {
            while ($i < 20) {
                array_push($oponentesDummies, "default.png");
                $i++;
            }
        }

        $cantidadModulos = 0;
        $modulos = $this->ejecutarQuery2("SELECT *  FROM modulo WHERE id_curso='$idCurso' order by fecha_inicio");
        while ($row = mysql_fetch_array($modulos)) {
            $cantidadModulos++;
            if ($row["id_modulo"] == $idModulo) {
                $posicionModuloSeleccionado = $cantidadModulos;
            }
        }

        $cantidadEvaluaciones = 0;
        $evaluaciones = $this->ejecutarQuery2("SELECT *  FROM evaluacion WHERE id_modulo='$idModulo' order by orden");
        while ($row = mysql_fetch_array($evaluaciones)) {
            $cantidadEvaluaciones++;
            if ($row["id_evaluacion"] == $idEvaluacion) {
                $posicionEvaluacionSeleccionada = $cantidadEvaluaciones;
            }
        }
        $monto1 = rand(1, 6);
        $monto2 = rand(1, 6);
        $montoTotal = $monto1 + $monto2;
        $arrayDatos = array("retador" => $retador, "retado" => $retado, "oponentesDummies" => $oponentesDummies, "cantidadModulos" => $cantidadModulos, "posMod" => $posicionModuloSeleccionado, "id_modulo" => $idModulo, "cantidadEvaluaciones" => $cantidadEvaluaciones, "posEv" => $posicionEvaluacionSeleccionada, "id_evaluacion" => $idEvaluacion, "monto1" => $monto1, "monto2" => $monto2, "ruta" => $ruta);

        $lastId = $this->ejecutarQuery("INSERT INTO reto(retador,retado,id_curso,id_evaluacion,monto) VALUES('$usuarioRetador','{$usuarioRetado}','{$idCurso}','{$idEvaluacion}','{$montoTotal}')");
        $this->enDuelo[$idCurso][$usuarioRetador]["usuario_retado"] = $usuarioRetado;
        $this->enDuelo[$idCurso][$usuarioRetador]["id_reto_tabla"] = $lastId;
        $this->enDuelo[$idCurso][$usuarioRetador]["respuestas_enviadas"] = 0;
        return json_encode(array("tipo" => "reto_aceptado", "datos" => $arrayDatos));
    }

}
