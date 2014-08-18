var a, b, x, l1;

$(function() {
    API = getAPI();
     API.LMSInitialize("");

    l1 = getRandom(200, 250);
    a = getRandom(20, 50);
    b = getRandom(30, 60);
    x = 180 - a - b;

    var correctAnswer = x;
    var missConception1 = 270 - a - b;
 //   console.log(correctAnswer + " " + missConception1);
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
                    feedback = "Suma de los ángulos interiores de todo triángulo es de 270";
                    $("#feedback").html("Calificación: <b>" + calificacion + "</b> <br> Probablemente no tienes clara la teoria de triangulos").removeClass("hide");
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

    ag = toDegrees(a);
    bg = toDegrees(b);
    xg = toDegrees(x);
    var x1 = 5;
    var y1 = 200;

    var x2 = l1;
    var y2 = y1;

    var x3 = x1 + Math.cos(ag) * l1 * Math.sin(bg) / Math.sin(xg);
    var y3 = y1 - Math.sin(ag) * l1 * Math.sin(bg) / Math.sin(xg);


    var canvas = document.getElementById('canvas');

    var ctx = canvas.getContext('2d');

    ctx.strokeStyle = "#0069B2";
    ctx.lineWidth = 2;
    ctx.moveTo(x1, y1);


    ctx.lineTo(x2, y2);

    ctx.lineTo(x3, y3);


    ctx.lineTo(x1, y1);

    ctx.stroke();

    ctx.beginPath(); //iniciar ruta
    ctx.strokeStyle = "red"; //color de lï¿½nea
    ctx.lineWidth = 1; //grosor de lï¿½nea
    ctx.arc(x1, y1, 20, -ag, 0);
    ctx.stroke();

    ctx.strokeStyle = "blue"; //color de lï¿½nea
    ctx.beginPath(); //iniciar ruta
    ctx.arc(x2, y2, 20, -Math.PI, -Math.PI + bg);
    ctx.stroke();

    ctx.strokeStyle = "green"; //color de lï¿½nea
    ctx.beginPath(); //iniciar ruta
    ctx.arc(x3, y3, 20, bg, -Math.PI - ag);
    ctx.stroke();


    ctx.font = "15px Verdana";
    ctx.fillStyle = "green";
    ctx.fillText("x=?", x3 - 15, y3 - 5);
    ctx.fillStyle = "red";
    ctx.fillText("a=" + a + String.fromCharCode(176), x1 + 10, y1 + 15);
    ctx.fillStyle = "blue";
    ctx.fillText("b=" + b + String.fromCharCode(176), x2 - 50, y2 + 15);
}
function toDegrees(angle) {
    return angle * (Math.PI / 180);
}
