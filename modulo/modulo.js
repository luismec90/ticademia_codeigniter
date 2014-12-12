$(function () {


    $("#subir-control-materiales").click(function () {
        var scroll = $("#contenedor-materiales").data("scroll");
        if (scroll != 0) {
            scroll -= 69;

            $(".material:visible:last").animate({
                height: '0',
                width: '0'
            }, 300, function () {

            });

            $("#contenedor-materiales").animate({marginTop: '-' + scroll + 'px'}, 300);
            $("#contenedor-materiales").data("scroll", scroll);
        }
    });

    $("#bajar-control-materiales").click(function () {
        var cantidadMatariales = $(".material").length;
        var scroll = $("#contenedor-materiales").data("scroll");
        if ((cantidadMatariales-5) * 69 > scroll) {
            scroll += 69;
            $("#contenedor-materiales").animate({marginTop: '-' + scroll + 'px'}, 300);
            $(".material:visible:last").next().animate({
                height: '69px',
                width: '300px'
            }, 300);

            $("#contenedor-materiales").data("scroll", scroll);
        }

    });

    $("#bajar-control-evaluaciones").click(function () {
        var cantidadEvaluaciones = $(".evaluacion").length;
        var scroll = $("#contenedor-evaluaciones").data("scroll");
        if ((cantidadEvaluaciones-3) * 114 > scroll) {
            scroll += 114;
            $("#contenedor-evaluaciones").animate({marginTop: '-' + scroll + 'px'}, 300);
            $(".evaluacion:visible:last").next().animate({
                height: '114',
                width: '300px'
            }, 300);
            $("#contenedor-evaluaciones").data("scroll", scroll);
        }
    });

    $("#subir-control-evaluaciones").click(function () {
        var scroll = $("#contenedor-evaluaciones").data("scroll");
        if (scroll != 0) {
            scroll -= 114;
            $(".evaluacion:visible:last").animate({
                height: '0',
                width: '0'
            }, 300, function () {

            });
            $("#contenedor-evaluaciones").animate({marginTop: '-' + scroll + 'px'}, 200);
            $("#contenedor-evaluaciones").data("scroll", scroll);
        }
    });
});