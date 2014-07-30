var a, b, y;

$(function() {
    API = getAPI();
    API.LMSInitialize("");

    a = getRandom(35, 75);
    y = 180 - a;

    var correctAnswer = y;
    var missConception1 = a;
    console.log(correctAnswer + " " + missConception1);
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
                case missConception1:
                    calificacion = 0.5;
                    feedback = "a";
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
function draw(){
	ag = toRadians(a);
    bg = toRadians(b);
    yg = toRadians(y);
	
	var mx = 10;
	var my = 70;
	var w = 80;
	
	var Ox = mx+w;
	var Oy = my;
	var z = my/Math.tan(ag);
	var Px = Ox-z;
	var Py = 0;
	var Qx = Px+220*z/my;
	var Qy = 220;
	var Rx = Ox+z*110/my;
	var Ry = 180;
		
	var canvas = document.getElementById('canvas');
    var ctx = canvas.getContext('2d');
    ctx.strokeStyle = "#0069B2";
    ctx.lineWidth = 2;
	
	ctx.moveTo(mx,180);
	ctx.lineTo(300-mx,180);
	ctx.moveTo(mx,my);
	ctx.lineTo(300-mx,my);
	ctx.moveTo(Px,Py);
	ctx.lineTo(Qx,Qy);
	
	ctx.stroke();
	
	ctx.strokeStyle = "FF9900";
    ctx.lineWidth = 1;
	
	ctx.beginPath();
    ctx.arc(Ox, Oy, 20, Math.PI, Math.PI+ag);
    ctx.stroke();
	
	ctx.beginPath();
    ctx.arc(Rx, Ry, 20, -yg,0);
    ctx.stroke();
	
	ctx.font = "15px Verdana";
    ctx.fillText("z=?", Rx+20, Ry-20);
    ctx.fillText("a=" + a + String.fromCharCode(176), Ox+5, Oy-5);
	
	ctx.font = "24px Verdana bold";
	ctx.fillText("A", 0, my-10);
	ctx.fillText("B", 280, my-10);
	ctx.fillText("C", 0, 205);
	ctx.fillText("D", 280, 205);
}
function toRadians(angle) {
    return angle * (Math.PI / 180);
}
