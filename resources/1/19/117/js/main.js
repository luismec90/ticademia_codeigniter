var a,b,c,m;

$(function() {
	try{
		API = getAPI();
		API.LMSInitialize("");
	}catch(e){
		console.log(e);
	}

    a = getRandom(2,10)*getRandomFrom([-1,1]);
    b = getRandom(2,10)*getRandomFrom([-1,1]);
    c = getRandom(2,10)*getRandomFrom([-1,1]);
    m = getRandom(3,10);

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
    var d = b*b-4*a*(c-m/(m+1));
    var c1,c2,c3;
    if(d>0){
        c1='2';
        c2='1';
        c3='0';
    }else if(d<0){
        c1='0';
        c2='1';
        c3='2';
    }else{
        c1='1';
        c2='0';
        c3='2';
    }
	var answers = [c1,
                    c2,
                    c3,
                    '3',
                    '4'];
	var is = [0,1,2,3,4];
	shuffleArray(is);
	var i = 0;
	while(i<5){
		$("#label"+(i+1)).html(answers[is[i]]);
		if(is[i]==0)correct=i+1;
		i++;
	}
	
    $('.mvar[value=e1]').html(a);
    $('.mvar[value=e2]').html(b);
    $('.mvar[value=e3]').html(c);
    $('.mvar[value=e4]').html(m);
    $('.mvar[value=e5]').html(m+1);
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