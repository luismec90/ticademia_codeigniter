var m,a,b,c;

$(function() {
	try{
		API = getAPI();
		API.LMSInitialize("");
	}catch(e){
		console.log(e);
	}

    m = getRandom(1,5)*getRandomFrom([1,-1]);
    a = getRandom(3,6)*getRandomFrom([1,-1]);
    b = getRandom(1,5)*getRandomFrom([1,-1]);
    c = getRandomFrom([4,6,8])*getRandomFrom([1,-1]);
    //console.log(correctAnswer + " " + missConception1);
    var correctAnswer = draw();

    $("#verificar").click(function() {
        var valor = $("input[name=answer]:checked").val().trim();
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
                    $("#feedback").html("Calificación: <b>" + calificacion + "</b> <br> ...").removeClass("hide");
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
function getRandomFrom(vals){
	return vals[getRandom(0,vals.length-1)];
}
function draw(){
    var correctIndex = (a==m+b && c==2*m+b)?2:3;
	var answers = ["Sí, por la prueba de la recta horizontal",
                    "No, por la prueba de la recta horizontal",
                    "Sí, por la prueba de la recta vertical",
                    "No, por la prueba de la recta vertical"];
	var is = [0,1,2,3];
	shuffleArray(is);
	var i = 0;
    var correct = 0;
	while(i<4){
		$("#label"+(i+1)).html(answers[is[i]]);
		if(is[i]==correctIndex)correct=i+1;
		i++;
	}
	
    $('.mvar[value=m]').html(m);
    $('.mvar[value=a]').html(a);
    $('.mvar[value=b]').html((b>=0?"+ ":"- ")+Math.abs(b));
	$('.mvar[value=c]').html(c);
	return correct;
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