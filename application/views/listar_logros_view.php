<div id="contenedor">
    <div id="contenedor-1-1" class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h1><a href="<?= base_url()?>curso/<?= $idCurso?>" class="btn btn-info" title="Ir al primer módulo"><i class="fa fa-reply"></i></a> Logros   <small> <?= $nombre_curso ?></small></h1>

            </div>
        </div>
    </div>
    <div id="contenedor-1-2" class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Logro</th>
                            <th>Descripcion</th>
                            <th>Fecha</th>
                            <th>Ver</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($logros as $row) { ?>
                            <tr>
                                <td><?= $row->nombre ?></td>
                                <td><?= $row->descripcion ?></td>
                                <td><?= $row->fecha_obtencion ?></td>
                                <td><a class="btn btn-primary" href="<?= base_url() . "logros/$idCurso/" . $row->id_usuario_curso_logro ?>">Ver</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>








