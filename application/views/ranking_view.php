<div id="contenedor">
    <div id="contenedor-1-1" class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h1>Ranking <small> <?= $nombre_curso ?></small></h1> </h1>

            </div>
            <div class="col-sm-12">
                <a href="<?= base_url() ?>ranking/<?= $idCurso ?>" class="btn btn-primary <?= ($limit == 10) ? "active" : ""; ?>">Top 10</a>
                <a href="<?= base_url() ?>ranking/<?= $idCurso ?>?limit=20" class="btn btn-primary <?= ($limit == 20) ? "active" : ""; ?>">Top 20</a>
                <a href="<?= base_url() ?>ranking/<?= $idCurso ?>?limit=50" class="btn btn-primary <?= ($limit == 50) ? "active" : ""; ?>">Top 50</a>
                <a href="<?= base_url() ?>ranking/<?= $idCurso ?>?limit=100" class="btn btn-primary <?= ($limit == 100) ? "active" : ""; ?>">Top 100</a>
                <a href="<?= base_url() ?>ranking/<?= $idCurso ?>?limit=200" class="btn btn-primary <?= ($limit == 200) ? "active" : ""; ?>">Top 200</a>
                <a href="<?= base_url() ?>ranking/<?= $idCurso ?>?limit=500" class="btn btn-primary <?= ($limit == 500) ? "active" : ""; ?>">Top 500</a>
                <a href="<?= base_url() ?>ranking/<?= $idCurso ?>?limit=all" class="btn btn-primary <?= ($limit == "all") ? "active" : ""; ?>"> Todos</a>
                <br> <br>
            </div>
        </div>
    </div>
    <div id="contenedor-1-2" class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div >
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Puesto</th>
                                        <th>Nombre</th>
                                        <th>Puntaje</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr >
                                        <td><?= $posicion ?></td>
                                        <td><?= $nombre_completo ?></td>
                                        <td><?= $puntaje ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <hr>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Puesto</th>
                            <th>Avatar</th>
                            <th>Nombre</th>
                            <th>Puntaje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($posiciones as $row) {
                            if ($limit != "all" && $i > $limit) {
                                break;
                            }
                            ?>
                            <tr class="<?= ($row->id_usuario == $_SESSION["idUsuario"]) ? "info" : ""; ?>">
                                <td><?= $i++ ?></td>
                                <td><img class="img-responsive col-xs-8 col-sm-3 col-md-2  info-usuario cursor" data-id-curso="<?= $idCurso ?>" data-id-usuario="<?= $row->id_usuario ?>" src="<?= base_url()?>assets/img/avatares/thumbnails/<?= $row->imagen ?>"></td>
                                <td><?= $row->nombres . " " . $row->apellidos ?></td>
                                <td><?= $row->puntaje_total ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>






