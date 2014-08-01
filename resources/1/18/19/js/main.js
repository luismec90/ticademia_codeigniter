var a,b;

$(function() {
	try{
		API = getAPI();
		API.LMSInitialize("");
	}catch(e){
		console.log(e);
	}

    a = getRandom(-9,9)+getRandom(1,10)/10;
	do{
		b = getRandom(-9,9)+getRandom(1,10)/10;
	}while(a==b)

    var correctAnswer = Math.abs(a-b);
    //var missConception1 = n;
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
			
			if(Math.abs(valor - correctAnswer) < 0.000001){
				calificacion = 1.0;
				$("#correcto").html("Calificación: <b>" + calificacion + "</b>").removeClass("hide");
            }else{
				calificacion = 0.0;
				$("#feedback").html("Calificación: <b>" + calificacion + "</b> <br> ...").removeClass("hide");
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
function draw(){
	$('.mvar[value=a]').html(a);
	$('.mvar[value=b]').html(b);
}
