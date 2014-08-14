<div id="contenedor" class='container-fluid'>
    <br>
    <div class='row'>
        <div class='col-xs-12'>

        </div>
    </div>

</div>

<div id="modal-step-1" class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                        <div ><img width="100" class='img-circle' src="<?= base_url() ?>assets/img/avatares/default.png" alt="" /></div>
                        <div ><img width="100" class='img-circle' src="<?= base_url() ?>assets/img/avatares/default.png" alt="" /></div>
                        <div ><img width="100" class='img-circle' src="<?= base_url() ?>assets/img/avatares/default.png" alt="" /></div>
                        <div ><img width="100" class='img-circle' src="<?= base_url() ?>assets/img/avatares/1.jpg" alt="" /></div>
                        <div ><img width="100" class='img-circle' src="<?= base_url() ?>assets/img/avatares/default.png" alt="" /></div>
                        <div ><img width="100" class='img-circle' src="<?= base_url() ?>assets/img/avatares/default.png" alt="" /></div>
                    </div>
                </div>
                <div id="marco-step-2" class="hide">
                    <div class="text-info text-center">Seleccionando módulo... <br><br></div>
                    <center><div class="arrow-down"></div></center>
                    <img class='img-circle' id='pie-step-2' src="<?= base_url() ?>assets/img/pie.png" alt="" />
                </div>
                <div id="marco-step-3" class="hide">
                    <div class="text-info text-center">Seleccionando pregunta... <br><br></div>
                    <center><div class="arrow-down"></div></center>
                    <div id="slideshow-evaluaciones">
                        <div ><img width="100"  src="http://placehold.it/100x100/35bdf6/ffffff&text=1" alt="" /></div>
                        <div ><img width="100"  src="http://placehold.it/100x100/35bdf6/ffffff&text=2" alt="" /></div>
                        <div ><img width="100"  src="http://placehold.it/100x100/35bdf6/ffffff&text=3" alt="" /></div>
                        <div ><img width="100"  src="http://placehold.it/100x100/35bdf6/ffffff&text=4" alt="" /></div>
                        <div ><img width="100"  src="http://placehold.it/100x100/35bdf6/ffffff&text=5" alt="" /></div>
                        <div ><img width="100"  src="http://placehold.it/100x100/35bdf6/ffffff&text=6" alt="" /></div>
                        <div ><img width="100"  src="http://placehold.it/100x100/35bdf6/ffffff&text=7" alt="" /></div>
                        <div ><img width="100"  src="http://placehold.it/100x100/35bdf6/ffffff&text=8" alt="" /></div>
                        <div ><img width="100"  src="http://placehold.it/100x100/35bdf6/ffffff&text=9" alt="" /></div>
                        <div ><img width="100"  src="http://placehold.it/100x100/35bdf6/ffffff&text=10" alt="" /></div>
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
                                <img  class='img-circle' src="<?= base_url() ?>assets/img/avatares/thumbnails/1.jpg" alt="" />
                            </div>
                            <div class="texto">
                                Luis Fernando Montoya
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
                                <h3>2</h3>
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
                                <h3>3</h3>
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
                                <h3>7</h3>
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
                    <center><h2>VS en <span id="duelo-cuenta-regresiva">3</span></h2></center>
                </div>
                <div >
                    <img id="foto-retado" width="70" class='img-circle rotarY' src="<?= base_url() ?>assets/img/avatares/default.png" alt="" />
                    <img id="avatar-retado" width="100" class='img-circle' src="<?= base_url() ?>assets/img/niveles/hombre/2.png" alt="" />
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var jsonDuelo = JSON.stringify(<?= $jsonDuelo ?>);
    console.log(jsonDuelo);
</script>