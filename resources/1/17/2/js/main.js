var a, b, y;

$(function() {
      API = getAPI();
     API.LMSInitialize(""); 

    a = getRandom(45, 75);
    b = getRandom(60, 90);
    y = 180 - a - b;

    var correctAnswer = y;
    var missConception1 = 270 - a - b;
    var missConception2 = a;
    var missConception3 = b;
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
                case missConception2:
                    calificacion = 0.5;
                    feedback = "a";
                    $("#feedback").html("Calificación: <b>" + calificacion + "</b> <br> Probablemente no tienes clara la teoria de triangulos").removeClass("hide");
                    break;
                case missConception3:
                    calificacion = 0.5;
                    feedback = "b";
                    $("#feedback").html("Calificación: <b>" + calificacion + "</b> <br> Probablemente no tienes clara la teoria de triangulos").removeClass("hide");
                    break;
                default:
                    calificacion = 0.0;
                    $("#feedback").html("Calificación: <b>" + calificacion + "</b> <br>Te recomendamos este <a href='http://www.youtube.com/watch?v=8QccEGEBBTM' target='_blank'>video</a> acerca de triangulos.").removeClass("hide");
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
    ag = toRadians(a);
    bg = toRadians(b);
    yg = toRadians(y);

    var mx = 10;
    var my = 70;
    var w = 180;

    var Ox = mx + w;
    var Oy = my;
    var z = my / Math.tan(yg);
    var Px = Ox + z;
    var Py = 0;
    var Qx = Px - 220 * z / my;
    var Qy = 220;
    var Rx = Ox + 110 / Math.tan(bg);
    var Ry = 180;

    var canvas = document.getElementById('canvas');
    var ctx = canvas.getContext('2d');
    ctx.strokeStyle = "#0069B2";
    ctx.lineWidth = 2;

    ctx.moveTo(mx, 180);
    ctx.lineTo(300 - mx, 180);
    ctx.moveTo(mx, my);
    ctx.lineTo(300 - mx, my);
    ctx.moveTo(Px, Py);
    ctx.lineTo(Qx, Qy);
    ctx.moveTo(Ox, Oy);
    ctx.lineTo(Rx, Ry);

    ctx.stroke();

    ctx.strokeStyle = "FF9900";
    ctx.lineWidth = 1;

    ctx.strokeStyle = "green"
    ctx.beginPath();
    ctx.arc(Ox, Oy, 20, 2 * Math.PI - yg, 0);
    ctx.stroke();

    ctx.strokeStyle = "red"
    ctx.beginPath();
    ctx.arc(Ox, Oy, 20, Math.PI - ag - yg, Math.PI - yg);
    ctx.stroke();

    ctx.strokeStyle = "blue"
    ctx.beginPath();
    ctx.arc(Rx, Ry, 20, Math.PI, -Math.PI + bg);
    ctx.stroke();

    ctx.font = "15px Verdana";
     ctx.fillStyle = "green"
    ctx.fillText("y=?", Ox + 30, Oy - 10);
     ctx.fillStyle = "red"
    ctx.fillText("a=" + a + String.fromCharCode(176), Ox + 20, Oy + 20);
     ctx.fillStyle = "blue"
    ctx.fillText("b=" + b + String.fromCharCode(176), Rx - 50, Ry + 15);
 ctx.fillStyle = "#444"
    ctx.font = "24px Verdana bold";
    ctx.fillText("A", 0, my - 10);
    ctx.fillText("B", 280, my - 10);
    ctx.fillText("C", 0, 205);
    ctx.fillText("D", 280, 205);
}
function toRadians(angle) {
    return angle * (Math.PI / 180);
}
