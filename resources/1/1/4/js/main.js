var a,b,r;

$(function() {
	try{
		API = getAPI();
		API.LMSInitialize("");
	}catch(e){
		console.log(e);
	}

    a = getRandom(2,4);
	do{
		b = getRandom(2,4);
	}while(b==a);
	r = getRandom(2,4);

	var correctAnswer = Array(9);
    correctAnswer[0] = a*a*a;
    correctAnswer[1] = 3;
    correctAnswer[2] = 3*a*a*b;
    correctAnswer[3] = 2;
    correctAnswer[4] = r;
    correctAnswer[5] = 3*a*b*b;
    correctAnswer[6] = 2*r;
    correctAnswer[7] = b*b*b;
    correctAnswer[8] = 3*r;
    /*var missConception1 = fn/fr;
	var missConception2 = fn/fnr;
	var missConception3 = fr;*/
    console.log(correctAnswer + " " );
    draw();

    $("#verificar").click(function() {
		var valor = Array(9);
        valor[0] = $("#answer1").val().trim();
        valor[1] = $("#answer2").val().trim();
        valor[2] = $("#answer3").val().trim();
        valor[3] = $("#answer4").val().trim();
        valor[4] = $("#answer5").val().trim();
        valor[5] = $("#answer6").val().trim();
        valor[6] = $("#answer7").val().trim();
        valor[7] = $("#answer8").val().trim();
        valor[8] = $("#answer9").val().trim();
		
		var valid = true;
		var j = 0;
		while(j < 9){
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
			while(i < 9){
				if(correctAnswer[i] != parseFloat(valor[i])){
					calificacion-=0.111;
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
	$('.mvar[value=a]').html(a);
	$('.mvar[value=b]').html(b);
	$('.mvar[value=r]').html(r);
}