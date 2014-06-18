<div id="contenedor">
    <div id="contenedor-1-1" class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h1> Muro   <small> <?= $nombre_curso ?></small></h1>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <form action="<?= base_url() ?>muro/crear" method="POST" class="formSubmit">
                <input name="idCurso" type="hidden" value="<?= $idCurso ?>">
                <div class="col-xs-12">
                    <br>
                    <textarea name="mensaje" placeholder="¿Que piensas?" rows="3" name="publicacion" class="form-control   " required=""></textarea>
                </div>
                <div class="col-xs-12">
                    <br>
                    <button class="btn btn-primary pull-right">Publicar</button>
                </div>
            </form>
        </div>

        <?php foreach ($mensajes as $row) { ?>
            <div class="row">
                <div class="col-xs-12">
                    <hr>
                </div>
            </div>
            <div class="row">
                <img class="img-responsive col-xs-3 col-sm-3 col-md-2 col-lg-1 info-usuario cursor" data-id-usuario="<?= $row->id_usuario ?>" data-id-curso="<?= $idCurso ?>" src="<?= base_url() ?>assets/img/avatares/thumbnails/<?= $row->imagen ?>">
                <div  class="col-xs-9 col-sm-9 col-md-10 col-lg-11">
                    <div class="row">
                        <div  class="col-xs-12">
                            <small><?= $row->nombres . " " . $row->apellidos ?> </small>  <small class="text-muted text-right"><?= $row->fecha_creacion ?></small>
                        </div>
                    </div>
                    <div>
                        <pre class="primer-pre"><?php if ($row->id_usuario == $_SESSION["idUsuario"]) { ?><a class="eliminar glyphicon glyphicon-remove pull-right" data-id-mensaje="<?= $row->id_muro ?>"></a><?php } ?><?= $row->mensaje ?> </pre>
                    </div>
                    <div class="row div-comentar">
                        <div class="col-xs-12">
                            <a class="comentar" ><i class="glyphicon glyphicon-comment"></i> <small>Comentar</small></a>
                        </div>
                    </div>
                    <?php foreach ($reply[$row->id_muro] as $row2) { ?>
                        <div class="row">
                            <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1">
                                <img class="img-responsive col-xs-12 info-usuario cursor" data-id-usuario="<?= $row2->id_usuario ?>" data-id-curso="<?= $idCurso ?>" src="<?= base_url() ?>assets/img/avatares/thumbnails/<?= $row2->imagen ?>">
                            </div>
                            <div  class="col-xs-8 col-sm-9 col-md-10 col-lg-11">
                                <div class="row">
                                    <div  class="col-xs-12">
                                        <small><?= $row2->nombres . " " . $row2->apellidos ?> </small>  <small class="text-muted text-right"><?= $row2->fecha_creacion ?></small> 
                                    </div>
                                </div>
                                <div>
                                    <pre><?php if ($row2->id_usuario == $_SESSION["idUsuario"]) { ?><a class="eliminar glyphicon glyphicon-remove pull-right" data-id-mensaje="<?= $row2->id_muro ?>"></a> <?php } ?><?= $row2->mensaje ?></pre>
                                </div>
                            </div>

                        </div>
                    <?php } ?>
                    <div class="row ocultar">
                        <div class="col-xs-12">
                            <form action="<?= base_url() ?>muro/responder" method="POST" class="row formSubmit">
                                <input name="idCurso" type="hidden" value="<?= $idCurso ?>">
                                <input name="idMensaje" type="hidden" value="<?= $row->id_muro ?>">
                                <div class="col-xs-8 col-sm-9 col-md-10 col-lg-11">
                                    <textarea name="mensaje" rows="1" name="responder" class="form-control responder" required=""></textarea>  
                                </div>
                                <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1">
                                    <button class="btn btn-primary btn-sm pull-right">Responder</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-xs-12">
                <hr>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-eliminar-mensaje" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url() ?>muro/eliminar" method="POST" class="formSubmit">
                <input name="idCurso" type="hidden" value="<?= $idCurso ?>">
                <input id="id-mensaje-eliminar" name="idMensaje" type="hidden" value="<?= $row->id_muro ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Eliminar mensaje</h4>
                </div>
                <div class="modal-body">
                    ¿Realmente desea eliminar este mensaje?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>