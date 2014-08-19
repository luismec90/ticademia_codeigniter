var a, b;

$(function() {
    try {
        API = getAPI();
        API.LMSInitialize("");
    } catch (e) {
        console.log(e);
    }

    a = getRandom(2, 4);
    b = getRandom(2, 4);

    var correctAnswer1 = a;
    var correctAnswer2 = 1;
    var correctAnswer3 = b;
    var correctAnswer4 = 1;
    var correctAnswer5 = a * a;
    var correctAnswer6 = 2;
    var correctAnswer7 = a * b;
    var correctAnswer8 = 1;
    var correctAnswer9 = 1;
    var correctAnswer10 = b * b;
    var correctAnswer11 = 2;
    //var missConception1 = n;
    //console.log(correctAnswer);
    draw();

    $("#verificar").click(function() {
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
        var valor11 = $("#answer11").val().trim();
        if (valor1 != "" && valor2 != "" && valor3 != "" && valor4 != "" && valor5 != "" && valor6 != "" && valor7 != "" && valor8 != "" && valor9 != "" && valor10 != "" && valor11 != "") {
            $("#correcto").addClass("hide");
            $("#feedback").addClass("hide");
            var calificacion = 0;
            var feedback = "";
            valor1 = parseFloat(valor1);
            valor2 = parseFloat(valor2);
            valor3 = parseFloat(valor3);
            valor4 = parseFloat(valor4);
            valor5 = parseFloat(valor5);
            valor6 = parseFloat(valor6);
            valor7 = parseFloat(valor7);
            valor8 = parseFloat(valor8);
            valor9 = parseFloat(valor9);
            valor10 = parseFloat(valor10);
            valor11 = parseFloat(valor11);

            if (valor1 == correctAnswer1 &&
                    valor2 == correctAnswer2 &&
                    valor3 == correctAnswer3 &&
                    valor4 == correctAnswer4 &&
                    valor5 == correctAnswer5 &&
                    valor6 == correctAnswer6 &&
                    valor7 == correctAnswer7 &&
                    valor8 == correctAnswer8 &&
                    valor9 == correctAnswer9 &&
                    valor10 == correctAnswer10 &&
                    valor11 == correctAnswer11) {
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
    $('.mvar[value=a3]').html(a * a * a);
    $('.mvar[value=b3]').html(b * b * b);
}
