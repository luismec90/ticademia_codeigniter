<?php

namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Reto implements MessageComponentInterface {

    protected $aulas; //Contiene todas las conexiones de lso estudiantes separadas por curso
    protected $json; //Contiene todas los estudiantes conectados (sin duplicados) para un curso en especifico
    protected $enDuelo; // Conetiene los ids delos estudiamtes en duelo; $idretador=>$idRetado

    public function __construct() {
        $this->aulas = array();
        $this->json = array();
        $this->enDuelo = array();
    }

    public function onOpen(ConnectionInterface $conn) {
        
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg);

        switch ($data->tipo) {

            case "inicio": // El estudiante establece la conexión

                $resourceId = $from->resourceId; // Id de la conezion entre el cliente y el servidor

                /* Datos enviados por el cliente */
                $idCurso = $data->id_curso;
                $idUsuario = $data->id_usuario;
                $nombreUsuario = $data->nombre_usuario;
                /* ---- */

                /* Ingresar cliente estudiante en el aula  */
                $this->aulas[$idCurso][$resourceId] = $from;
                $this->aulas[$idCurso][$resourceId]->id_usuario = $idUsuario;
                $this->aulas[$idCurso][$resourceId]->nombre_usuario = $nombreUsuario;
                /* --- */

                /* Enviar la lista de estudiantes conectados al estudiante que acabo de ingresar */
                if (isset($this->json[$idCurso])) {
                    $from->send(json_encode(array("tipo" => "inicio", "datos" => $this->json[$idCurso])));
                }
                /* --------- */

                /* Informale a los demas estudiantes del curso que un estudiante se acabo de conectar */
                if (!isset($this->json[$idCurso][$idUsuario])) {// Si el estudiante no existe en el array de estudiantes conectados para un curso en especifico
                    $this->json[$idCurso][$idUsuario] = array("nombre_usuario" => $data->nombre_usuario, "id_resources" => ""); // Registrar el estudiante en el curso
                    $this->json[$idCurso][$idUsuario]["id_resources"][$resourceId] = $resourceId; // Almacenos todas las locaciones del estudiante
                    $user = array();
                    $user[$idUsuario] = $data->nombre_usuario;
                    $dataToUser = json_encode(array("tipo" => "user_on", "datos" => $user));
                    foreach ($this->aulas[$idCurso] as $row) {// Recorro todos las conexiones de los estudiantes para un curso
                        if ($idUsuario != $row->id_usuario) {// si el estudiante actual es diferente al estudiante que envio el mensaje
                            $row->send($dataToUser); // Enviar mensaje
                        }
                    }
                }
                break;

            case "retar": // Un estudiante reta a otro

                /* Datos enviados por el cliente */
                $idCurso = $data->id_curso;
                $idUsuario = $data->id_usuario;
                $nombreUsuario = $data->nombre_usuario;
                $usuarioRetado = $data->usuario_retado;
                /* ---- */

                /* Notificar al usuario retado */
                if (isset($this->json[$idCurso][$usuarioRetado])) {// Si el usuario retado esta conectado.
                    $user = array();
                    $user[$idUsuario] = $nombreUsuario;
                    $dataToUser = json_encode(array("tipo" => "retado", "datos" => $user));
                    foreach ($this->json[$idCurso][$usuarioRetado]["id_resources"] as $row) {
                        $this->aulas[$idCurso][$row]->send($dataToUser);
                    }
                }
                break;

            case "acpetar_reto": // EL usuario retado acepta

                /* Datos enviados por el cliente */
                $idCurso = $data->id_curso;
                $idUsuario = $data->id_usuario;
                $usuarioRetador = $data->usuario_retador;
                $nombreUsuario = $data->nombre_usuario;
                /* ---- */

                if (isset($this->json[$idCurso][$idUsuario]) && isset($this->json[$idCurso][$usuarioRetador])) { // Si los dos usuarios estan conectados se puede proceder
                    $user = array();
                    $user[$idUsuario] = $data->nombre_usuario;
                    $dataToUser = json_encode(array("tipo" => "reto_aceptado", "datos" => $user));

                    foreach ($this->json[$idCurso][$usuarioRetador]["id_resources"] as $row) {// Se le notofica a todas las conexiones del usuario retador para que inicie el duelo
                        $this->aulas[$idCurso][$row]->send($dataToUser);
                    }
                    foreach ($this->json[$idCurso][$idUsuario]["id_resources"] as $row) { // Se le notofica a todas las conexiones del usuario retado para que inicie el duelo
                        $this->aulas[$idCurso][$row]->send($dataToUser);
                    }
                    $lastId = $this->ejecutarQuery("INSERT INTO reto(retador,retado,id_curso) VALUES('$usuarioRetador','{$idUsuario}','{$idCurso}')");
                    $this->enDuelo[$usuarioRetador]["usuario_retado"] = $idUsuario;
                    $this->enDuelo[$usuarioRetador]["id_reto_tabla"] = $lastId;
                    $this->enDuelo[$usuarioRetador]["respuestas_enviadas"] = 0;
                } else if (isset($this->json[$idCurso][$idUsuario])) { // De lo contrario si el usuario retador esta desconectado se le informa al retado que el duelo ha sido cancelado
                    $user = array();
                    $user[$idUsuario] = $data->nombre_usuario;
                    $dataToUser = json_encode(array("tipo" => "desconectado_antes", "datos" => $user));
                    foreach ($this->json[$idCurso][$idUsuario]["id_resources"] as $row) { // se le envia el mensaje a todas las locaciones del usuario retado
                        $this->aulas[$idCurso][$row]->send($dataToUser); // Los datos que se envia en realidad solo es para crear un Json que recorrer con el JS
                    }
                }
                break;

            case "rechazar_reto":// El usuario retado rechaza

                /* Datos enviados por el cliente */
                $idCurso = $data->id_curso;
                $usuarioRetador = $data->usuario_retador;
                $nombreUsuario = $data->nombre_usuario;
                /* ---- */

                if (isset($this->json[$idCurso][$usuarioRetador])) {// SI el usuario retador esta conectado se le notifica que el usuario retado no acepto
                    $user = array();
                    $user[$data->id_usuario] = $nombreUsuario;
                    $dataToUser = json_encode(array("tipo" => "reto_rechazado", "datos" => $user));
                    foreach ($this->json[$idCurso][$usuarioRetador]["id_resources"] as $row) {// se le envia el mensaje a todas las locaciones del usuario retador
                        $this->aulas[$idCurso][$row]->send($dataToUser);
                    }
                }
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

                $usuarioRetador = $this->getRetador($posibleGanador);

                if ($estatus == "correcto") {// si la respuesta es correcta
                    $idRetoTabla = $this->enDuelo[$usuarioRetador]["id_reto_tabla"]; // Obtengo el id de la tabla reto correspondiente a este duelo
                    $this->ejecutarQuery("UPDATE reto SET ganador='$posibleGanador' where id_reto='$idRetoTabla'"); //Establesco al ganador en la BD
                    /* Envio el mensaje; notiico a ambos estudiantes de quien fue el ganador */
                    $user[$posibleGanador] = $nombreUsuario;
                    $dataToUser = json_encode(array("tipo" => "ganador", "datos" => $user));
                    $this->enviarMesajeAUsuario($idCurso, $usuarioRetador, $dataToUser);
                    $this->enviarMesajeAUsuario($idCurso, $this->enDuelo[$usuarioRetador]["usuario_retado"], $dataToUser);
                    /* ---- */
                    unset($this->enDuelo[$usuarioRetador]); // Elimino el duelo ps ya concluyo
                } else if ($this->enDuelo[$usuarioRetador]["respuestas_enviadas"] != 0) {// Si no es correcto y un estudiante ya habia enviado una respuesta es empate
                    /* Envio el mensaje; notiico a ambos estudiantes de que es empate */
                    $user = array();
                    $user[$posibleGanador] = $nombreUsuario;
                    $dataToUser = json_encode(array("tipo" => "empate", "datos" => $user));
                    $this->enviarMesajeAUsuario($idCurso, $usuarioRetador, $dataToUser);
                    $this->enviarMesajeAUsuario($idCurso, $this->enDuelo[$usuarioRetador]["usuario_retado"], $dataToUser);
                    /* ---- */
                    unset($this->enDuelo[$usuarioRetador]); // Elimino el duelo ps ya concluyo
                } else {// de lo contrario es la primera respuetsa enviada y fue incorrecta
                    $this->enDuelo[$usuarioRetador]["respuestas_enviadas"] ++; //Sirve de control para declarar el empate
                }
                break;
        }
    }

    public function onClose(ConnectionInterface $conn) {
        foreach ($this->aulas as $key => $row) {
            if (array_key_exists($conn->resourceId, $row)) {// Verificar si el esa conexion efectivamente existe
                $idUsuario = $row[$conn->resourceId]->id_usuario;
                $nombreUsuario = $row[$conn->resourceId]->nombre_usuario;

                unset($this->json[$key][$idUsuario]["id_resources"][$conn->resourceId]); // Elimino la conexion del json

                if (sizeof($this->json[$key][$idUsuario]["id_resources"]) == 0) { // Si no hay mas conexiones de ese usuario en el json, eliminarlo y notificar
                    unset($row[$conn->resourceId]);
                    unset($this->json[$key][$idUsuario]);
                    $user = array();
                    $user[$idUsuario] = $nombreUsuario;
                    $data_to_user = json_encode(array("tipo" => "user_off", "datos" => $user));
                    foreach ($this->aulas[$key] as $row) {
                        $row->send($data_to_user);
                    }
                }

                /* Verificar si el usuario estaba en duelo */
                /* Si era retador se le informa de la desconexion al retado */
                if (isset($this->enDuelo[$idUsuario])) {
                    $idUsuarioRetado = $this->enDuelo[$idUsuario]["usuario_retado"];
                    $user = array();
                    $user[$idUsuario] = $nombreUsuario;
                    $data_to_user = json_encode(array("tipo" => "desconectado", "datos" => $user));
                    foreach ($this->json[$key][$idUsuarioRetado]["id_resources"] as $row) {
                        $this->aulas[$key][$row]->send($data_to_user);
                    }
                    unset($this->enDuelo[$idUsuario]);
                }

                /* Si era el retado se le informa de la desconexion al retador */
                foreach ($this->enDuelo as $idUsuarioRetador => $val) {//recorrer todos los duelos
                    if ($val["usuario_retado"] == $idUsuario) {
                        $user = array();
                        $user[$idUsuario] = $nombreUsuario;
                        $data_to_user = json_encode(array("tipo" => "desconectado", "datos" => $user));
                        foreach ($this->json[$key][$idUsuarioRetador]["id_resources"] as $row) {
                            $this->aulas[$key][$row]->send($data_to_user);
                        }
                        unset($this->enDuelo[$idUsuarioRetador]);
                    }
                }
            }
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    private function ejecutarQuery($query) {
        $link = mysql_connect("localhost", "root", "qwe123admin");
        mysql_select_db("minerva", $link);
        mysql_query($query, $link);
        $latsId = mysql_insert_id();
        mysql_close($link);
        echo $query;
        return $latsId;
    }

    private function getRetador($idUsuario) {// Obtener el retador
        if (isset($this->enDuelo[$idUsuario])) {
            return $idUsuario;
        }
        foreach ($this->enDuelo as $key => $val) {//recorrer todos los duelos
            if ($val["usuario_retado"] == $idUsuario) { // si existe el usuario  retado
                return $key; // devolver el retador
            }
        }
        return -1; // De lo contrario devulevo -1 e indica que el duelo no existe
    }

    private function enviarMesajeAUsuario($idCurso, $idUsuario, $mensaje) {
        foreach ($this->json[$idCurso][$idUsuario]["id_resources"] as $row) {
            $this->aulas[$idCurso][$row]->send($mensaje);
        }
    }

}
