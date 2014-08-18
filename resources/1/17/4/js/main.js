var a, x;

$(function() {
    API = getAPI();
    API.LMSInitialize("");

    a = getRandom(100, 145);
    x = 180 - a;

    var correctAnswer = x;
    var missConception1 = a;
  //  console.log(correctAnswer + " " + missConception1);
    draw();

    $("#verificar").click(function() {
        var valor = $("#answer").val().trim(); valor = ((valor.split(",")).length == 2) ? valor.replace(",", ".") : valor;
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
                case missConception1:
                    calificacion = 0.5;
                    feedback = "No tiene clara la teoría de triángulos";
                    $("#feedback").html("Calificación: <b>" + calificacion + "</b> <br> Probablemente no tienes clara la teoría de triángulos").removeClass("hide");
                    break;
                default:
                    calificacion = 0.0;
                    $("#feedback").html("Calificación: <b>" + calificacion + "</b> <br>Te recomendamos este <a href='https://www.youtube.com/watch?v=CA1jtq4luMo' target='_blank'>video</a> acerca de triángulos.").removeClass("hide");
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
function draw() {
    var canvas = document.getElementById('canvas');

    var ctx = canvas.getContext('2d');

    ctx.strokeStyle = "#0069B2";
    ctx.lineWidth = 1;

    ctx.save();
    ctx.translate(150, 110);
    ctx.rotate(toDegrees(-(90 - a / 2)));
    ctx.moveTo(0, 0);
    ctx.lineTo(50, 0);
    ctx.translate(50, 0);
    ctx.rotate(toDegrees(90 - a / 2));
    ctx.font = "12px Verdana";
    ctx.fillText("L2", 10, 3);
    ctx.stroke();
    ctx.restore();

    ctx.save();
    ctx.translate(150, 110);
    ctx.rotate(toDegrees((90 - a / 2)));
    ctx.moveTo(0, 0);
    ctx.lineTo(50, 0);
    ctx.translate(50, 0);
    ctx.rotate(toDegrees(-(90 - a / 2)));
    ctx.font = "12px Verdana";
    ctx.fillText("L3", 10, 3);
    ctx.stroke();
    ctx.restore();


    ctx.save();
    ctx.translate(150, 110);
    ctx.rotate(toDegrees((-(270 - a / 2))));
    ctx.moveTo(0, 0);
    ctx.lineTo(50, 0);
    ctx.stroke();
    ctx.translate(50, 0);
    ctx.rotate(toDegrees(90 + (180 - a)));
    ctx.moveTo(0, 0);
    ctx.lineTo(0, 100);






    ctx.translate(0, 100);
    ctx.rotate(toDegrees(a / 2));
    ctx.font = "12px Verdana";
    ctx.fillText("L4", 10, 3);
    ctx.restore();

    ctx.save();
    ctx.translate(150, 110);
    ctx.rotate(toDegrees(((270 - a / 2))));
    ctx.moveTo(0, 0);
    ctx.lineTo(50, 0);
    ctx.stroke();
    ctx.translate(50, 0);
    ctx.rotate(toDegrees(-90 + a));
    ctx.moveTo(0, 0);
    ctx.lineTo(0, 100);
    ctx.translate(0, 100);
    ctx.rotate(toDegrees(180 - a / 2));
    ctx.font = "12px Verdana";
    ctx.fillText("L1", 10, 3);
    ctx.stroke();
    ctx.restore();

    ctx.strokeStyle = "red"
    ctx.beginPath(); //iniciar ruta
    ctx.strokeStyle = "FF9900";
    ctx.arc(150, 110, 10, toDegrees(-90 - a / 2), toDegrees(-90 + a / 2));
    ctx.stroke();
    ctx.font = "10px Verdana";
    ctx.fillStyle = "red"
    ctx.fillText("a=" + a + String.fromCharCode(176), 130, 93);

    var x = 150 - Math.sin(toDegrees(a / 2)) * 50;
    var y = 110 + Math.cos(toDegrees(a / 2)) * 50;
    ctx.strokeStyle = "green"
    ctx.beginPath(); //iniciar ruta
    ctx.strokeStyle = "FF9900";
    ctx.arc(x, y, 12, toDegrees(-(90 - a / 2)), toDegrees(90 - a / 2));
    ctx.stroke();
    ctx.font = "10px Verdana";
    ctx.fillStyle = "green"
    ctx.fillText("x=?", x + 20, y + 2);
    ctx.stroke();

}
function toDegrees(angle) {
    return angle * (Math.PI / 180);
}
