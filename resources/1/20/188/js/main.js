
$(function() {
    API = getAPI();
    API.LMSInitialize("");

    var correctAnswer = "clavesecreta";

    $("#verificar").click(function() {
        var valor = $("#answer").val().trim();
        if (valor != "") {
            $("#correcto").addClass("hide");
            $("#feedback").addClass("hide");
            var calificacion = 0;
            var feedback = "";
            switch (valor) {
                case correctAnswer + "2014":
                    calificacion = 1.0;
                    $("#correcto").html("Calificación: <b>" + calificacion + "</b>").removeClass("hide");
                    break;
                default:
                    calificacion = 0.0;
                    $("#feedback").html("Calificación: <b>" + calificacion + "</b> <br>Te recomendamos este <a href='https://www.youtube.com/watch?v=CA1jtq4luMo' target='_blank'>video</a> acerca de triangulos.").removeClass("hide");
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


});

