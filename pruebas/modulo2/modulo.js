var initial_position_door_left = $("#left-door").offset().left;
var initial_position_door_right = $("#right-door").offset().left;
var audioDoors = document.getElementById("doors-audio");
var audioWall = document.getElementById("wall-audio");
$(function () {


    $("#subir-control-materiales").click(function () {
        var scroll = $("#contenedor-materiales").data("scroll");
        if (scroll != 0) {
            scroll -= 69;
            playWall();
            $(".material:visible:last").animate({
                height: '0',
                width: '0'
            }, 500, function () {

            });


            $("#contenedor-materiales").animate({marginTop: '-' + scroll + 'px'}, 500);
            $("#contenedor-materiales").data("scroll", scroll);
        }
    });

    $("#bajar-control-materiales").click(function () {
        var cantidadMatariales = $(".material").length;
        var scroll = $("#contenedor-materiales").data("scroll");
        if ((cantidadMatariales - 5) * 69 > scroll) {
            scroll += 69;
            playWall();
            $("#contenedor-materiales").animate({marginTop: '-' + scroll + 'px'}, 500);
            $(".material:visible:last").next().animate({
                height: '69px',
                width: '300px'
            }, 500);

            $("#contenedor-materiales").data("scroll", scroll);
        }

    });

    $("#bajar-control-evaluaciones").click(function () {
        var cantidadEvaluaciones = $(".evaluacion-row").length;
        var scroll = $("#contenedor-evaluaciones").data("scroll");
        if ((cantidadEvaluaciones - 3) * 114 > scroll) {
            scroll += 114;
            playWall();
            $("#contenedor-evaluaciones").animate({marginTop: '-' + scroll + 'px'}, 500);
            $(".evaluacion-row:visible:last").next().animate({
                height: '114',
                width: '300px'
            }, 500);
            $("#contenedor-evaluaciones").data("scroll", scroll);
        }
    });

    $("#subir-control-evaluaciones").click(function () {
        var scroll = $("#contenedor-evaluaciones").data("scroll");
        if (scroll != 0) {
            scroll -= 114;
            playWall();
            $(".evaluacion-row:visible:last").animate({
                height: '0',
                width: '0'
            }, 500, function () {

            });
            $("#contenedor-evaluaciones").animate({marginTop: '-' + scroll + 'px'}, 500);
            $("#contenedor-evaluaciones").data("scroll", scroll);
        }
    });

    $("#btn-mover-puertas").click(function () {
        moveDoors($("#input-mover-puertas").val());
    });





});

function moveDoors(percentage) {

    if ($.isNumeric(percentage) && percentage >= 0 && percentage <= 100) {
        playDoors();
        var max = 70;
        var amount = max * percentage / 100;
        $("#left-door").animate({left: (initial_position_door_left - amount) + 'px'},1000);
        $("#right-door").animate({left: (initial_position_door_right + amount) + 'px'},1000);
    }
}
function playDoors() {

    audioDoors.play();
}
function playWall() {

    audioWall.play();
}
