var k,m,n;

$(function() {
	try{
		API = getAPI();
		API.LMSInitialize("");
	}catch(e){
		console.log(e);
	}

    k = getRandom(32,39);
    m = getRandom(42,54);
    n = getRandom(57,61);

    var senb = Math.sin(n*Math.PI/180);

    var correctAnswer3 = Math.asin(k*senb/m)*180/Math.PI;
    var correctAnswer1 = Math.abs(m*Math.sin(correctAnswer3)/senb);
    var correctAnswer2 = correctAnswer3;
    
    //var missConception1 = n;
    //console.log(correctAnswer1 + " " + correctAnswer2 + " " + correctAnswer3);
    draw();

    $("#verificar").click(function() {
        var valor1 = $("#answer1").val().trim();
        var valor2 = $("#answer2").val().trim();
        var valor3 = $("#answer3").val().trim();
        if (valor1 != "" && valor2 != "" && valor3 != "") {
            $("#correcto").addClass("hide");
            $("#feedback").addClass("hide");
            var calificacion = 0;
            var feedback = "";
            valor1 = parseFloat(valor1);
            valor2 = parseFloat(valor2);
            valor3 = parseFloat(valor3);
			
			if(decimalComparison(valor1, correctAnswer1, 2) &&
                decimalComparison(valor2, correctAnswer2, 2) &&
                decimalComparison(valor3, correctAnswer3, 2)){
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
    $('.mvar[value=k]').html(k);
    $('.mvar[value=m]').html(m);
    $('.mvar[value=n]').html(n);
}
