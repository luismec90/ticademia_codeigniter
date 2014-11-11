var a,h,k;

$(function() {
	try{
		API = getAPI();
		API.LMSInitialize("");
	}catch(e){
		console.log(e);
	}

    a = getRandom(2,8);
    h = getRandom(1,8)*getRandomFrom([-1,1]);
    k = getRandom(1,8)*getRandomFrom([-1,1]);
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

    var correctIndex = 0;

    var mk = (k>=0?"- ":"+ ")+Math.abs(k);
    var mh = (h>=0?"- ":"+ ")+Math.abs(h);
    var pk = (k<0?"- ":"+ ")+Math.abs(k);

	var answers = [
                    "f: ["+k+", +∞) → (-∞, "+h+"] <br><br> donde f<sup>-1</sup>(x) = <span class='fraccion'><span>"+(a*h)+" - <span class='raiz'>&radic;</span><span class='radicando'>x "+mk+"</span></span><span>"+a+"</span></span>",
                    "f: ["+k+", +∞) → (-∞, "+h+"] <br><br> donde f<sup>-1</sup>(x) = "+h+" - <span class='raiz'>&radic;</span><span class='radicando'>x "+mk+"</span>",
                    "f: ["+k+", +∞) → (-∞, "+h+"] <br><br> donde f<sup>-1</sup>(x) = <span class='fraccion'><span>"+(a*h)+" + <span class='raiz'>&radic;</span><span class='radicando'>x "+mk+"</span></span><span>"+a+"</span></span>",
                    "f: ["+k+", +∞) → (-∞, "+h+"] <br><br> donde f<sup>-1</sup>(x) = "+h+" + <span class='raiz'>&radic;</span><span class='radicando'>x "+mk+"</span>"
                    ];
	var is = [0,1,2,3];
	shuffleArray(is);
	var i = 0;
    var correct = 0;
	while(i<4){
		$("#label"+(i+1)).html(answers[is[i]]);
		if(is[i]==correctIndex)correct=i+1;
		i++;
	}
	
    $('.mvar[value=a2]').html(a*a);
    $('.mvar[value=h]').html(h);
    $('.mvar[value=mh]').html(mh);
    $('.mvar[value=k]').html(k);
    $('.mvar[value=pk]').html(pk);
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