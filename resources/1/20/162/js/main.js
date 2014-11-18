var m, n, j, k;

$(function () {
    try {
        API = getAPI();
        API.LMSInitialize("");
    } catch (e) {
        console.log(e);
    }

    m = getRandom(2, 10);
    n = getRandom(2, 10);
    j = getRandom(1, 7);
    k = getRandom(1, 7);
    //console.log(correctAnswer + " " + missConception1);
    var correctAnswer = draw();

    $("#verificar").click(function () {
        var valor = $("input[name=answer]:checked").val().trim();
        if (valor != "") {
            $("#correcto").addClass("hide");
            $("#feedback").addClass("hide");
            var calificacion = 0;
            var feedback = "";
            valor = parseFloat(valor);
            switch (valor) {
                case correctAnswer:
                    calificacion = 1.0;
                    $("#correcto").html("Calificación: <b>" + calificacion + "</b>").removeClass("hide");
                    break;
                default:
                    calificacion = 0.0;
                    $("#feedback").html("Calificación: <b>" + calificacion + "</b> <br> ...").removeClass("hide");
                    break;
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
function draw() {
    var mp = (m % 2 == 0);
    var np = (n % 2 == 0);
    var jp = (j % 2 == 0);
    var kp = (k % 2 == 0);

    var correctIndex = 0;
    if (mp && np && jp && kp) correctIndex = 0;
    else if (!mp && !np && !jp && kp) correctIndex = 1;
    else if (mp && np && !jp && kp) correctIndex = 2;
    else if (!mp && !np && jp && kp) correctIndex = 3;
    else if (mp && np && !kp) correctIndex = 4;
    else if (((!mp && np) || (mp && !np)) && jp && kp) correctIndex = 5;
    else if (!mp && !np && !kp) correctIndex = 6;
    else if (((!mp && np) || (mp && !np)) && !jp && kp) correctIndex = 7;

    var answers = [
        "f es par y g es par",
        "f es impar y g es impar",
        "f es par y g es impar",
        "f es impar y g es par",
        "f es par y g no es par ni impar",
        "f no es par ni impar y g es par",
        "f es impar y g no es par ni impar",
        "f no es par ni impar y g es impar",
        "f no es par ni impar y g es no es par ni impar"];

    var is = [0, 1, 2, 3, 4, 5, 6, 7,8];
    shuffleArray(is);
    var i = 0;
    var correct = 0;
    while (i < 9) {
        $("#label" + (i + 1)).html(answers[is[i]]);
        if (is[i] == correctIndex)correct = i + 1;
        i++;
    }

    $('.mvar[value=m]').html(m);
    $('.mvar[value=n]').html(n);
    $('.mvar[value=j]').html(j);
    $('.mvar[value=k]').html(k);
    return correct;
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