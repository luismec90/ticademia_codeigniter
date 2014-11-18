var m, k;

$(function () {
    try {
        API = getAPI();
        API.LMSInitialize("");
    } catch (e) {
        console.log(e);
    }

    m = getRandom(2, 16);
    k = getRandom(1, 15);

    console.log((m + 1) + " " + (k + 1));

    var correctAnswer1 = "(-inf";
    var correctAnswer2 = "-";
    var correctAnswer3 = m * k;
    var correctAnswer4 = m * k - 1;
    var correctAnswer5 = ")";
    var correctAnswer6 = "(";
    var correctAnswer7 = "-";
    var correctAnswer8 = m * k;
    var correctAnswer9 = m * k + 1;
    var correctAnswer10 = "inf)"


    //var missConception1 = n;
    //console.log(correctAnswer1);
    //console.log(correctAnswer1 + " " + correctAnswer2);
    draw();

    $("#verificar").click(function () {
        var valor1 = $("#answer1").val().trim();
        var valor2 = $("#answer2").val().trim();
        var valor3 = $("#answer3").val().trim();
        var valor4 = $("#answer4").val().trim();
        var valor5 = $("#answer5").val().trim();
        var valor6 = $("#answer6").val().trim();
        var valor7 = $("#answer7").val().trim();
        var valor8 = $("#answer8").val().trim();
        var valor9 = $("#answer9").val().trim();
        var valor10 = $("#answer10").val().trim();


        if (valor1 != "" && valor2 != "" && valor3 != "" && valor4 != "" && valor5 != "" && valor6 != "" && valor7 != "" && valor8 != "" && valor9 != "" && valor10 != "") {
            $("#correcto").addClass("hide");
            $("#feedback").addClass("hide");
            var calificacion = 0;
            var feedback = "";
            valor3 = parseFloat(valor3);
            valor4 = parseFloat(valor4);
            valor8 = parseFloat(valor8);
            valor9 = parseFloat(valor9);

            if (valor1 == correctAnswer1 &&
                valor2 == correctAnswer2 &&
                decimalComparison(valor3 / valor4, correctAnswer3 / correctAnswer4, 2) &&
                valor5 == correctAnswer5 &&
                valor6 == correctAnswer6 &&
                valor7 == correctAnswer7 &&
                decimalComparison(valor8 / valor9, correctAnswer8 / correctAnswer9, 2) &&
                valor10 == correctAnswer10) {
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
function decimalComparison(v1, v2, d) {
    d = Math.pow(10, d);
    v1 = Math.round(v1 * d);
    v2 = Math.round(v2 * d);
    return v1 == v2;
}
function draw() {
    $('.mvar[value=e1]').html(m);
    $('.mvar[value=e2]').html(k);
}
