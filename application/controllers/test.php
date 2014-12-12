<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Test extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function index2()
    {
        for ($i = 1; $i <= 15; $i ++)
        {
            $query="Select count(*) cantidad from usuario_x_curso where grupo=$i";
            $r = $this->db->query($query)->result();
            $cantidadEstudiantes= $r[0]->cantidad;


            $query = "SELECT SUM(T.preguntas_resueltas)/126 AS tmp FROM (SELECT ue.id_usuario,count(distinct(ue.id_evaluacion)) preguntas_resueltas
                        FROM usuario_x_evaluacion ue
                        JOIN usuario_x_curso uc ON uc.id_usuario=ue.id_usuario
                        WHERE ue.calificacion>0.6
                        AND uc.grupo=$i
                        GROUP BY ue.id_usuario) AS T";
            $r = $this->db->query($query)->result();
            $q1 = $r[0]->tmp;

      //      echo round($q1,1)."<br>";


            $query = "SELECT SUM(T.intentos)/(126*$cantidadEstudiantes) tmp FROM (SELECT ue.id_usuario,count(ue.id_evaluacion) intentos FROM `usuario_x_evaluacion` ue
                        JOIN usuario_x_curso uc ON uc.id_usuario=ue.id_usuario
                        WHERE uc.grupo=$i
                        GROUP BY ue.id_usuario) AS T";
            $r = $this->db->query($query)->result();
            $q1 = $r[0]->tmp;

          //  echo round($q1,1)."<br>";


            $query = "SELECT SUM(T.materiales_vistos)/($cantidadEstudiantes) tmp FROM (SELECT um.id_usuario,count(distinct(um.id_material)) materiales_vistos
                        FROM usuario_x_material um
                        JOIN usuario_x_curso uc ON uc.id_usuario=um.id_usuario
                        WHERE uc.grupo=$i GROUP BY um.id_usuario) AS T";
            $r = $this->db->query($query)->result();
            $q1 = $r[0]->tmp;

            //   echo round($q1,1)."<br>";

            $query = "SELECT AVG(T.tmp) tmp FROM (SELECT um.id_material,LEAST(TIMESTAMPDIFF(SECOND, um.fecha_inicial, um.fecha_final)/m.duracion*100,100) tmp
                      FROM `usuario_x_material` um JOIN material m ON m.id_material=um.id_material
                      JOIN usuario_x_curso uc ON uc.id_usuario=um.id_usuario
                      WHERE uc.grupo=$i
                      AND um.fecha_final is not null order by tmp desc) AS T";

            $r = $this->db->query($query)->result();
            $q1 = $r[0]->tmp;

              echo round($q1,1)."%<br>";
        }
    }

    public function index()
    {
        $query = "Select * from modulo order by id_modulo";

        $modulos = $this->db->query($query)->result();

        ?>
        <LINK href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" type="text/css">

        <br><br>
        <div class="container">
            <?php

            $query = "SELECT count(*) cantidad FROM usuario_x_curso uc
                    JOIN usuario u ON u.id_usuario=uc.id_usuario
                    AND u.correo LIKE '%@unal.edu.co'";

            $r = $this->db->query($query)->result();

            $cantidadEstudiantes = $r[0]->cantidad;
            ?>
            <h3>Cantidad de estudiantes matriculados: <?= $cantidadEstudiantes ?> </h3>
            <hr>
            <h4>Q1: Estudiantes que resolvieron al menos 1 ejercicio</h4>
            <h4>Q2: Cantidad promedio de preguntas resueltas</h4>
            <h4>Q3: Cantidad promedio de intentos por pregunta</h4>
            <h4>Q4: Cantidad de ingresos promedio</h4>
            <h4>Q6: Cantidad promedio de videos vistos</h4>
            <h4>Q7: Porcentaje promedio de reproducción</h4>
            <h4>Q8: Total de duelos realizados</h4>
            <hr>

            <table class="table table-bordered table-hover">
                <tr>
                    <td>Modulo</td>
                    <td>Q1</td>
                    <td>Q1</td>
                    <td>Q3</td>
                    <td>Q4</td>
                    <td>Q6</td>
                    <td>Q7</td>
                    <td>Q8</td>
                <tr>


                    <?php
                    foreach ($modulos as $modulo)
                    {
                    $query = "SELECT count(*) cantidad from evaluacion WHERE id_modulo={$modulo->id_modulo}";
                    $r = $this->db->query($query)->result();
                    $cantidadPreguntas = $r[0]->cantidad;


                    $query = "SELECT COUNT(DISTINCT(ue.id_usuario)) AS tmp
                        FROM usuario_x_evaluacion ue
                        JOIN evaluacion e ON ue.id_evaluacion=e.id_evaluacion
                        WHERE e.id_modulo={$modulo->id_modulo}
                        AND ue.calificacion>0.6";
                    $r = $this->db->query($query)->result();
                    $q1 = $r[0]->tmp;

                    $query = "SELECT SUM(T.preguntas_resueltas)/$cantidadEstudiantes AS tmp FROM (SELECT ue.id_usuario,count(distinct(ue.id_evaluacion)) preguntas_resueltas
                        FROM usuario_x_evaluacion ue
                        JOIN evaluacion e ON ue.id_evaluacion=e.id_evaluacion
                        WHERE e.id_modulo={$modulo->id_modulo}
                        AND ue.calificacion>0.6
                        GROUP BY ue.id_usuario) AS T";
                    $r = $this->db->query($query)->result();
                    $q2 = $r[0]->tmp;


                    $query = "SELECT SUM(T.intentos)/($cantidadEstudiantes*$cantidadPreguntas) tmp FROM (SELECT ue.id_usuario,count(ue.id_evaluacion) intentos FROM `usuario_x_evaluacion` ue
                        JOIN evaluacion e ON ue.id_evaluacion=e.id_evaluacion
                        WHERE e.id_modulo={$modulo->id_modulo}
                        GROUP BY ue.id_usuario) AS T";
                    $r = $this->db->query($query)->result();
                    $q3 = $r[0]->tmp;

                    $query = "SELECT count(*)/$cantidadEstudiantes tmp FROM bitacora WHERE `fecha_salida` IS NOT NULL AND fecha_salida>='$modulo->fecha_inicio 00:00:00' AND  fecha_salida<='$modulo->fecha_fin 23:59:59'";
                    $r = $this->db->query($query)->result();
                    $q4 = $r[0]->tmp;


                    /* Q6 */

                    $query = "SELECT SUM(T.materiales_vistos)/($cantidadEstudiantes) tmp FROM (SELECT um.id_usuario,count(distinct(um.id_material)) materiales_vistos FROM `usuario_x_material` um
                        JOIN material m ON um.id_material=m.id_material
                        WHERE m.id_modulo={$modulo->id_modulo}
                        GROUP BY um.id_usuario) AS T";
                    $r = $this->db->query($query)->result();
                    $q6 = $r[0]->tmp;

                    /* Q7 */

                    $query = "SELECT AVG(T.tmp) tmp FROM (SELECT um.id_material,LEAST(TIMESTAMPDIFF(SECOND, um.fecha_inicial, um.fecha_final)/m.duracion*100,100) tmp
                        FROM `usuario_x_material` um
                        JOIN material m ON m.id_material=um.id_material
                         WHERE m.id_modulo={$modulo->id_modulo} AND um.fecha_final is not null order by tmp desc) AS T";
                    $r = $this->db->query($query)->result();
                    $q7 = $r[0]->tmp;


                    /* Q8 */

                    $query = "SELECT count(*) tmp FROM reto WHERE  fecha>='$modulo->fecha_inicio 00:00:00' AND fecha<='$modulo->fecha_fin 23:59:59'";
                    $r = $this->db->query($query)->result();
                    $q8 = $r[0]->tmp;

                    ?>
                <tr>
                    <td><?= $modulo->nombre ?></td>
                    <td><?= $q1 ?></td>
                    <td><?= $q2 ?></td>
                    <td><?= $q3 ?></td>
                    <td><?= $q4 ?></td>
                    <td><?= $q6 ?></td>
                    <td><?= $q7 ?></td>
                    <td><?= $q8 ?></td>
                </tr>
                <?php

                }
                ?>
            </table>
        </div>
    <?php

    }

}
