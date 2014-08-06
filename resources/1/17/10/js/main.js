var a, b;

$(function() {
    try{
        API = getAPI();
        API.LMSInitialize("");
    }catch(e){
        console.log(e);
    }

    a = getRandom(95, 145);
    b = getRandom(105,155);

    var correctAnswer = 360-a-b;
    console.log(correctAnswer);
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
                default:
                    calificacion = 0.0;
                    $("#feedback").html("Calificación: <b>" + calificacion + "<br/><br/> ...").removeClass("hide");
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
    var ra = toRadians(a);
    var rb = toRadians(b);
    var rq = 2*Math.PI-ra-rb;
    var w = 90;
    var z = 25;

    var q90 = rq-Math.PI/2;
    var AB = w*Math.sin(Math.PI-rq)/Math.sin(Math.PI-rb);

    var A = {x:100,y:200};
    var Ap = {x:A.x-z,y:A.y};
    var Q = {x:A.x + w,y:A.y};
    var Qp = {x:A.x + w + z*Math.sin(q90), y:A.y + z*Math.cos(q90)};
    var B = {x:A.x+AB*Math.cos(Math.PI-ra),y:A.y - AB*Math.sin(Math.PI-ra)};
    var Bp = {x:B.x+z*Math.cos(Math.PI-ra),y:B.y - z*Math.sin(Math.PI-ra)};



    var canvas = document.getElementById('canvas');
    var ctx = canvas.getContext('2d');


    ctx.strokeStyle = "#0069B2";
    ctx.lineWidth = 2;

    ctx.moveTo(Ap.x,Ap.y);
    ctx.lineTo(Q.x,Q.y);
    ctx.moveTo(A.x,A.y);
    ctx.lineTo(Bp.x,Bp.y);
    ctx.moveTo(B.x,B.y);
    ctx.lineTo(Qp.x,Qp.y);

    ctx.stroke();

    ctx.strokeStyle = "FF9900";
    ctx.lineWidth = 1;

  ctx.strokeStyle = "red";
    ctx.beginPath();
    ctx.arc(A.x, A.y, 15, Math.PI,Math.PI+ra);
    ctx.stroke();

  ctx.strokeStyle = "blue";
    ctx.beginPath();
    ctx.arc(B.x, B.y, 15, Math.PI+ra,Math.PI-rq);
    ctx.stroke();

  ctx.strokeStyle = "green";
    ctx.beginPath();
    ctx.arc(Q.x, Q.y, 15, Math.PI-rq,Math.PI);
    ctx.stroke();

    ctx.font = "15px Verdana";
    ctx.fillStyle = "red";
    ctx.fillText(a+"º", A.x-40, A.y-20);
    ctx.fillStyle = "blue";
    ctx.fillText(b+"º", B.x+20, B.y+10);
    ctx.fillStyle = "green";
    ctx.fillText("q", Q.x-20, Q.y+20);
}
function toRadians(angle) {
    return angle * (Math.PI / 180);
}
