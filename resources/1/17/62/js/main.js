var z,w;

$(function() {
    try{
        API = getAPI();
        API.LMSInitialize("");
    }catch(e){
        console.log(e);
    }

    z = getRandom(1,10);
    w = getRandom(1,10);

    var correctAnswer1 = 1.03*z*z*w+2.09*z*z*z;
    draw();

    $("#verificar").click(function() {
        var valor1 = $("#answer1").val().trim();
        if (valor1 != "") {
            $("#correcto").addClass("hide");
            $("#feedback").addClass("hide");
            var calificacion = 0;
            var feedback = "";
            valor1 = parseFloat(valor1);
            if (Math.abs(valor1 - correctAnswer1)<0.006) {
                    calificacion = 1.0;
                    $("#correcto").html("Calificación: <b>" + calificacion + "</b>").removeClass("hide");
            }else{
                    calificacion = 0.0;
                    $("#feedback").html("Calificación: <b>" + calificacion + "<br/><br/> ...").removeClass("hide");
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
function draw(){
    $('.mvar[value=z]').html(z);
    $('.mvar[value=w]').html(w);
}
function toRadians(angle) {
    return angle * (Math.PI / 180);
}
