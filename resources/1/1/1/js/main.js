var n;

$(function() {
	try{
		API = getAPI();
		API.LMSInitialize("");
	}catch(e){
		console.log(e);
	}

    n = getRandom(3,8);

	var fact = [2, 6, 24, 120, 720, 5040, 40320];
    var correctAnswer = fact[n-2];
    var missConception1 = n;
	var missConception2 = Math.pow(n,n);
	var missConception3 = fact[n-3];
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
                case missConception1:
                    calificacion = 0.5;
                    feedback = "n";
                    $("#feedback").html("Calificación: <b>" + calificacion + "</b> <br> ...").removeClass("hide");
                    break;
				case missConception2:
                    calificacion = 0.5;
                    feedback = "n^n";
                    $("#feedback").html("Calificación: <b>" + calificacion + "</b> <br> ...").removeClass("hide");
                    break;
				case missConception3:
                    calificacion = 0.5;
                    feedback = "(n-1)!";
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
            API.LMSFinish("feedback", feedback);
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
	$('.mvar[value=n]').html(n);
}
