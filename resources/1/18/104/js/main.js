var k, n;

$(function() {
    try {
        API = getAPI();
        API.LMSInitialize("");
    } catch (e) {
        console.log(e);
    }

    k = getRandom(2, 6);
    n = getRandom(2 + k, 6 + k);
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
    var answers = ['<span class="fraccion"><span>m<sup>' + (n - k) + '</sup> + 2m + 1</span><span>m<sup>' + (n) + '</sup></span></span>',
        '<span class="fraccion"><span>m<sup>' + (n - k + 1) + '</sup> + 2</span><span>m<sup>' + (n) + '</sup></span></span>',
        '<span class="fraccion"><span>m<sup>' + (n - k + 2) + '</sup> + 2</span><span>m<sup>' + (n) + '</sup></span></span>',
        '<span class="fraccion"><span>m<sup>' + (n - k + 1) + '</sup> + 2m</span><span>m<sup>' + (k) + '</sup></span></span>',
        '<span class="fraccion">1</span><span>m<sup>' + (k) + '</sup></span></span>'];
    var is = [0, 1, 2, 3, 4];
    shuffleArray(is);
    var i = 0;
    while (i < 5) {
        $("#label" + (i + 1)).html(answers[is[i]]);
        if (is[i] == 0)
            correct = i + 1;
        i++;
    }

    $('.mvar[value=k]').html(k);
    $('.mvar[value=n]').html(n);
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