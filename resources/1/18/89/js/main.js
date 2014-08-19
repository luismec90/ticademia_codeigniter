var a, b, ra, rb;

$(function() {
    try {
        API = getAPI();
        API.LMSInitialize("");
    } catch (e) {
        console.log(e);
    }

    ra = getRandom(1, 7);
    rb = getRandom(1, 7);
    a = ra * ra;
    b = rb * rb;
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
    var answers = ['( ' + ra + 'x<sup>2</sup> + ' + rb + 'y<sup>3</sup>z<sup>4</sup> )( ' + ra + 'x<sup>2</sup> - ' + rb + 'y<sup>3</sup>z<sup>4</sup> )',
        '( ' + ra + 'x<sup>2</sup> - ' + rb + 'y<sup>3</sup>z<sup>4</sup> )<sup>2</sup>',
        '( ' + ra + 'x<sup>2</sup> - ' + rb + 'y<sup>3</sup>z<sup>4</sup> )( ' + a + 'x<sup>4</sup> + ' + ra + '' + rb + 'x<sup>2</sup>y<sup>3</sup>z<sup>4</sup> + ' + b + 'y<sup>6</sup>z<sup>8</sup> )',
        '( ' + ra + 'x + ' + rb + 'yz )( ' + ra + 'x - ' + rb + 'yz )'];
    var is = [0, 1, 2, 3];
    shuffleArray(is);
    var i = 0;
    while (i < 4) {
        $("#label" + (i + 1)).html(answers[is[i]]);
        if (is[i] == 0)
            correct = i + 1;
        i++;
    }

    $('.mvar[value=a]').html(a);
    $('.mvar[value=b]').html(b);
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