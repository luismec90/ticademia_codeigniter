var a,b,r;

$(function() {
	try{
		API = getAPI();
		API.LMSInitialize("");
	}catch(e){
		console.log(e);
	}

    a = getRandom(2,4);
    b = getRandom(5,7);
    r = getRandom(2,4)
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
	var correct = 0;
	var answers = [(a*a*a)+'X<sup>3</sup> - '+(3*a*a*b)+'X<sup>2</sup>Y<sup>'+r+'</sup> + '+(3*a*b*b)+'XY<sup>'+(2*r)+'</sup> - '+(b*b*b)+'Y<sup>'+(3*r)+'</sup>',
                    (a*a)+'X<sup>3</sup> - '+(3*a*a*b)+'X<sup>2</sup>Y<sup>'+r+'</sup> + '+(3*a*b*b)+'XY<sup>'+(2*r)+'</sup> - '+(b*b*b)+'Y<sup>'+(3*r)+'</sup>',
                    (a)+'X<sup>3</sup> - '+(a*b*b)+'XY<sup>'+r+'</sup> - '+(b*b*b)+'Y<sup>'+(2*r)+'</sup>',
                    (a*a*a)+'X<sup>3</sup> - '+(3*a*a*b)+'X<sup>2</sup>Y<sup>'+r+'</sup> + '+(3*a*b)+'XY<sup>'+(2*r)+'</sup> - '+(b*b*b)+'Y<sup>'+(3*r)+'</sup>',
                    (a*a)+'X<sup>3</sup> - '+(a*a*b)+'XY<sup>'+r+'</sup> - '+(b*b*b)+'Y<sup>'+(3*r)+'</sup>'];
	var is = [0,1,2,3,4];
	shuffleArray(is);
	var i = 0;
	while(i<5){
		$("#label"+(i+1)).html(answers[is[i]]);
		if(is[i]==0)correct=i+1;
		i++;
	}
	
    $('.mvar[value=a]').html(a);
    $('.mvar[value=b]').html(b);
    $('.mvar[value=r]').html(r);
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