<footer>
    <div id="contenedor-footer" class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <img id="escudo-un" class="pull-right" height="60" src="<?= base_url() ?>assets/img/logo_un.png"> 
                <ul class="list-unstyled list-inline social">
                    <li><a href="#" ><i class="fa fa-facebook"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<?php if ($this->session->flashdata('mensaje')) { ?>
    <div id="toast-container" class="toast-top-center">
        <div class="toast toast-<?= $this->session->flashdata('tipo') ?>">
            <div class="toast-message"><?= $this->session->flashdata('mensaje') ?></div>
        </div>
    </div>
<?php } ?>
<div id="coverDisplay">
    <img id="imgLoading" src="<?= base_url() ?>assets/img/loading.gif">
</div>
<div class="modal fade" id="modalLogro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= base_url() ?>logros/compartir" method="POST">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Logro obtenido</h4>
                </div>
                <div id="bodyModalLogro" class="modal-body">
                    <input id="idUsuarioCursoLogro" type="hidden" name="idUsuarioCursoLogro">
                    <div class="row">
                        <div class="col-xs-4">
                            <img id="img-logro" src="" class="col-xs-12">
                        </div>
                        <div class="col-xs-8">
                            <div class="row">
                                <div class="col-xs-12">
                                    <b>Nombre: </b><span id="nombre-logro">
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <b>Curso: </b><span id="nombre-asignatura">
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <b>Descripción:</b> <span id="descripcion-logro" >
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <b>Fecha:</b> <span id="fecha-logro"></span></b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="cerrar-modal-logros" type="button" class="btn btn-default pull-left btn-sm" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-primary pull-left  btn-sm" type="submit"> Compartir en el muro</button>
                    <a id="compartir-facebook" class="btn btn-primary btn-sm" href="javascript: void(0);" onclick="window.open(urlFacebook, 'ventanacompartir', 'toolbar=0, status=0, width=650, height=450');">Compartir en Facebook</a>
                    <a id="compartir-facebook" class="btn btn-primary btn-sm" href="javascript: void(0);" onclick="window.open(urlTwitter, 'ventanacompartir', 'toolbar=0, status=0, width=650, height=450');">Compartir en Twitter</a>
                </div>

            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modal-info-usuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Información del usuario</h4>
            </div>
            <div id="body-modal-info-usuario" class="modal-body">
            </div>
            <div class="modal-footer">
                <button id="cerrar-modal-logros" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="retado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Has sido retado</h4>
            </div>
            <div id="body-modal-retado" class="modal-body">
            </div>
            <div class="modal-footer">
                <button id="rechazar-modal-retado" type="button" class="btn btn-default" data-dismiss="modal">Rechazar</button>
                <button id="aceptar-modal-retado" type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="reto-rechazado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Reto rechazado</h4>
            </div>
            <div id="body-modal-retado" class="modal-body">
                <em id="nombre-usuario-reto-rechazado" class="text-info"></em> ha rechazado el reto.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="comenzar-reto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Has sido retado</h4>
            </div>
            <div id="body-modal-retado" class="modal-body">
                2+2=<input id="respuesta-reto"  type="text">
            </div>
            <div class="modal-footer">
                <button id="enviar-respuesta-reto" type="button" class="btn btn-primary" data-dismiss="modal">Enviar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ganador-reto-por-w" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Usuario desconectado</h4>
            </div>
            <div id="body-modal-retado" class="modal-body">
                <em id="nombre-usuario-desconectado" class="text-info"></em> se ha desconectado, por lo cual eres el ganador del reto.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-desconectado-antes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Duelo cancelado</h4>
            </div>
            <div id="body-modal-retado" class="modal-body">
                El usuario retador se ha desconectado.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="custom-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="custom-modal-title"></h4>
            </div>
            <div id="body-custom-modal" class="modal-body">
             
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>
<script>
    base_url = "<?= base_url() ?>";
    idUsuarioGlobal = -1;
    nombreUsuarioGlobal = "";
    idCursoGlobal = -1;
    fechaInicioReto = "";
<?php if (isset($_SESSION["idUsuario"]) && isset($idCurso)) {
    ?>
        idUsuarioGlobal = "<?= $_SESSION["idUsuario"] ?>";
        nombreUsuarioGlobal = "<?= $_SESSION["nombre"] ?>";
        idCursoGlobal = "<?= $idCurso ?>";
<?php }
?>


</script>
<script src="<?= base_url() ?>assets/libs/jQuery-1.11.0/jQuery.min.js"></script>
<script src="<?= base_url() ?>assets/libs/bootstrap-3.1.1/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/js/socket.js"></script>
<script src="<?= base_url() ?>assets/js/global.js"></script>
<?php if (isset($js)) foreach ($js as $row) { ?>
        <script src="<?= base_url() ?>assets/<?= $row ?>.js"></script>
    <?php } ?>

</body>
</html>