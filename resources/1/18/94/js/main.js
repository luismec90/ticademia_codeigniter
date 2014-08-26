var n, r;

$(function() {
    try {
        API = getAPI();
        API.LMSInitialize("");
    } catch (e) {
        console.log(e);
    }

    n = getRandom(12, 17);
    r = getRandom(2, 4);
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

    var factn = fact(n);
    var factr = fact(r);
    var factnr = fact(n - r);
    var fact2r = fact(2 * r);
    var factn2r = fact(n - 2 * r);

    var answers = [(factn / (factr * factnr)) + 'u<sup>' + (n - r) + '</sup>v<sup>' + (2 * r) + '</sup>',
        (factn / (fact2r * factn2r)) + 'u<sup>' + (n - 2 * r) + '</sup>v<sup>' + (2 * r) + '</sup>',
        (factn / (factr * factnr)) + 'u<sup>' + (r) + '</sup>v<sup>' + (2 * r) + '</sup>',
        (factn / (fact2r * factn2r)) + 'u<sup>' + (r) + '</sup>v<sup>' + (2 * r) + '</sup>'];

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
    $('.mvar[value=2r]').html(2 * r);
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