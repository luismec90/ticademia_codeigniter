var gs,v,xd,x2,gx0,ts,vl,vh,x,l,x1,lx0,z;

$(function() {
    try{
        API = getAPI();
       API.LMSInitialize("");
    }catch(e){
        console.log(e);
    }

    gs= getRandom(1,50)*10;
    v= getRandomFrom([13.2,13.8]);
    xd= getRandomFrom([0.1,0.2,0.3]);
    x2= xd*gs;
    gx0= 0.26*xd;
    ts= 1.1*gs;
    vl= v;
    vh= getRandomFrom([66,110,115,138,220,230,500]);
    x= getRandom(6,15);
    l= getRandom(1,100)*5;
    x1= getRandomFrom([0.3,0.4,0.5,0.6]);
    lx0= 3*x1;
    z= getRandomFrom([80,90,100,110,120]);

    var correctAnswer = (x*vl)/(100*ts);
    var missConception1 = (x*ts)/(100*vl);
	var missConception2 = (x*vl)/(ts);
    draw();

    $("#verificar").click(function() {
        var error = 0.0001;
        var valor = $("#answer").val().trim();
        if (valor != "") {
            $("#correcto").addClass("hide");
            $("#feedback").addClass("hide");
            var calificacion = 0;
            var feedback = "";
            valor = parseFloat(valor);

            if(Math.abs(valor-correctAnswer)<=error){
                calificacion = 1.0;
                $("#correcto").html("Calificación: <b>" + calificacion + "</b>").removeClass("hide");
            }else if(Math.abs(valor-missConception1)<=error){
                calificacion = 0.5;
                feedback = "missConception1";
                $("#feedback").html("Calificación: <b>" + calificacion + "</b> <br> Recuerda que para el cambio de base se divide la nueva potencia de base sobre la potencia anterior. (Ver tema cambios de base en sistema pu)").removeClass("hide");
            }else if(Math.abs(valor-missConception2)<=error){
                calificacion = 0.5;
                feedback = "missConception2";
                $("#feedback").html("Calificación: <b>" + calificacion + "</b> <br> Recuerda dividir por 100 la impedancia del transformador pues este valor está en porcentaje").removeClass("hide");
            }else{
                calificacion = 0.0;
                $("#feedback").html("Calificación: <b>" + calificacion + "</b> <br>...").removeClass("hide");
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
	ray();
    $('.mvar[value=gs]').html(round(gs));
    $('.mvar[value=v]').html(round(v));
    $('.mvar[value=xd]').html(round(xd));
    $('.mvar[value=x2]').html(round(x2));
    $('.mvar[value=gx0]').html(round(gx0));
    $('.mvar[value=ts]').html(round(ts));
    $('.mvar[value=vl]').html(round(vl));
    $('.mvar[value=vh]').html(round(vh));
    $('.mvar[value=x]').html(round(x));
    $('.mvar[value=l]').html(round(l));
    $('.mvar[value=x1]').html(round(x1));
    $('.mvar[value=lx0]').html(round(lx0));
    $('.mvar[value=z]').html(round(z));
}
function round(val){
    return Math.round(val*1000)/1000;
}
function ray(){
    $("#ray").delay(getRandom(50,1000))
        .fadeOut(50)
        .delay(getRandom(50,200))
        .fadeIn(50,ray);
}
function toRadians(angle) {
    return angle * (Math.PI / 180);
}
