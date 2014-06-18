
<div id="contenedor">
    <div id="contenedor-1-1" class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h2>Registro</h2>

            </div>
        </div>
    </div>
    <div id="contenedor-1-2" class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                <form role="form" class="formSubmit" action="<?= base_url() ?>registrarse/crear" method="POST" autocomplete="off">


                    <div class="form-group">
                        <input type="text" name="nombres"  class="form-control input-lg" placeholder="Nombres" tabindex="3" required="">
                    </div>
                    <div class="form-group">
                        <input type="text" name="apellidos"  class="form-control input-lg" placeholder="Apellidos" tabindex="3" required="">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" id="display_name" class="form-control input-lg" placeholder="E-mail" tabindex="3" required>
                    </div>
                    <div class="form-group">
                        <select name="afiliacion" class="form-control input-lg"  required>
                            <option value="">Seleccionar universidad...</option>
                            <?php foreach ($afiliaciones as $row) { ?>
                                <option value="<?= $row->id_afiliacion ?>"><?= $row->nombre ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="usuario" name="usuario" id="email" class="form-control input-lg" placeholder="Usuario" tabindex="4" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password"  class="form-control input-lg" placeholder="Contraseña" tabindex="5" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="rePassword"  class="form-control input-lg" placeholder="Repetir contraseña" tabindex="5" required>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 col-sm-9 col-md-9">
                            Al dar click en <strong class="label label-primary">Registrarse</strong> , usted esta aceptado los <a href="#" data-toggle="modal" data-target="#t_and_c_m">términos y condiciones</a>.
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-xs-12 col-md-6"><input type="submit" value="Registrarse" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="t_and_c_m" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Términos y condiciones</h4>
            </div>
            <div class="modal-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>