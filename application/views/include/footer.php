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
                    <li>Soporte técnico: luismec90@gmail.com </li>

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
<div class="modal fade" id="retado" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Duelo</h4>
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
                <h4 class="modal-title" id="myModalLabel">Duelo</h4>
            </div>
            <div id="body-modal-retado" class="modal-body">
                Los posibles oponentes no estan disponibles, vuelve a intentarlo
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
<div class="modal fade" data-keyboard="false" data-backdrop="static"  id="modal-arena" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
<div id="modal-step-1" data-keyboard="false" data-backdrop="static" class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Duelo </h4>
            </div>
            <div class="modal-body">
                <div id="marco-step-1" >
                    <div class="text-info text-center">Seleccionando oponente... <br><br></div>
                    <center><div class="arrow-down"></div></center>
                    <div id="slideshow">
                    </div>
                </div>
                <div id="marco-step-2" class="hide">
                    <div class="text-info text-center">Seleccionando módulo... <br><br></div>
                    <center><div class="arrow-down"></div></center>
                    <img class='img-circle' id='pie-step-2' width="200" src="<?= base_url() ?>assets/img/pie.png" alt="" />
                    <br> <br>
                    <img width="400" src="<?= base_url() ?>assets/img/pie-labels.png" alt="" />
                </div>
                <div id="marco-step-3" class="hide">
                    <div class="text-info text-center">Seleccionando pregunta... <br><br></div>
                    <center><div class="arrow-down"></div></center>
                    <div id="slideshow-evaluaciones">

                    </div>
                </div>
                <div id="marco-step-4" class="hide">
                    <div class="text-info text-center">Seleccionando monto... <br><br></div>
                    <img id="imagen-dado" width="100" src="<?= base_url() ?>assets/img/dados/1.jpg" data-base-url="<?= base_url() ?>">
                    <img id="imagen-dado2" width="100" src="<?= base_url() ?>assets/img/dados/1.jpg" data-base-url="<?= base_url() ?>">
                </div>
                <div class="panel-duelo" >
                    <div >
                        <div class="text-center texto"><b>Oponente</b></div>
                        <div id="info-oponente-before" >
                            <img  class='img-circle' src="<?= base_url() ?>assets/img/question-mark.png" alt="" />
                        </div>
                        <div id="info-oponente" class="hide">
                            <div>
                                <img id="imagen-oponente" class='img-circle' src="" alt="" />
                            </div>
                            <div id="nombre-oponente" class="texto">

                            </div>
                        </div>
                        <hr>
                    </div>
                    <div >
                        <div class="text-center texto"><b>Módulo</b></div>
                        <div id="info-modulo-before" >
                            <img  class='img-circle' src="<?= base_url() ?>assets/img/question-mark.png" alt="" />
                        </div>
                        <div id="info-modulo" class="hide">
                            <div>
                                <h3 id="modulo-seleccionado"></h3>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div >
                        <div class="text-center texto"><b>Pregunta</b></div>
                        <div id="info-pregunta-before" >
                            <img class='img-circle' src="<?= base_url() ?>assets/img/question-mark.png" alt="" />
                        </div>
                        <div id="info-pregunta" class="hide">
                            <div>
                                <h3 id="pregunta-seleccionada"></h3>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div >
                        <div class="text-center texto"><b>Monto</b></div>
                        <div id="info-monto-before" >
                            <img  class='img-circle' src="<?= base_url() ?>assets/img/question-mark.png" alt="" />
                        </div>
                        <div id="info-monto" class="hide">
                            <div>
                                <h3 id="monto-pregunta">7</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal-vs" class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Duelo </h4>
            </div>
            <div class="modal-body">
                <div >
                    <img id="foto-retador" width="70" class='img-circle rotarY' src="<?= base_url() ?>assets/img/avatares/1.jpg" alt="" />
                    <img id="avatar-retador" width="100" class='img-circle rotar180' src="<?= base_url() ?>assets/img/niveles/hombre/3.png" alt="" />
                </div>
                <div id="div-vs" >
                    <center><img width="100" src="<?= base_url() ?>assets/img/vs.png"> en <span id="duelo-cuenta-regresiva">3</span></center>
                </div>
                <div >
                    <img id="foto-retado" width="70" class='img-circle rotarY' src="<?= base_url() ?>assets/img/avatares/default.png" alt="" />
                    <img id="avatar-retado" width="100" class='img-circle' src="<?= base_url() ?>assets/img/niveles/hombre/2.png" alt="" />
                </div>
            </div>
        </div>
    </div>
</div>
<audio id="notify-sound" class="hide">
    <source src="<?= base_url() ?>assets/sound/notify.mp3"></source>
    Update your browser to enjoy HTML5 audio!
</audio>
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
<script src="<?= base_url() ?>assets/js/socketv0.1.js"></script>
<script src="<?= base_url() ?>assets/js/global.js"></script>
<script src="<?= base_url() ?>assets/js/duelo.js"></script>
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