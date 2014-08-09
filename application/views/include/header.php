<!DOCTYPE html>
<html lang="es">
    <head>
        <?php if (isset($logro)) { ?>
            <meta property="og:title" content="<?= $logro[0]->nombre ?>" />
            <meta property="og:description" content="<?= $logro[0]->descripcion ?>" />
            <meta property="og:url" content="<?= base_url() ?>logros/<?= $idCurso . "/" . $idLogroUsuario ?>" />
            <meta property="og:image" content="<?= $logro[0]->imagen ?>" />
            <meta property="og:image:type" content="image/png" />
        <?php } ?>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link href="<?= base_url() ?>assets/img/favicon.png" rel="icon" type="image/x-icon" />


        <title>Ticademia</title>

        <!-- Bootstrap core CSS -->
        <link href="<?= base_url() ?>assets/libs/bootstrap-3.1.1/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?= base_url() ?>assets/libs/font-awesome-4.0.3/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/global.css">
        <?php if (isset($css)) foreach ($css as $row) { ?>
                <link rel="stylesheet" href="<?= base_url() ?>assets/<?= $row ?>.css">
            <?php } ?>
        <!-- Just for debugging purposes. Don't actually copy this line! -->
        <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>

    </head>

    <body>

        <!-- Static navbar -->
        <div id="menu" class="navbar navbar-default navbar-static-top " role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="<?= base_url() ?>" title="Ir al inicio"> <img id="logo"  height="47" src="<?= base_url() ?>assets/img/ticademia.png"></a>
                    <!--<a id="texto-logo" class="navbar-brand white" href="<?= base_url() ?>">TICADEMIA</a>-->
                </div>
                <div class="navbar-collapse collapse">
                    <!--                    <ul class="nav navbar-nav">
                                            <li class="<?= ($tab == "inicio") ? "active" : "" ?>"><a href="<?= base_url() ?>" class="white"><i class="fa fa-list-ul fa-lg"></i> Ver cursos</a></li>
                                        </ul>-->
                    <ul id="nav-menu" class="nav navbar-nav navbar-right">
                        <?php if (isset($_SESSION["nombre"])) { ?>
                            <?php if (isset($idCurso)) { ?>
                                <li class="icono"><a id="asesorias" title="Asesorias" class=""><img src="<?= base_url() ?>assets/img/temas/default/asesoria.png" height="37"></a></li>
                                <?php if ($_SESSION["rol"] == 1) { ?>
                                    <li class="icono"><a id="arena" title="Duelos" class=""><img src="<?= base_url() ?>assets/img/temas/default/duelo.png" height="37"></a></li>
                                <?php } else if ($_SESSION["rol"] == 2) { ?>
                                    <li class="icono dropdown <?= ($tab == "estadisticaestudiantes" || $tab == "estadisticamateriales" || $tab == "estadisticapreguntas" ) ? "active" : ""; ?> icono">
                                        <a href="#" title="Estadísticas" class="dropdown-toggle" data-toggle="dropdown"> <img src="<?= base_url() ?>assets/img/temas/default/estadisticas.png" height="37"> <b class="caret"></b></a>
                                        <ul  class="dropdown-menu">
                                            <li class="<?= ($tab == "estadisticaestudiantes") ? "active" : ""; ?>">
                                                <a href="<?= base_url() ?>estadisticaestudiantes/<?= $idCurso ?>">
                                                    Estudiantes
                                                </a>
                                            </li>
                                            <li class="<?= ($tab == "estadisticamateriales") ? "active" : ""; ?>">
                                                <a href="<?= base_url() ?>estadisticamateriales/<?= $idCurso ?>">
                                                    Materiales
                                                </a>
                                            </li>
                                            <li class="<?= ($tab == "estadisticaevaluaciones") ? "active" : ""; ?>">
                                                <a href="<?= base_url() ?>estadisticaevaluaciones/<?= $idCurso ?>">
                                                    Evaluaciones
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                <?php } ?>
                                <li class="<?= ($tab == "muro") ? "active" : "" ?> icono"><a  title="Muro" href="<?= base_url() ?>muro/<?= $idCurso ?>"><img src="<?= base_url() ?>assets/img/temas/default/muro.png" height="37"></a></li>
                                <li class="<?= ($tab == "ranking") ? "active" : "" ?> icono"><a title="Ranking" href="<?= base_url() ?>ranking/<?= $idCurso ?>"><img src="<?= base_url() ?>assets/img/temas/default/ranking.png" height="37"></a></li>
                                <li class="<?= ($tab == "logros") ? "active" : "" ?> icono"><a title="Logros" href="<?= base_url() ?>logros/<?= $idCurso ?>"><img src="<?= base_url() ?>assets/img/temas/default/logro.png" height="37"></a></li>
                                <li class="<?= ($tab == "foro") ? "active" : "" ?> icono">
                                    <?= tabForo($idCurso); ?>
                                </li>

                            <?php } ?>

                            <li class="dropdown <?= (isset($idCurso))?"icono-drop":"" ?>">
                                <a href="#" class="dropdown-toggle white" data-toggle="dropdown"> <?= $_SESSION["nombre"] ?> <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?= base_url() ?>perfil">
                                            <span class="glyphicon glyphicon-user"></span>
                                            Pefil
                                        </a>
                                    </li>
                                    <li class="divider"></li>

                                    <li>
                                        <a href="<?= base_url() ?>salir">
                                            <span class="glyphicon glyphicon-off"></span>
                                            Salir
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } else { ?>

                            <li class=" nav  navbar-nav dropdown">
                                <a class="white cursor" href="#" data-toggle="dropdown">Entrar <b class="caret"></b></a>
                                <ul class="dropdown-menu" style="padding: 15px;min-width: 250px;">
                                    <li>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form class="form" role="form" method="post" action="<?= base_url() ?>entrar" >
                                                    <div class="form-group">
                                                        <input name="email" type="text" class="form-control" placeholder="E-mail" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="sr-only" for="exampleInputPassword2">Password</label>
                                                        <input name="password" type="password" class="form-control"  placeholder="Contraseña" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-success btn-block">Entrar</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <a id="link-olvido-pass" href="<?= base_url() ?>recuperar"> ¿Olvidó su contraseña?</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class=" nav  navbar-nav <?= ($tab == "registrarse") ? "active" : "" ?>">
                                <a class="white cursor" href="<?= base_url() ?>registrarse"> Registrarse</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>
        <?php if (isset($idCurso)) { ?>
            <div id="marco-superior">
            </div>
        <?php } ?>