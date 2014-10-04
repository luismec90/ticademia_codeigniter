<div id="contenedor">
    <div id="contenedor-1-1" class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h1>Reporte <small> <?= $nombre_curso ?></small></h1> </h1>
            </div>
        </div>
        <div id="contenedor-1-2" class="container-fluid">
            <form method="post" action="<?= base_url() ?>reporte/excel" autocomplete="off" >
                 <hr>
                <div class="row" >
                     <input name="idCurso" type="hidden" value="<?= $idCurso ?>">
                    <div class="col-sm-2 col-sm-offset-4">
                        <select  name="modulo" class="form-control" required>
                            <option value="">Seleccionar Módulo...</option>
                            <?php foreach ($modulos as $modulo) { ?>
                                <option value="<?= $modulo->id_modulo ?>"><?= $modulo->nombre ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <button class="btn btn-primary">Exportar a excel</button>
                       
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>





