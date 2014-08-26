var n, r;

$(function() {
    try {
        API = getAPI();
        API.LMSInitialize("");
    } catch (e) {
        console.log(e);
    }

    n = getRandom(45, 55);
    r = getRandom(5, 10);

    var fn = fact(n);
    var fr = fact(r);
    var fnr = fact(n - r);

    var correctAnswer = fn / (fr * fnr);
    /*var missConception1 = fn/fr;
     var missConception2 = fn/fnr;
     var missConception3 = fr;*/
    //console.log(correctAnswer + " " + missConception1);
    draw();

    $("#verificar").click(function() {
        var valor = $("#answer").val().trim();
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
                    /*case missConception1:
                     calificacion = 0.5;
                     feedback = "n!/r!";
                     $("#feedback").html("Calificación: <b>" + calificacion + "</b> <br> ...").removeClass("hide");
                     break;*/
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
function fact(n) {
    if (n == 1)
        return 1;
    return n * fact(n - 1);
}
function draw() {
    $('.mvar[value=n]').html(n);
    $('.mvar[value=r]').html(r);
}