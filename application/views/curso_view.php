<div id="contenedor-modulos">
    <div id="divAdminModulos">
        <!--<a href="<?= base_url() ?>" class="btn btn-info" title="Ir atrás"><i class="fa fa-reply"></i></a>-->
        <?php if ($_SESSION["rol"] == "profesor") { ?>
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalCrearModulo">
                <i class="fa fa-plus"></i>  Crear módulo
            </button>
        <?php } ?>
    </div>
    <div id="timeline-embed"></div>
    <script type="text/javascript">
        var dataObject = <?= $json ?>;
        var timeline_config = {
            width: "100%",
            height: "100%",
            //  source: "../assets/libs/time-line/example_json.json",
            source: dataObject,
            start_zoom_adjust: '2', //OPTIONAL TWEAK THE DEFAULT ZOOM LEVEL,
            lang: "es",
            start_at_slide: 0,
            embed_id: 'timeline-embed'
        }
    </script>

    <!-- END Timeline Embed-->
</div>
<?php if ($_SESSION["rol"] == "profesor") { ?>
    <div class="modal fade" id="modalCrearModulo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post"  class="formSubmit"  action="<?= base_url() ?>modulo/crearModulo" autocomplete="off">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Crear módulo</h4>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="curso" required="" readonly="" value="<?= $idCurso ?>">
                        <div class="control-group">
                            <label>Nombre:</label>
                            <div class="controls">
                                <input required="" id="nombre" name="nombre" type="text" class="form-control" placeholder="">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="control-group col-md-6">
                                <label>Fecha inicial:</label>
                                <div class="controls">
                                    <input required="" id="desde" name="desde" type="text" class="form-control datepicker" placeholder="">
                                </div>
                            </div>
                            <div class="control-group col-md-6">
                                <label>Fecha final:</label>
                                <div class="controls">
                                    <input required="" id="hasta" name="hasta" type="text" class="form-control datepicker" placeholder="">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="control-group">
                            <label>Descripción:</label>
                            <div class="controls">
                                <textarea required="" id="descripcion" rows="10" name="descripcion" class="form-control" placeholder=""></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEditarModulo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" class="formSubmit" action="<?= base_url() ?>modulo/editarModulo" autocomplete="off" >
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Editar módulo</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="curso" required="" readonly="" value="<?= $idCurso ?>">
                        <input type="hidden" id="editarIdModulo" name="idModulo" required="" readonly="">
                        <div class="control-group">
                            <label>Nombre:</label>
                            <div class="controls">
                                <input required="" id="editarNombreModulo" name="nombre" type="text" class="form-control" placeholder="">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="control-group col-md-6">
                                <label>Fecha inicial:</label>
                                <div class="controls">
                                    <input required="" id="editarDesdeModulo" id="desde" name="desde" type="text" class="form-control datepicker" placeholder="">
                                </div>
                            </div>
                            <div class="control-group col-md-6">
                                <label>Fecha final:</label>
                                <div class="controls">
                                    <input required="" id="editarHastaModulo" name="hasta" type="text" class="form-control datepicker" placeholder="">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="control-group">
                            <label>Descripción:</label>
                            <div class="controls">
                                <textarea required="" id="editarDescripcionModulo" rows="10" name="descripcion" class="form-control" placeholder=""></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEliminarModulo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" class="formSubmit" action="<?= base_url() ?>modulo/eliminarModulo" autocomplete="off" >
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Eliminar módulo</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="curso" required="" readonly="" value="<?= $idCurso ?>">
                        <input type="hidden" id="eliminarIdModulo" name="idModulo" required="" readonly="">
                        <h5>Realmente desea eliminar el módulo: <span id="eliminarNombreModulo" class="text-info"></span> ?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>