
<div id="contenedor">
    <div id="contenedor-1-1" class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h1> Bienvenido a Ticademia</h1>
            </div>
        </div>
    </div>
    <div id="contenedor-1-2" class="container-fluid">
        <div class="row">
            <iframe class="col-sm-5" height="360" src="//www.youtube.com/embed/eW3gMGqcZQc" frameborder="0" allowfullscreen></iframe>
            <div class="col-sm-7">
                <?php foreach ($cursos as $row) { ?>
                    <div class="row">
                        <img class="img-responsive col-sm-5" src="<?= base_url() ?>material/<?= $row->id_curso ?>/<?= $row->id_curso ?>.png" alt="<?= $row->nombre ?>">
                        <div class="col-sm-7">
                            <h3><?= $row->nombre ?></h3>
                            <h4>Duración: <?= $row->duracion ?> semanas</h4>
                            <p><?= $row->descripcion ?></p>
                            <?php
                            if (isset($_SESSION["idUsuario"]) && $row->id_usuario != $_SESSION["idUsuario"]) {
                                if ($row->esta_matriculado) {
                                    ?>
                                    <a class="btn btn-info" href="<?= base_url() ?>curso/<?= $row->id_curso ?>">Entrar <span class="glyphicon glyphicon-chevron-right"></span></a>
                                <?php } else { ?>
                                    <a class="btn btn-info" href="<?= base_url() ?>curso/matricularse/<?= $row->id_curso ?>">Matricularse <span class="glyphicon glyphicon-chevron-right"></span></a>
                                    <?php
                                }
                            } else if (isset($_SESSION["idUsuario"]) && $row->id_usuario == $_SESSION["idUsuario"]) {
                                ?>
                                <a class="btn btn-info" href="<?= base_url() ?>curso/<?= $row->id_curso ?>">Entrar <span class="glyphicon glyphicon-chevron-right"></span></a>
                                <button title='Editar curso' class='btn btn-warning editarCurso' data-toggle='modal' data-target='#modalEditarCurso' data-id-curso="<?= $row->id_curso ?>"> <i class='fa fa-pencil-square-o'></i> Editar </button>
                                <button title='Eliminar curso' class='btn btn-danger eliminarCurso' data-toggle='modal' data-target='#modalEliminarCurso' data-id-curso="<?= $row->id_curso ?>"><i class='fa fa-trash-o'></i> Eliminar</button>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                <div class="row">
                    <div class="col-sm-12">
                    <hr>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
