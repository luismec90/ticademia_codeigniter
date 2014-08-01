<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Material extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->estoyLogueado();
        $this->load->model('modulo_model');
        $this->load->model('material_model');
        $this->load->model('usuario_x_material_model');
    }

    public function crearMaterial() {
        require_once('assets/libs/getid3/getid3/getid3.php');

        $this->escapar($_POST);
        if (empty($_POST["modulo"])) {
            $this->mensaje("Por favor inténtalo nuevamente", "error");
        } else
        if (empty($_POST["nombre"]) || !isset($_POST["descripcion"]) || empty($_FILES["file"]) || $_FILES["file"]["error"] > 0) {
            $this->mensaje("Por favor inténtalo nuevamente", "error", "modulo/{$_POST["modulo"]}");
        }
        $modulo = $this->modulo_model->obtenerModulo($_POST["modulo"]);
        $idCurso = $modulo[0]->id_curso;
        $this->verificarMatricula($idCurso);

        $lastId = $this->material_model->crearMaterial($_POST["modulo"], $_POST["nombre"], $_POST["descripcion"]);

        $extension = $_FILES["file"]["name"];
        $extension = explode(".", $extension);
        $extension = end($extension);
        $ubicacion = $lastId . "." . strtolower($extension);
        $this->material_model->actulizarUbicacion($lastId, $ubicacion);

        if (strtolower($extension) == "mp4") {
            $getID3 = new getID3;
            $ThisFileInfo = $getID3->analyze($_FILES["file"]["tmp_name"]);
            $duracionSegundos = $ThisFileInfo['playtime_string'];
            $duracionSegundos = explode(":", $duracionSegundos);
            $duracionSegundos = $duracionSegundos[0] * 60 + $duracionSegundos[1];
            $this->material_model->actulizarDuracion($lastId, $duracionSegundos);
        }

        $ruta = "material/$idCurso";

        if (!file_exists($ruta)) {
            mkdir($ruta, 0777);
        }
        if (!file_exists("$ruta/{$_POST["modulo"]}")) {
            mkdir("$ruta/{$_POST["modulo"]}", 0777);
        }

        move_uploaded_file($_FILES["file"]["tmp_name"], "$ruta/{$_POST["modulo"]}/$ubicacion");
        $this->mensaje("Material creado exitosamente", "success", "curso/$idCurso");
    }

    public function editarMaterial() {
        $this->escapar($_POST);
        if (empty($_POST["modulo"]) || empty($_POST["material"])) {
            $this->mensaje("Por favor inténtalo nuevamente", "error");
        } else if (empty($_POST["nombre"]) || !isset($_POST["descripcion"])) {
            $idModulo = $_POST["modulo"];
            $modulo = $this->modulo_model->obtenerModulo($idModulo);
            $idCurso = $modulo[0]->id_curso;
            $this->mensaje("Por favor inténtalo nuevamente", "error", "curso/$idCurso");
        }
        $idModulo = $_POST["modulo"];
        $idMaterial = $_POST["material"];
        $modulo = $this->modulo_model->obtenerModulo($idModulo);
        $idCurso = $modulo[0]->id_curso;
        $this->verificarMatricula($idCurso);

        $material = $this->material_model->obtenerMaterial($idMaterial);
        if ($material[0]->id_modulo != $_POST["modulo"]) {
            $this->mensaje("Por favor inténtalo nuevamente", "error");
        }
        if ($_FILES["file"]['tmp_name'] != "") {
            if (file_exists("material/$idCurso/{$_POST["modulo"]}/" . $material[0]->ubicacion)) {
                unlink("material/$idCurso/{$_POST["modulo"]}/" . $material[0]->ubicacion);
            }

            $extension = $_FILES["file"]["name"];
            $extension = explode(".", $extension);
            $extension = end($extension);
            $ubicacion = $_POST["material"] . "." . strtolower($extension);
            move_uploaded_file($_FILES["file"]["tmp_name"], "material/$idCurso/{$_POST["modulo"]}/" . $ubicacion);
        }
        $this->material_model->actualizar($_POST["material"], $_POST["nombre"], $_POST["descripcion"], $material[0]->ubicacion);
        //   $this->mensaje("Material editado exitosamente", "success", "curso/$idCurso");
    }

    public function eliminarMaterial() {
        $this->escapar($_POST);
        if (empty($_POST["modulo"]) || empty($_POST["material"])) {
            $this->mensaje("Por favor inténtalo nuevamente", "error");
        }
        $idModulo = $_POST["modulo"];
        $idMaterial = $_POST["material"];
        $modulo = $this->modulo_model->obtenerModulo($idModulo);
        $idCurso = $modulo[0]->id_curso;
        $this->verificarMatricula($idCurso);

        $material = $this->material_model->obtenerMaterial($idMaterial);
        if ($material[0]->id_modulo != $_POST["modulo"]) {
            $this->mensaje("Por favor inténtalo nuevamente", "error");
        }
        if (file_exists("material/$idCurso/{$_POST["modulo"]}/" . $material[0]->ubicacion)) {
            unlink("material/$idCurso/{$_POST["modulo"]}/" . $material[0]->ubicacion);
        }
        $this->material_model->eliminar($_POST["material"]);
        $this->mensaje("Material eliminado exitosamente", "success", "curso/$idCurso");
    }

    public function ordenarMaterial() {
        $this->escapar($_POST);
        if (empty($_POST["modulo"])) {
            $this->mensaje("Por favor inténtalo nuevamante", "error");
        }
        $idModulo = $_POST["modulo"];
        $modulo = $this->modulo_model->obtenerModulo($idModulo);
        $idCurso = $modulo[0]->id_curso;
        $this->soyElProfesor($idCurso);
        if (!empty($_POST["orden"])) {
            $orden = explode(",", $_POST["orden"]);
            foreach ($orden as $key => $row) {
                $this->material_model->setOrden($row, $key);
            }
        }
        $this->mensaje("Materiales ordenados exitosamente", "success", "curso/$idCurso");
    }

    public function crearRegistro() {
        $fechaInicial = date('Y-m-d H:i:s');
        $data = array(
            'id_usuario' => $_SESSION["idUsuario"],
            'id_material' => $_POST["idMaterial"],
            'fecha_inicial' => $fechaInicial
        );
        $this->usuario_x_material_model->crearRegistro($data);
        $_SESSION[$_SESSION["idUsuario"] . "-" . $_POST['idMaterial']] = $this->db->insert_id();
    }

    public function actualizar() {
        $data = array(
            'id_usuario_x_material' => $_SESSION[$_SESSION["idUsuario"] . "-" . $_POST['idMaterial']],
            'duracion' => $_POST['duracion']
        );
        unset($_SESSION[$_SESSION["idUsuario"] . "-" . $_POST['idMaterial']]);
        $this->usuario_x_material_model->actualizar($data);
    }

    public function valorarMaterial() {
        $this->escapar($_POST);
        var_dump($_POST);
        if (empty($_POST["idMaterial"]) || empty($_POST["score"]) || !isset($_POST["comentario"])) {
            $this->mensaje("Por favor inténtalo nuevamente", "error");
        }
        $material = $this->material_model->obtenerMaterial($_POST["idMaterial"]);
        $idModulo = $material[0]->id_modulo;
        $modulo = $this->modulo_model->obtenerModulo($idModulo);
        $idCurso = $modulo[0]->id_curso;
        $this->verificarMatricula($idCurso);
        $this->load->model('material_valoracion_model');
        $where = array(
            'id_material' => $_POST["idMaterial"],
            'id_usuario' => $_SESSION["idUsuario"]
        );
        $valoracion = $this->material_valoracion_model->obtenerValoracion($where);
        if (sizeof($valoracion) > 0) {
            $data = array(
                'puntaje' => $_POST["score"] * 2,
                'comentario' => $_POST["comentario"]
            );
            $where = array(
                'id_material' => $_POST["idMaterial"],
                'id_usuario' => $_SESSION["idUsuario"]
            );
            $this->material_valoracion_model->actualizarValoracion($data, $where);
            $this->mensaje("Valoración actualizada exitosamente", "success", "curso/$idCurso");
        } else {
            $data = array(
                'id_usuario' => $_SESSION["idUsuario"],
                'id_material' => $_POST['idMaterial'],
                'puntaje' => $_POST["score"] * 2,
                'comentario' => $_POST["comentario"]
            );
            $this->material_valoracion_model->crearValoracion($data);
            $this->mensaje("Material valorado exitosamente", "success", "curso/$idCurso");
        }
    }

    public function verComentarios() {
        $this->load->model('material_valoracion_model');
        $this->escapar($_GET);
        if (empty($_GET["idMaterial"]) || !isset($_GET["pagina"])) {
            exit();
        }

        $filasPorPagina = 3;
        if (empty($_GET["pagina"])) {
            $inicio = 0;
            $paginaActual = 1;
        } else {
            $inicio = ($_GET["pagina"] - 1) * $filasPorPagina;
            $paginaActual = $_GET["pagina"];
        }
        $comentarios = $this->material_valoracion_model->obtenerRegistros($_GET["idMaterial"], $inicio, $filasPorPagina);
        $cantidadComentarios = $this->material_valoracion_model->cantidadRegistros();
        $cantidadComentarios = $cantidadComentarios[0]->cantidad;
        $cantidadPaginas = ceil($cantidadComentarios / $filasPorPagina);
        ?>
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th>Estudiante</th>
                        <th>Comentario</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    foreach ($comentarios as $row) {
                        ?>
                        <tr>
                            <td><?= $row->nombres . " " . $row->apellidos ?></td>
                            <td><?= $row->comentario ?></td>
                            <td><?= $row->fecha ?></td>
                        </tr>
                        <?php
                    }
                    ?> 
                </tbody>
            </table>
        </div>
        <div class="row">
            <ul id="paginacion" class="pagination pull-right">
                <li class="<?php
                if ($paginaActual == 1)
                    echo "active";
                else
                    echo "noActive";
                ?>"><a href="#" class="pagina-valoracion-material" data-id-material="<?= $_GET["idMaterial"] ?>" data-pagina="1">1</a></li>
                    <?php for ($i = 2; $i <= $cantidadPaginas; $i++) { ?>
                    <li class="<?php
                    if ($paginaActual == $i)
                        echo "active";
                    else
                        echo "noActive";
                    ?>"><a href="#" class="pagina-valoracion-material" data-id-material="<?= $_GET["idMaterial"] ?>" data-pagina="<?= $i ?>"><?= $i ?></a></li>
                    <?php } ?>
            </ul> 
        </div>
        <?php
    }

    public function estadisticasValoraciones() {
        $this->load->model('material_valoracion_model');

        $idMaterial = $this->input->get('idMaterial');

        $puntajes = $this->material_valoracion_model->obtenerValoraciones($idMaterial);


        $rows = array();
        $table = array();
        $table['cols'] = array(
            array('label' => 'Puntuación', 'type' => 'string'),
            array('label' => 'Cantidad', 'type' => 'number')
        );

        foreach ($puntajes as $r) {

            $temp = array();

            // the following line will be used to slice the Pie chart

            $temp[] = array('v' => "Puntuación: " . round($r->puntaje / 2, 1));

            // Values of each slice

            $temp[] = array('v' => (int) $r->cantidad);
            $rows[] = array('c' => $temp);
        }

        $table['rows'] = $rows;
        $jsonTable = json_encode($table);
        echo $jsonTable;
    }

    public function estadisticasAccesos() {
        $this->load->model('curso_model');

        $idMaterial = $this->input->get('idMaterial');
        $tipo = $this->input->get('tipo');
        $idCurso = $this->input->get('idCurso');

        $curso = $this->curso_model->obtenerCursoCompleto($idCurso);
        $fechaInicio = $curso[0]->fecha_inicio;

        if ($tipo == "pdf") {
            $accesosPorDia = $this->material_model->obtenerAccesosPorDia($idMaterial, $idCurso);

            $datos = array();
            foreach ($accesosPorDia as $row) {
                $datos[$row->fecha] = $row->cantidad;
            }

            $rows = array();
            $table = array();
            $table['cols'] = array(
                array('label' => 'Fecha', 'type' => 'string'),
                array('label' => 'Visitas', 'type' => 'number')
            );

            $current = $fechaInicio;
            $end = Date('Y-m-d');
            $startDate = strtotime($current);
            $endDate = strtotime($end);
            while ($startDate <= $endDate) {
                $temp = array();

                if (isset($datos[$current])) {
                    $rows[] = array('c' => array(array("v" => dateToxAxis($current)), array("v" => $datos[$current])));
                } else {
                    $rows[] = array('c' => array(array("v" => dateToxAxis($current)), array("v" => 0)));
                }
                $current = date("Y-m-d", $startDate = strtotime('+1 day', $startDate));
            }
            $table['rows'] = $rows;
            $jsonTable = json_encode($table);
            echo $jsonTable;
        } else {
            $tiempoPromedioReproduccion = $this->material_model->tiempoPromdedioReproduccionPorMaterial($idCurso, $idMaterial);
            $videoVisitas = $this->material_model->visitasPorDiaVideo($idCurso, $idMaterial);

            $rows = array();
            $table = array();
            $table['cols'] = array(
                array('label' => 'Fecha', 'type' => 'string'),
                array('label' => 'Visitas', 'type' => 'number'),
                array('label' => 'Porcentaje promedio de reproducción (%)', 'type' => 'number')
            );

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
                    $a = dateToxAxis($current);
                    $b = $videoVisitas[$i]->visitas;
                    $i++;
                } else {
                    $a = dateToxAxis($current);
                    $b = 0;
                }

                if ($j < $t2 && $tiempoPromedioReproduccion[$j]->fecha == $current) {
                    $c = round($tiempoPromedioReproduccion[$j]->minutos * 60 / $tiempoPromedioReproduccion[$j]->duracion * 100);
                    $j++;
                } else {
                    $c = 0;
                }
                $rows[] = array('c' => array(array("v" => $a), array("v" => $b), array("v" => $c)));
                $current = date("Y-m-d", $startDate = strtotime('+1 day', $startDate));
            }

            $table['rows'] = $rows;
            $jsonTable = json_encode($table);
            echo $jsonTable;
        }
    }

}
