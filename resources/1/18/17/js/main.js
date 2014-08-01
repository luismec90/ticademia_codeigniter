var a,n,r;

$(function() {
	try{
		API = getAPI();
		API.LMSInitialize("");
	}catch(e){
		console.log(e);
	}

	a = getRandom(2,3);
    n = getRandom(17,20);
	r = getRandom(3,5);

	var fn = fact(n);
	var fr = fact(r);
	var fnr = fact(n-r);
	
	var correctAnswer = Math.pow(-1,r)*fn*a*a/(fr*fnr);
    var missConception1 = -correctAnswer;
	var missConception2 = Math.pow(-1,r+1)*a*a;
	var missConception3 = Math.pow(-1,r)*fn/(fr*fnr*Math.pow(a,n-r-2));
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
                    feedback = "(-1)^(r+1) (n!*a^2)/(r!*(n-r)!)";
                    $("#feedback").html("Calificación: <b>" + calificacion + "</b> <br> ...").removeClass("hide");
                    break;
				case missConception2:
                    calificacion = 0.5;
                    feedback = "(-1)^(r+1) a^2";
                    $("#feedback").html("Calificación: <b>" + calificacion + "</b> <br> ...").removeClass("hide");
                    break;
				case missConception3:
                    calificacion = 0.5;
                    feedback = "(-1)^r n!/(r!*(n-r)!*a^(n-r-2))";
                    $("#feedback").html("Calificación: <b>" + calificacion + "</b> <br> ...").removeClass("hide");
                    break;
                default:
                    calificacion = 0.0;
                    $("#feedback").html("Calificación: <b>" + calificacion + "</b> <br> ...").removeClass("hide");
                    break;
            }
            $(this).attr("disabled", true);
            /* $("#modal").modal({
                backdrop: "static",
                keyboard: "false"
            });

            */ API.closeQuestion();  if (typeof API.calificar == 'function') {
                API.calificar(calificacion, feedback);
            }
            API.LMSSetValue("cmi.core.score.raw", calificacion);
            API.LMSFinish("feedback", feedback); API.notifyDaemon(calificacion);
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
function fact(n){
	if(n==1)return 1;
	return n*fact(n-1);
}
function draw(){
	$('.mvar[value=n]').html(n);
	$('.mvar[value=r]').html(r);
	$('.mvar[value=a]').html(a);
	$('.mvar[value=nr2]').html(n-r-2);
}