var a, b;

$(function () {
    try {
        API = getAPI();
        API.LMSInitialize("");
    } catch (e) {
        console.log(e);
    }

    a = getRandom(1, 5);
    b = getRandom(6, 10);

    var correctAnswer1 = a;
    var correctAnswer2 = -b;
    //var missConception1 = n;
    //console.log(correctAnswer1 + " " + correctAnswer2 + " " + correctAnswer3 + " " + correctAnswer4);
    draw();

    $("#verificar").click(function () {
        var valor1 = $("#answer1").val().trim();
        var valor2 = $("#answer2").val().trim();
        if (valor1 != "" && valor2 != "") {
            $("#correcto").addClass("hide");
            $("#feedback").addClass("hide");
            var calificacion = 0;
            var feedback = "";
            valor1 = parseFloat(valor1);
            valor2 = parseFloat(valor2);

            if (valor1 == correctAnswer1 && valor2 == correctAnswer2 || valor1 == correctAnswer2 && valor2 == correctAnswer1) {
                calificacion = 1.0;
                $("#correcto").html("Calificación: <b>" + calificacion + "</b>").removeClass("hide");
            } else {
                calificacion = 0.0;
                $("#feedback").html("Calificación: <b>" + calificacion + "</b> <br> ...").removeClass("hide");
            }
            $(this).attr("disabled", true);
            API.closeQuestion();
            if (typeof API.calificar == 'function') {
                API.calificar(calificacion, feedback);
            }
            API.LMSSetValue("cmi.core.score.raw", calificacion);
            API.LMSFinish("feedback", feedback);
            API.notifyDaemon(calificacion);
        }
    });
    $("#aceptar").click(function () {
        window.parent.location.reload();
    });
    $('#modal').on('hide.bs.modal', function (e) {
        window.parent.location.reload();
    });

});
function getRandom(bottom, top) {
    return Math.floor(Math.random() * (1 + top - bottom)) + bottom;
}
function getRandomFrom(vals) {
    return vals[getRandom(0, vals.length - 1)];
}
function shuffleArray(array) {
    for (var i = array.length - 1; i > 0; i--) {
        var j = Math.floor(Math.random() * (i + 1));
        var temp = array[i];
        array[i] = array[j];
        array[j] = temp;
    }
    return array;
}
function draw() {
    $('.mvar[value=a]').html(a);
    $('.mvar[value=a2]').html(a * a);
    $('.mvar[value=b]').html(b);
    $('.mvar[value=b2]').html(b * b);
}
