$(function() {
	try{
		API = getAPI();
		API.LMSInitialize("");
	}catch(e){
		console.log(e);
	}

    var labels = ["Lado-Ángulo-Lado","Ángulo-Lado-Ángulo","Lado-Lado-Lado"];
    var correctAnswer = shuffleArray([0,1,2]);
    //console.log(correctAnswer + " " + missConception1);
    draw(labels,correctAnswer);

    $("#verificar").click(function() {
        var valor1 = $("#answer1").val().trim(); valor1 = ((valor1.split(",")).length == 2) ? valor1.replace(",", ".") : valor1;
        var valor2 = $("#answer2").val().trim(); valor2 = ((valor2.split(",")).length == 2) ? valor2.replace(",", ".") : valor2;
        var valor3 = $("#answer3").val().trim(); valor3 = ((valor3.split(",")).length == 2) ? valor3.replace(",", ".") : valor3;
        console.log(correctAnswer[valor1]);
        if (valor1 != "-1" && valor2 != "-1" && valor3 != "-1") {
            $("#correcto").addClass("hide");
            $("#feedback").addClass("hide");
            var calificacion = 0;
            var feedback = "";
            if(0==correctAnswer[valor1] && 1==correctAnswer[valor2] && 2==correctAnswer[valor3]){
                    calificacion = 1.0;
                    $("#correcto").html("Calificación: <b>" + calificacion + "</b>").removeClass("hide");
            }else{
                    calificacion = 0.0;
                    $("#feedback").html("Calificación: <b>" + calificacion + "</b> <br> ...").removeClass("hide");
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
function draw(labels,answer){
	$("#answer1,#answer2,#answer3").html("<option value='-1'>---</option><option value='0'>"+labels[answer[0]]+"</option><option value='1'>"+labels[answer[1]]+"</option><option value='2'>"+labels[answer[2]]+"</option>");
}
function shuffleArray(array) {
    for (var i = array.length - 1; i > 0; i--) {
        var j = Math.floor(Math.random() * (i + 1));
        var temp = array[i];
        array[i] = array[j];
        array[j] = temp;
    }
    return array;
}