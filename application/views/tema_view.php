<div id="contenedor">
    <div id="contenedor-1-1" class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h1> <a href="<?= base_url() ?>foro/<?= $idCurso ?>" class="btn btn-info" title="Ir atrás"><i class="fa fa-reply"></i></a>  <?= $tema[0]->nombre ?>   </h1>
            </div>
        </div>
    </div>
    <div id="contenedor-1-2" class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <table id="tabla-tema" class="table">
                    <tr  id="tema">
                        <td class="col-md-2">
                            <span class="text-info"> <?= $tema[0]->nombres." ".$tema[0]->apellidos ?></span><br>
                            <?= $tema[0]->fecha_creacion ?>
                        </td>


                        <td class="descripcion"> <?= $tema[0]->descripcion ?>
                        </td>

                    </tr>
                    <tr>


                        <td colspan="2">
                            <form class="formSubmit" method="POST" action="<?= base_url() ?>foro/responder/<?= $idCurso ?>/<?= $tema[0]->id_tema_foro ?>">
                                <textarea class="form-control" name="respuesta" rows="3" required></textarea>
                                <br>
                                <input type="submit" class="btn btn-info btn-sm" value="Participar">                    
                            </form>
                        </td>
                    </tr>
                    <?php foreach ($respuestas as $item): ?>
                        <tr >
                            <td class="who">
                                <span class="text-info">  <?= $item->nombres." ".$item->apellidos ?></span><br>
                                <?= $item->fecha_creacion ?>
                            </td>


                            <td class="replies">
                                <?php if ($idUsuario == $item->id_usuario): ?> 
                                    <button type="button" class="close" data-id-respuesta="<?= $item->id_respuesta ?>"><i class="fa fa-trash-o"></i></button>
                                <?php endif; ?>
                                <?= $item->respuesta ?>
                            </td>

                        </tr>
                    <?php endforeach; ?>

                    </tbody>


                </table> 
                <div class="row-fluid">
                    <ul id="paginacion" class="pagination pull-right">
                        <li class="<?php
                        if ($paginaActiva == 1)
                            echo "active";
                        else
                            echo "noActive";
                        ?>"><a href="<?= base_url() . "foro/" . $idCurso . "/" . $idTema ?>">1</a></li>
                            <?php for ($i = 2; $i <= $cantidadPaginas; $i++) { ?>
                            <li class="<?php
                            if ($paginaActiva == $i)
                                echo "active";
                            else
                                echo "noActive";
                            ?>"><a href="<?= base_url() . "foro/" . $idCurso . "/" . $idTema ?>?page=<?= $i ?>"><?= $i ?></a></li>
                            <?php } ?>
                    </ul> 
                </div>
            </div> 
        </div> 
    </div> 
</div> 


<div id="modalEliminarRespuesta" class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Eliminar respuesta</h4>
            </div>
            <form class="form-horizontal formSubmit" action="<?= base_url() ?>foro/eliminarRespuesta/<?= $idCurso ?>/<?= $tema[0]->id_tema_foro ?>" method="POST">
                <div class="modal-body">
                    <input id="idRespuestaEliminar" type="hidden" name="idRespuesta" value="">
                    <h5> ¿Realmente desea eliminar esta respuesta?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-info">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>