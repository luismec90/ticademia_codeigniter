<div id="contenedor">
    <div id="contenedor-1-1" class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h1> Logro:  <?= $logro[0]->nombre ?>  </h1>
            </div>
        </div>
    </div>
    <div id="contenedor-1-2" class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-4">

                <img  src="<?= base_url() ?>assets/img/avatares/<?= $usuario[0]->imagen ?>" class="col-xs-12">
            </div>
            <div class="col-xs-12  col-sm-4">
                <div class="row">
                    <div class="col-xs-12">
                        <h3 class="no-margin-top">  <?= $usuario[0]->nombres." ".$usuario[0]->apellidos ?></h3>
                    </div>
                    <div class="col-xs-12">
                        <h4>  Ha obtenido el logro: <?= $logro[0]->nombre ?></h4>
                    </div>
                   <div class="col-xs-12">
                        <h4>  En el curso: <?= $logro[0]->nombre_asignatura ?></h4>
                    </div>
                    <div class="col-xs-12">
                        <h4> Fecha: <?= $logro[0]->fecha_obtencion ?></h4>
                    </div>
                </div>

            </div>
            <div class="col-xs-12  col-sm-4">
                <div class="col-sm-12">
                    <h3 class="no-margin-top text-center"> <?= $logro[0]->nombre ?></h3>
                </div>
                <img  src="<?= $logro[0]->imagen ?>" class="col-xs-12">
                <div class="col-sm-12 text-center">
                    <h4>  <?= $logro[0]->descripcion ?></h4>
                </div>
            </div>
        </div>
    </div>
</div>