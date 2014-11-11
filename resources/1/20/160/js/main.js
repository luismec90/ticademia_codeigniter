var k,h,p,a,d,b,c;

$(function() {
	try{
		API = getAPI();
		API.LMSInitialize("");
	}catch(e){
		console.log(e);
	}

    k = getRandom(1,5);
    h = getRandom(1,5);
    p = getRandom(1,5);
    a = getRandom(1,3);
    d = getRandom(2,4);
    b = getRandom(3,5);
    c = getRandom(5,7);

    var correctAnswers = buildAnswers();
    //var missConception1 = n;
    //console.log(correctAnswer1);
    //console.log(correctAnswer1 + " " + correctAnswer2);
    draw();

    $("#verificar").click(function() {
        var valores = [
                    $("#answer1").is(":checked"),
                    $("#answer2").is(":checked"),
                    $("#answer3").is(":checked"),
                    $("#answer4").is(":checked"),
                    $("#answer5").is(":checked"),
                    $("#answer6").is(":checked")]

        if (true) {
            $("#correcto").addClass("hide");
            $("#feedback").addClass("hide");
            var calificacion = 0;
            var feedback = "";
			
            var correcto = true;
            for(var i = 0;i<correctAnswers.length;i++){
                if(correctAnswers[i]!=valores[i]){
                    correcto = false;
                    break;
                }
            }

			if(correcto){
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
}

function buildAnswers(){
    var values = [
                    false,
                    true,
                    false,
                    false,
                    true,
                    true];

    var answers = [
                    "f(x) = "+k+" - x<sup>2</sup>, x ∈ R",
                    "f(x) = <span class='fraccion'><span>"+a+"x + "+b+"</span><span>"+c+"x + "+d+"</span></span> , x ∈ R \\ {"+(-d)+"/"+c+"}",
                    "f(x) = <span class='absolute'>x - "+h+"</span> , x ∈ R",
                    "f(x) = (x + "+p+")<sup>2</sup> , x ∈ R",
                    "f(x) = "+p+"x<sup>2</sup> , x ∈ [0,∞)",
                    "f(x) = "+k+"x<sup>3</sup> , x ∈ R"];

    var indexes = shuffleArray([0,1,2,3,4,5]);
    var correctAnswers = [];
    for(var i = 0;i<indexes.length;i++){
        correctAnswers[i]=values[indexes[i]];
        $('#label'+(i+1)).html(answers[indexes[i]]);
    }
    return correctAnswers;
}
