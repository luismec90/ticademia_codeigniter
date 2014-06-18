<div id="contenedor">
    <div id="contenedor-1-1" class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h1>Editar perfil</h1>

            </div>
        </div>
    </div>
    <div id="contenedor-1-2" class="container-fluid">
        <div class="row"> 
            <form role="form" action="<?= base_url() ?>perfil/actualizar" method="POST" class="formSubmit"  autocomplete="off"  enctype="multipart/form-data">
    

                <div class="col-xs-12  col-md-4   col-sm-5 ">

                    <img class="featurette-image img-responsive col-xs-12 " alt="500x500" src="<?= base_url() ?>assets/img/avatares/<?= $usuario[0]->imagen ?>">

                    <div class="col-xs-12">
                        <br>
                        <div class="input-group">
                            <input type="text" class="form-control" readonly="">
                            <span class="input-group-btn">
                                <span class="btn btn-primary btn-file">
                                    Cambiar imagen<input type="file" name="file" accept="image/*" >
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12  col-md-8 col-sm-7 ">
                    <h3>Datos personales</h3>
                    <hr>
                    <div class="form-group">
                        <input type="text" name="nombres"  class="form-control " placeholder="Nombres" tabindex="3" required="" value="<?= $usuario[0]->nombres ?>">
                    </div>
                     <div class="form-group">
                        <input type="text" name="apellidos"  class="form-control " placeholder="Apellidos" tabindex="3" required="" value="<?= $usuario[0]->apellidos ?>">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" id="display_name" class="form-control " placeholder="E-mail" tabindex="3" required value="<?= $usuario[0]->correo ?>">
                    </div>
                    <div class="form-group">
                        <select name="afiliacion" class="form-control "  required>
                            <option value="">Seleccionar universidad...</option>
                            <?php foreach ($afiliaciones as $row) { ?>
                                <option value="<?= $row->id_afiliacion ?>" <?= ($usuario[0]->id_afiliacion == $row->id_afiliacion) ? "selected" : "" ?>><?= $row->nombre ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <h3>Cambiar contraseña</h3>
                    <hr>
                    <div class="form-group">
                        <input type="password" name="currentPassword"  class="form-control " placeholder="Contraseña actual" tabindex="5" >
                    </div>
                    <div class="form-group">
                        <input type="password" name="password"  class="form-control " placeholder="Nueva contraseña" tabindex="5" >
                    </div>
                    <div class="form-group">
                        <input type="password" name="rePassword"  class="form-control " placeholder="Repetir contraseña" tabindex="5" >
                    </div>

                </div>
                <div class="col-xs-12 ">
                    <hr>
                    <input type="submit" value="Guardar cambios" class="btn btn-primary" tabindex="7">
                </div>
            </form>
        </div>
    </div>
</div>