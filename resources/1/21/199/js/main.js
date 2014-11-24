
$(function() {
	try{
		API = getAPI();
		API.LMSInitialize("");
	}catch(e){
		console.log(e);
	}

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

    var correctIndex = 0;

	var answers = [
                    "<span class='raiz'>&radic;</span><span class='radicando'>sen<sup>2</sup>(θ)</span> = sen(θ)<br> "+
                    "<span class='raiz'>&radic;</span><span class='radicando'>cos<sup>2</sup>(θ)</span> = -cos(θ)<br> "+
                    "<span class='raiz'>&radic;</span><span class='radicando'>tan<sup>2</sup>(θ)</span> = -tan(θ) ",

                    "sen(x) = sen(xº)<br> "+
                    "cos(x) = cos(xº)<br> "+
                    "tan(x) = tan(xº) ",

                    "sen(y) = sen(yº)<br> "+
                    "cos(y) = cos(yº)<br> "+
                    "tan(y) = tan(yº) ",

                    "sen(yº) = sen(<span class='fraccion'><span>360º x</span><span>π</span></span>)<br> "+
                    "cos(yº) = cos(<span class='fraccion'><span>360º x</span><span>π</span></span>)<br> "+
                    "tan(yº) = tan(<span class='fraccion'><span>360º x</span><span>π</span></span>) ",

                    "sen(y) = sen(xº)<br> "+
                    "cos(y) = cos(xº)<br> "+
                    "tan(y) = tan(xº) ",

                    "<span class='raiz'>&radic;</span><span class='radicando'>sen<sup>2</sup>(θ)</span> = sen(θ)<br> "+
                    "<span class='raiz'>&radic;</span><span class='radicando'>cos<sup>2</sup>(θ)</span> = -cos(θ)<br> "+
                    "<span class='raiz'>&radic;</span><span class='radicando'>tan<sup>2</sup>(θ)</span> = tan(θ) "
                    ];
	var is = [0,1,2,3,4,5];
	shuffleArray(is);
	var i = 0;
    var correct = 0;
	while(i<6){
		$("#label"+(i+1)).html(answers[is[i]]);
		if(is[i]==correctIndex)correct=i+1;
		i++;
	}
	
    //$('.mvar[value=a]').html(a);
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