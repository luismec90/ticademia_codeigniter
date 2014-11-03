<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Pruebas</title>

        <!-- Bootstrap -->
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="pruebas.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div id="mapa" class="">

            <div id="panel-izq" class="">
                <div class="circulo circulo1 color4"></div>
                <div class="circulo circulo2 color4"></div>
                <div class="circulo circulo3 color4"></div>
            </div>
            <div id="panel-der" class="">
                <div class="circulo circulo1 color4"></div>
                <div class="circulo circulo2 color4"></div>
                <div class="circulo circulo3 color4"></div>
            </div>
            <div id="clouds">
                <div class="cloud x1"></div>
                <!-- Time for multiple clouds to dance around -->
                <div class="cloud x2"></div>
                <div class="cloud x3"></div>
                <div class="cloud x4"></div>
                <div class="cloud x5"></div>
            </div>

        </div>
        <div id="scene"> 
            <li  class="layer" data-depth="0.20"><img id="imagen0" src="fondo3.jpg"></li>
            <li  class="layer" data-depth="0.40"><img id="point1" width="800" src="mountain.png"></li>
            <li  class="layer" data-depth="0.30"><img id="point5" width="300" src="mountain.png"></li>
            <li  class="layer" data-depth="0.40"><img id="point6" width="350" src="mountain.png"></li>
            <li  class="layer" data-depth="0.50"><img id="point3" width="450" src="mountain.png"></li>
            <li  class="layer" data-depth="0.60"><img id="point2" width="500" src="mountain.png"></li>
            <li  class="layer" data-depth="0.80"><img id="point4" width="550" src="mountain.png">


        </div>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

        <script src="parallax.js"></script>

        <script src="pruebas.js"></script>
    </body>
</html>