var a, b, c, d, e, f;

$(function() {
    try {
        API = getAPI();
        API.LMSInitialize("");
    } catch (e) {
        console.log(e);
    }

    /*var vars = shuffleArray([-9,-8,-7,-6,-5,-4,-3,-2,-1,1,2,3,4,5,6,7,8,9]);
     a = vars[0];
     b = vars[1];
     c = vars[2];
     d = vars[3];
     e = vars[4];
     f = vars[5];*/

    a = getRandom(7, 10);
    b = getRandom(7, 10);
    c = getRandom(7, 10);
    d = getRandom(-6, -4);
    e = getRandom(-3, -1);
    f = getRandom(-6, -4);

    var correctAnswer1 = a;
    var correctAnswer2 = e;
    var correctAnswer3 = d;
    var correctAnswer4 = f;
    //var missConception1 = n;
    //console.log(correctAnswer1 + " " + correctAnswer2 + " " + correctAnswer3 + " " + correctAnswer4);
    draw();

    $("#verificar").click(function() {
        var valor1 = $("#answer1").val().trim();
        var valor2 = $("#answer2").val().trim();
        var valor3 = $("#answer3").val().trim();
        var valor4 = $("#answer4").val().trim();
        if (valor1 != "" && valor2 != "") {
            $("#correcto").addClass("hide");
            $("#feedback").addClass("hide");
            var calificacion = 0;
            var feedback = "";
            valor1 = parseFloat(valor1);
            valor2 = parseFloat(valor2);
            valor3 = parseFloat(valor3);
            valor4 = parseFloat(valor4);

            if ((valor1 == correctAnswer1 && valor2 == correctAnswer2) || (valor1 == correctAnswer2 && valor2 == correctAnswer1) &&
                    (valor3 == correctAnswer3 && valor4 == correctAnswer4) || (valor3 == correctAnswer4 && valor4 == correctAnswer3)
                    ) {
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
    $("#aceptar").click(function() {
        window.parent.location.reload();
    });
    $('#modal').on('hide.bs.modal', function(e) {
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
    $('.mvar[value=ab]').html(a + b);
    $('.mvar[value=axb]').html(a * b);
    $('.mvar[value=cd]').html(c + d);
    $('.mvar[value=cxd]').html(c * d);
    $('.mvar[value=ce]').html(c + e);
    $('.mvar[value=cxe]').html(c * e);
    $('.mvar[value=bf]').html(b + f);
    $('.mvar[value=bxf]').html(b * f);
}
