var m,k,j;

$(function() {
	try{
		API = getAPI();
		API.LMSInitialize("");
	}catch(e){
		console.log(e);
	}

    m=getRandom(2,10);
    k=getRandom(2,10);
    j=getRandom(1,20)*getRandomFrom([-1,1]);

    var correctAnswer1 = "[";
    var correctAnswer2 = m*k;
    var correctAnswer3 = (m+1)*k;
    var correctAnswer4 = ")";
    //var missConception1 = n;
    //console.log(correctAnswer1);
    //console.log(correctAnswer1 + " " + correctAnswer2);
    draw();

    $("#verificar").click(function() {
        var valor1 = $("#answer1").val().trim();
        var valor2 = $("#answer2").val().trim();
        var valor3 = $("#answer3").val().trim();
        var valor4 = $("#answer4").val().trim();
        if (valor1 != "" && valor2 != "" && valor3 != "" && valor4 != "") {
            $("#correcto").addClass("hide");
            $("#feedback").addClass("hide");
            var calificacion = 0;
            var feedback = "";
            valor2 = parseFloat(valor2);
            valor3 = parseFloat(valor3);
			
			if(valor1 == correctAnswer1 &&
                valor2 == correctAnswer2 &&
                valor3 == correctAnswer3 &&
                valor4 == correctAnswer4){
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
    $('.mvar[value=e1]').html(m*(k+1)+j);
    $('.mvar[value=e2]').html('<span class="fraccion"><span>'+(k+1)+'</span><span>'+k+'</span></span>');
    $('.mvar[value=e3]').html(j);
    $('.mvar[value=e4]').html((m+1)*(k+1)+j);
}
