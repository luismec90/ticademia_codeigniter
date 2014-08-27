<div id="contenedor">
    <div id="contenedor-1-1" class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h1><a href="<?= base_url() ?>curso/<?= $idCurso ?>" class="btn btn-info" title="Ir al primer módulo"><i class="fa fa-reply"></i></a> Ranking grupal<small> <?= $nombre_curso ?></small></h1> </h1>

            </div>
        </div>
    </div>
    <div id="contenedor-1-2" class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <?php if (isset($puestoGrupoEstudiante)) { ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div >
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Puesto</th>
                                            <th>Grupo</th>
                                            <th>Puntaje</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr >
                                            <td><?= $puestoGrupoEstudiante ?></td>
                                            <td><?= $grupoEstudiante ?></td>
                                            <td><?= round($grupoPuntajeEstudiante) ?> </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <hr>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Puesto</th>
                            <th>Grupo</th>
                            <th>Puntaje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($ranking as $grupo => $row) {
                            ?>
                            <tr class="<?= (isset($grupoEstudiante) && $grupo == $grupoEstudiante) ? "info" : "" ?>">
                                <td><?= $i++ ?></td>
                                <td><?= $grupo ?></td>
                                <td><?= round($row) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>






