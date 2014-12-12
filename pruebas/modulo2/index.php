<!DOCTYPE html>

<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Módulo</title>

    <!-- Bootstrap -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="modulo.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div id="modulo-contenedor" class="container">

    <div id="marco-materiales">
        <div id="subir-control-materiales"></div>
        <div id="fondo-materiales">
            <div id="contenedor-materiales" data-scroll="0">
                <?php for ($i = 1; $i < 20; $i ++)
                {
                    ?>
                    <div class="material">
                        <?php if ($i % 3 == 0)
                        {
                            ?>
                            <img class="icono-video" src="img_materiales/video.png">
                        <?php
                        } else
                        {
                            ?>
                            <img class="icono-libro" src="img_materiales/libro.png">
                        <?php } ?>
                        <label class="color-texto-roca">Material <?= $i ?></label>
                        <span class="div-starts">
                            <img class="star" src="img_materiales/star.png">
                            <img class="star" src="img_materiales/star.png">
                            <img class="star" src="img_materiales/star.png">
                            <img class="star" src="img_materiales/star.png">
                            <img class="star" src="img_materiales/star.png">
                        </span>
                        <span class="div-rating">(<?= rand(20, 30) ?>)</span>
                        <?php if ($i % 3 == 0)
                        {
                            ?>
                            <span class="div-duration"><?= rand(5, 15) ?> m</span>
                        <?php } ?>
                        <?php if ($i < 12)
                        {
                            ?>
                            <img class="icono-check" src="img_materiales/check.png">
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div id="bajar-control-materiales"></div>
    </div>

    <div id="marco-evaluaciones">
        <div id="subir-control-evaluaciones"></div>
        <div id="fondo-evaluaciones">
            <div id="contenedor-evaluaciones" data-scroll="0">
                <div class="evaluacion-row">
                    <?php for ($i = 1;
                    $i < 20;
                    $i ++)
                    {
                    ?>
                    <div class="evaluacion">
                        <div class="numero-evaluacion">
                            <?= $i ?>
                        </div>
                        <img class="evaluacion-star" src="img_materiales/star.png">
                        <span class="mejor-tiempo"><?= $i ?></span>
                        <img class="tipo-evaluacion" src="img_evaluaciones/tipo-evaluacion.png">
                        <span class="mejor-puntaje"><?= $i*15 ?></span>
                        <img class="reloj" src="img_evaluaciones/reloj.png">
                        <span class="intentos">1/4</span>
                        <img class="marco-persona" src="img_evaluaciones/marco-persona.png">
                        <?php if($i<5) {?>
                        <img class="check" src="img_evaluaciones/check.png">
                        <?php }else{ ?>
                            <img class="candado" src="img_evaluaciones/candado.png">
                        <?php }?>
                    </div>
                    <?php
                    if ($i % 3 == 0)
                    {
                    ?>
                </div>
                <div class="evaluacion-row">
                    <?php
                    }
                    } ?>
                </div>
            </div>
        </div>
    <div id="bajar-control-evaluaciones"></div>
    </div>

<label id="nombre-modulo">Ecucaciones y desigualdades</label>
<img id="left-door" src="left-door.png">
<img id="right-door" src="right-door.png">
</div>

<div id="controles">
    <div>
        <input id="input-mover-puertas" type="number" value="50">%
        <button id="btn-mover-puertas">Mover puertas</button>
    </div>
</div>
<audio id="doors-audio">
    <source src="doors.mp3"></source>
</audio>
<audio id="wall-audio">
    <source src="wall.mp3"></source>
</audio>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<script src="modulo.js"></script>
</body>
</html>