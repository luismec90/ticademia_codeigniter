var n,r;

$(function() {
	try{
		API = getAPI();
		API.LMSInitialize("");
	}catch(e){
		console.log(e);
	}

    n = getRandom(12,17);
	r = getRandom(2,4);

	var correctAnswer = Array(2);
    correctAnswer[0] = fact(n)/(fact(r)*fact(n-r));
    correctAnswer[1] = n-r;
    /*var missConception1 = fn/fr;
	var missConception2 = fn/fnr;
	var missConception3 = fr;*/
    //console.log(correctAnswer + " " + missConception1);
    draw();

    $("#verificar").click(function() {
		var valor = Array(3);
        valor[0] = $("#answer1").val().trim();
        valor[1] = $("#answer2").val().trim();
		
		var valid = true;
		var j = 0;
		while(j < 2){
			if(valor[j]=="")valid = false;
			j++;
		}
        if (valid) {
            $("#correcto").addClass("hide");
            $("#feedback").addClass("hide");
            var calificacion = 1.0;
            var feedback = "";
			var correcto = true;
			var i = 0;
			while(i < 2){
			console.log(correctAnswer[i]);
				if(correctAnswer[i] != parseFloat(valor[i])){
					calificacion-=0.5;
					correcto = false;
				}
				i++;
			}
			calificacion = Math.round(calificacion*100)/100;
           
			if(correcto){
                $("#correcto").html("Calificación: <b>" + calificacion + "</b>").removeClass("hide");
			}else{
                $("#feedback").html("Calificación: <b>" + calificacion + "</b> <br> ...").removeClass("hide");
			}
           /* switch (valor) {
                case correctAnswer:
                    calificacion = 1.0;
                    $("#correcto").html("Calificación: <b>" + calificacion + "</b>").removeClass("hide");
                    break;
                case missConception1:
                    calificacion = 0.5;
                    feedback = "n!/r!";
                    $("#feedback").html("Calificación: <b>" + calificacion + "</b> <br> ...").removeClass("hide");
                    break;
                default:
                    calificacion = 0.0;
                    $("#feedback").html("Calificación: <b>" + calificacion + "</b> <br> ...").removeClass("hide");
                    break;
            }*/
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
function fact(n){
	if(n==1)return 1;
	return n*fact(n-1);
}
function draw(){
	$('.mvar[value=n]').html(n);
	$('.mvar[value=r]').html(r);
	$('.mvar[value=2r]').html(2*r);
}