var m,k;

$(function() {
	try{
		API = getAPI();
		API.LMSInitialize("");
	}catch(e){
		console.log(e);
	}

    m=getRandom(2,12);
    k=getRandom(1,10)*getRandomFrom([-1,1]);

    var correctAnswer1 = -m;
    var correctAnswer2 = m+1;
    var correctAnswer3 = "]";
    var correctAnswer4 = "(";
    var correctAnswer5 = m+3;
    var correctAnswer6 = m+2;
    //var missConception1 = n;
    //console.log(correctAnswer1);
    //console.log(correctAnswer1 + " " + correctAnswer2);
    draw();

    $("#verificar").click(function() {
        var valor1 = $("#answer1").val().trim();
        var valor2 = $("#answer2").val().trim();
        var valor3 = $("#answer3").val().trim();
        var valor4 = $("#answer4").val().trim();
        var valor5 = $("#answer5").val().trim();
        var valor6 = $("#answer6").val().trim();
        if (valor1 != "" && valor2 != "" && valor3 != "" && valor4 != "" && valor5 != "" && valor6 != "") {
            $("#correcto").addClass("hide");
            $("#feedback").addClass("hide");
            var calificacion = 0;
            var feedback = "";
            valor1 = parseFloat(valor1);
            valor2 = parseFloat(valor2);
            valor5 = parseFloat(valor5);
            valor6 = parseFloat(valor6);
			
			if(valor1 == correctAnswer1 &&
                valor2 == correctAnswer2 &&
                valor3 == correctAnswer3 &&
                valor4 == correctAnswer4 &&
                valor5 == correctAnswer5 &&
                valor6 == correctAnswer6){
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
function getRandomFrom(vals){
	return vals[getRandom(0,vals.length-1)];
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
function decimalComparison(v1,v2,d){
    d = Math.pow(10,d);
    v1 = Math.round(v1*d);
    v2 = Math.round(v2*d);
    return v1==v2;
}
function draw(){
    $('.mvar[value=e1]').html((m+1)+k*(m+2));
    $('.mvar[value=e2]').html(m-k*(m+3));
    $('.mvar[value=e3]').html(m+2);
    $('.mvar[value=e4]').html(m+3);
    $('.mvar[value=e5]').html(k);
}
