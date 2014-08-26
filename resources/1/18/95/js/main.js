var a, n, r;

$(function() {
    try {
        API = getAPI();
        API.LMSInitialize("");
    } catch (e) {
        console.log(e);
    }

    a = getRandom(2, 3);
    n = getRandom(17, 20);
    r = getRandom(3, 5);
    //console.log(correctAnswer + " " + missConception1);
    var correctAnswer = draw();

    $("#verificar").click(function() {
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
function draw() {
    var correct = 0;

    var fn = fact(n);
    var fr = fact(r);
    var fnr = fact(n - r);

    var a1 = Math.pow(-1, r) * fn * a * a / (fr * fnr);
    var a2 = -a1;
    var a3 = Math.pow(-1, r + 1) * a * a;
    var a4 = Math.pow(-1, r) * fn / (fr * fnr * Math.pow(a, n - r - 2));

    var answers = [a1, a2, a3, a4];

    var is = [0, 1, 2, 3];
    shuffleArray(is);
    var i = 0;
    while (i < 4) {
        $("#label" + (i + 1)).html(answers[is[i]]);
        if (is[i] == 0)
            correct = i + 1;
        i++;
    }

    $('.mvar[value=n]').html(n);
    $('.mvar[value=r]').html(r);
    $('.mvar[value=a]').html(a);
    $('.mvar[value=nr2]').html(n - r - 2);
    return correct;
}
function fact(n) {
    if (n == 1)
        return 1;
    return n * fact(n - 1);
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