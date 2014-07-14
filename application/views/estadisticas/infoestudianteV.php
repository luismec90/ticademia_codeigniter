<div id="contenedor">
    <div id="contenedor-1-1" class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h1> <a href="<?= base_url() ?>ranking/<?= $idCurso ?>" class="btn btn-info" title="Ir atrás"><i class="fa fa-reply"></i></a> Detalles del estudiante:  <?= $usuario[0]->nombres ?> <small> <?= $nombre_curso ?></small></h1> </h1>
            </div>
        </div>
        <div id="contenedor-1-2" class="container-fluid">
            <table class="table">
                <thead>
                <th>Nombre completo</th>
                <th>Correo</th>
                <th>Usuario desde</th>
                <th>Fecha matricula</th>
                <th>Sexo</th>
                </thead>
                <tbody>
                    <tr>
                        <td> <?= $usuario[0]->nombres . " " . $usuario[0]->apellidos ?></td>
                        <td> <?= $usuario[0]->correo ?></td>
                        <td> <?= $usuario[0]->fecha_creacion ?></td>
                        <td> <?= $usuario[0]->fecha_matricula ?></td>
                        <td> <?= ($usuario[0]->sexo == "m") ? "Masculino" : "Femenino"; ?></td>
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <?php foreach ($modulos as $row) { ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <h3><?= $row->nombre ?></h3>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Materiales</h3>
                                </div>
                                <div class="panel-body">
                                    <table class="table">
                                        <thead>
                                        <th>Titulo</th>
                                        <th>Tipo</th>
                                        <th>Visto</th>
                                        <th>Porcentaje de visualización</th>
                                        <th>Valoracion</th>
                                        <th>Comentarios</th>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($materiales[$row->id_modulo] as $row2) { ?>
                                                <tr>
                                                    <td><?= $row2->nombre ?></td>
                                                    <td><?= $row2->tipo ?></td>
                                                    <td><?= ($row2->visto) ? "Si" : "No" ?></td>
                                                    <td><?php if($row2->tipo=="video" && isset($porcentajeVisualizacion[$row->id_modulo][$row2->id_material])){ echo $porcentajeVisualizacion[$row->id_modulo][$row2->id_material]."%"; } else if($row2->tipo=="video"){
                                                        echo "0%";
                                                    }else echo "n/a"; ?></td>
                                                    <td><div class="estrellas" data-score="<?= $row2->puntaje / 2 ?>" ></div></td>
                                                    <td><?= $row2->comentario ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-5">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Evaluaciones</h3>
                                </div>
                                <div class="panel-body">
                                    <table class="table">
                                        <thead>
                                        <th>Número</th>
                                        <th>Tipo</th>
                                        <th>Aciertos/Intentos</th>
                                        <th>Mejor tiempo (segundos)</th>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($evaluaciones[$row->id_modulo] as $row2) { ?>
                                                <tr>
                                                    <td><?= $row2->id_evaluacion ?></td>
                                                    <td><?= $row2->tipo_evaluacion ?></td>
                                                    <td><?= $row2->aciertos ?>/<?= $row2->intentos ?></td>
                                                    <td><?= ($row2->mejor_tiempo != "99999") ? $row2->mejor_tiempo : "n/a" ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
