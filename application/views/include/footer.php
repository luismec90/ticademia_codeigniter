<?php if (isset($idCurso)) { ?>
    <div id="marco-inferior">
    </div>
<?php } ?>
<footer>
    <div id="contenedor-footer" class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <img id="escudo-un" class="pull-right" height="60" src="<?= base_url() ?>assets/img/logo_un.png"> 
                <ul class="list-unstyled list-inline social">
                    <li><a href="https://www.facebook.com/groups/ticademia/" target="_blank"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="https://twitter.com/grupoGUIAME" target="_blank" ><i class="fa fa-twitter"></i></a></li>
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
                <span id="content-modal-retado"></span> 
            </div>
            <div class="modal-footer">
                <span id="cuenta-regresiva-retado" class="pull-left"></span>
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
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button id="arena2" type="button" class="btn btn-primary" data-dismiss="modal">Reintentar</button>
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
<div class="modal fade" id="modal-arena" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="">Arena</h4>
            </div>
            <div id="" class="modal-body">
                <center>  Buscando oponente <span id="cuenta-regresiva"></span> </center>
                <center><br>
                    <img id="" src="<?= base_url() ?>assets/img/loading.gif">
                </center>
            </div>
            <!--            <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                        </div>-->
        </div>
    </div>
</div>
<div id="contenedor-frame" class="hide">
    <div id="botonCerrarFrame">
        <i class="fa fa-times fa-2x"></i> 
    </div>
    <iframe width="100%" id="frame" src="" height="90%"></iframe>
    <script src="<?= base_url() ?>assets/libs/jQuery-1.11.0/jQuery.min.js"></script>
    <script src="<?= base_url() ?>assets/js/api.js"></script>
</div>
<script>
                        base_url = "<?= base_url() ?>";
                        idUsuarioGlobal = -1;
                        nombreUsuarioGlobal = "";
                        idCursoGlobal = -1;
                        fechaInicioReto = "";
                        evaluacionOReto = "";
<?php if (isset($_SESSION["idUsuario"]) && isset($idCurso)) {
    ?>                      rolGlobal = "<?= $_SESSION["rol"] ?>";
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


<?php if ($tab == "curso") { ?>
    <script>
                            $(function() {
                                countCallsCargarModulo = 0;
                                var numeroModulos = <?= $numeroModulos ?>;
                                var idModulos = jQuery.parseJSON('<?= $idModulos ?>');
                                $("#slider").slider({min: 0, max: <?= $cantidadModulos - 1 ?>, value: 0, animate: "normal"});
                                $("#slider").slider("pips", {rest: "label", labels: numeroModulos})
                                $("#slider").on("slidechange", function(e, ui) {

                                    var idModulo = idModulos[ui.value];

                                    cargarModulo(idModulo);

                                });

                                cargarModulo(-1);
                            });



    </script>
<?php } ?>
<script>
    /* Google Analytics*/
    (function(i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function() {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-42717766-4', 'auto');
    ga('send', 'pageview');
</script>
</body>
</html>