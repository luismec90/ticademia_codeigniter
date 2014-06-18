<div id="contenedor">
    <div id="contenedor-1-1" class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h1>  Foro  <small> <?= $nombre_curso ?></small> <a id="crearTema" class="btn btn-info"> Crear tema</a></h1>
            </div>
        </div>
    </div>
    <div id="contenedor-1-2" class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <table id="tabla-foro" class="table table-hover table-striped">
                    <thead>
                        <tr> 
                            <th>Título </th> 
                            <th>Respuestas </th> 
                            <th>Creado </th> 
                            <th>Última respuesta</th> 
                        </tr> </thead> <tbody>
                        <?php foreach ($temas as $item): ?>
                            <tr >
                                <td class="title">
                                    <div class="name"><a href="<?= base_url() ?>foro/<?= $idCurso ?>/<?= $item->id_tema_foro ?>"><?= $item->nombre ?></a>
                                    </div>
                                    <div class="description"><?= $item->descripcion ?>
                                    </div>

                                </td>


                                <td class="replies"> <?= $item->cantidad_respuestas ?>
                                </td>


                                <td class="created">
                                    Por <span class="text-info"> <?= $item->nombres." ".$item->apellidos ?></span> 
                                    <br>A las <?= $item->fecha_creacion ?>
                                </td>


                                <td class="last-reply">
                                    <?php if ($idUsuario == $item->id_usuario): ?> 
                                        <button type="button" class="close" data-id-tema="<?= $item->id_tema_foro ?>"><i class="fa fa-trash-o"></i></button>
                                    <?php endif; ?>
                                    <?= $item->ultima_respuesta ?> 
                                    <?php if ($item->cantidad_respuestas > 0) : ?>
                                        <br> Por <span class="text-info"> <?= $item->usuario_ultima_respuesta ?></span> 
                                        <br> A las  <?= $item->fecha_ultimo_comentario ?>
                                    <?php else: ?>
                                        n/a
                                    <?php endif; ?>

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
                        ?>"><a href="<?= base_url() . "foro/" . $idCurso ?>">1</a></li>
                            <?php for ($i = 2; $i <= $cantidadPaginas; $i++) { ?>
                            <li class="<?php
                            if ($paginaActiva == $i)
                                echo "active";
                            else
                                echo "noActive";
                            ?>"><a href="<?= base_url() . "foro/" . $idCurso ?>?page=<?= $i ?>"><?= $i ?></a></li>
                            <?php } ?>
                    </ul> 
                </div>
            </div> 
        </div> 
    </div> 
</div> 
<!-- Modal Crear Tema -->
<div id="modalCrearTema" class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Crear tema</h4>
            </div>
            <form class="form-horizontal formSubmit" action="<?= base_url() ?>foro/crearTema/<?= $idCurso ?>" method="POST">
                <div class="modal-body">

                    <fieldset>
                        <!-- Sign In Form -->
                        <!-- Text input-->
                        <div class="control-group">
                            <label>Nombre:</label>
                            <div class="controls">
                                <input required="" id="nombreTema" name="nombre" type="text" class="form-control" placeholder="">
                            </div>
                        </div>

                        <!-- Password input-->
                        <div class="control-group">
                            <label>Descripción:</label>
                            <div class="controls">
                                <textarea required="" id="descripcion" rows="10" name="descripcion" class="form-control" placeholder=""></textarea>
                            </div>
                        </div>
                    </fieldset>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-info">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modalEliminarTema" class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Eliminar tema</h4>
            </div>
            <form class="form-horizontal formSubmit" action="<?= base_url() ?>foro/eliminarTema/<?= $idCurso ?>" method="POST">
                <div class="modal-body">
                    <input id="idTemaEliminar" type="hidden" name="idTema" value="">
                    <h5> ¿Realmente desea eliminar este tema?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-info">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>