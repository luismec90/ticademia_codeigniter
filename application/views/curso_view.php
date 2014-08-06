<div id="contenedor">

    <div id="linea">
        <div id="slider">

        </div>
    </div>
    <div id="contenido" data-id-modulo="<?= $moduloActual ?>">

    </div>
</div>
<div id="contenedor-video" class="hide">
    <div id="botonCerrarVideo" title="Cerrar">
        <i class="fa fa-times fa-2x"></i> 
    </div>
    <video id="video" width="900" height="510" src="#test.mp4" ></video>
</div>
<div id="contenedor-pdf" class="hide">
    <div id="botonCerrarPdf"  title="Cerrar">
        <i class="fa fa-times fa-2x"></i> 
    </div>
    <embed id="pdf" src="">
</div>

<div id="custom-popover" class="popover fade top in">
    <div class="arrow"></div><h3 class="popover-title"><div id="popover-titulo" ></div><button id="cerrar-popover" type="button" class="close">&times;</button> </h3>
    <div id="popover-contenido" class="popover-content">bla bla <br> bla bla<br>bla bla
    </div>
</div>


<div class="modal fade" id="modalValoracionMaterial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="formSubmit" action="<?= base_url() ?>material/valorarMaterial" autocomplete="off" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Valorar material <div id="preview-stars"></div></h4>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="idMaterial" name="idMaterial" required="" readonly="" >
                    <textarea rows="5" id="comentario" class="form-control" name="comentario" placeholder="Comentario"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="modalVerValoracionesMaterial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Comentarios del material <div id="preview-stars"></div></h4>
            </div>

            <div id="modal-body-ver-valoraciones" class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalRespuestaEvaluacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Retroalimentación<div id="preview-stars"></div></h4>
            </div>

            <div id="bodymodalRespuestaEvaluacion" class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEstadisticasMaterial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Estadísticas<div id="preview-stars"></div></h4>
            </div>

            <div id="bodymodalEstadisticasMaterial" class="modal-body">
                <div id="modal-estadistica1"></div>
                <div id="modal-estadistica2"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEstadisticasEvaluacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Estadísticas<div id="preview-stars"></div></h4>
            </div>

            <div class="modal-body">
                <div id="modal-estadistica-evaluacion1"></div>
                <div id="modal-estadistica-evaluacion2"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalSaltarEvaluacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Saltar evaluación</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="idCursoEvaluacionSaltar" name="idCurso" value="<?= $idCurso ?>" required="" readonly="">
                    <input type="hidden" id="idEvaluacionSaltar" name="idEvaluacion" required="" readonly="">
                    <h5>¿Deseas saltar esta pregunta? ten en cuenta que luego la podrás realizar pero ya no recibirás puntuación</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="confirmarSaltarEvaluacion"  class="btn btn-primary">Enviar</button>
                </div>
           
        </div>
    </div>
</div>
