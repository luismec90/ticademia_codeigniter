var conn;
var usuarioRetadorGlobal;
var statusSocket;
var cantidadEvalucaiones;
var posEv;
$(function() {


    if (idUsuarioGlobal != -1 && rolGlobal == 1) {
        socket();

        $("#arena,#arena2").click(function() {// Retar a alguien
            $(".modal").modal('hide');
            if (statusSocket == "on") {
                $("#modal-arena").modal({
                    keyboard: false,
                    backdrop: "static"
                });
                var time = 10;
                $("#cuenta-regresiva").html(time--);
                var t = setInterval(function() {
                    if (time == 0) {
                        clearTimeout(t);
                        if ($("#modal-arena").is(":visible")) {
//                        $(".modal").modal('hide');
                        }
                    }
                    $("#cuenta-regresiva").html(time--);

                }, 1000);
                var data = {
                    tipo: 'retar',
                    id_curso: idCursoGlobal,
                    id_usuario: idUsuarioGlobal,
                    nombre_usuario: nombreUsuarioGlobal
                };
                conn.send(JSON.stringify(data));
            } else {
                $("#custom-modal-title").html("Información");
                //$("#body-custom-modal").html("No hay conexión con el servidor, inténtelo más tarde.");
                $("#body-custom-modal").html("Los duelos serán habilitados durante la segunda semana del curso.");
                $("#custom-modal").modal();
            }
        });

        $("#aceptar-modal-retado").click(function() {// Aceptar el reto
            var data = {
                tipo: 'acpetar_reto',
                id_curso: idCursoGlobal,
                id_usuario: idUsuarioGlobal,
                nombre_usuario: nombreUsuarioGlobal,
                usuario_retador: usuarioRetadorGlobal
            };
            conn.send(JSON.stringify(data));
        });

        $("#rechazar-modal-retado").click(function() {
            var data = {
                tipo: 'rechazar_reto',
                id_curso: idCursoGlobal,
                id_usuario: idUsuarioGlobal,
                nombre_usuario: nombreUsuarioGlobal,
                usuario_retador: usuarioRetadorGlobal
            };
            conn.send(JSON.stringify(data));
        });

        $("#enviar-respuesta-reto").click(function() {

        });
    }

});
function socket() {
    conn = new WebSocket('ws://ticademia.medellin.unal.edu.co:8080');
    conn.onopen = function(e) {
        statusSocket = "on";
        console.log("Connection established!");
        var data = {
            tipo: 'inicio',
            id_curso: idCursoGlobal,
            id_usuario: idUsuarioGlobal,
            nombre_usuario: nombreUsuarioGlobal
        };
        conn.send(JSON.stringify(data));
    };
    conn.onmessage = function(e) {
        if (e.data != []) {
            var data = JSON.parse(e.data);
            switch (data.tipo) {

                case "retado":// Notificacion de que ha sido retado
                    $(".modal").modal('hide');
                    $.each(data.datos, function(id_usuario, nombre_usuario) {
                        usuarioRetadorGlobal = id_usuario;
                        $("#content-modal-retado").html("El usuario " + nombre_usuario + " te ha retado a un duelo, deseas aceptar?");
                        $("#retado").modal();
                    });
                    var time = 10;
                    $("#cuenta-regresiva-retado").html(time--);
                    var t = setInterval(function() {
                        if (time == 0) {
                            clearTimeout(t);
                            if ($("#retado").is(":visible")) {
                                $(".modal").modal('hide');
                                var data = {
                                    tipo: 'rechazar_reto',
                                    id_curso: idCursoGlobal,
                                    id_usuario: idUsuarioGlobal,
                                    nombre_usuario: nombreUsuarioGlobal,
                                    usuario_retador: usuarioRetadorGlobal
                                };
                                conn.send(JSON.stringify(data));
                            }
                        }
                        $("#cuenta-regresiva-retado").html(time--);

                    }, 1000);
                    break;

                case "reto_rechazado":// El usuario retado rechazo el reto
                    $(".modal").modal('hide');
                    cerrarReto();
                    $.each(data.datos, function(id_usuario, nombre_usuario) {
                        $("#nombre-usuario-reto-rechazado").html(nombre_usuario);
                        $("#reto-rechazado").modal();
                    });
                    break;

                case "reto_aceptado"://Notificacion de iniciar el duelo, este mensaje le llega tanto al retado como al retador

                    var datos = data.datos;
                    $(".modal").modal('hide');
                    console.log(datos);
                    if (idUsuarioGlobal == datos.retador["id_usuario"]) {
                        var imagenOponente = datos.retado["avatar"];
                        var nombreOponente = datos.retado["nombre"];
                    } else {
                        var imagenOponente = datos.retador["avatar"];
                        var nombreOponente = datos.retador["nombre"];
                    }
                    $("#imagen-oponente").attr("src", base_url + "assets/img/avatares/thumbnails/" + imagenOponente);
                    $("#nombre-oponente").html(nombreOponente);
                    $("#modulo-seleccionado").html(datos.posMod);
                    $("#pregunta-seleccionada").html(datos.posEv);
                    $("#monto-pregunta").html(datos.monto);

                    cantidadEvalucaiones = datos.cantidadEvaluaciones;
                    posEv = datos.posEv;

                    var step1 = "";
                    for (var i = 0; i < 19; i++) {
                        if (i == 13) {
                            step1 += "<div class='-1'><img width='100' class='img-circle' src='" + base_url + "assets/img/avatares/thumbnails/" + imagenOponente + "' alt='' /></div>";
                        } else {
                            step1 += " <div class='" + i + "'><img width='100' class='img-circle' src='" + base_url + "assets/img/avatares/thumbnails/" + datos.oponentesDummies[i] + "' alt='' /></div>";
                        }
                    }
                    $("#slideshow").html(step1);

                    var step3 = "";
                    for (var i = 1; i <= datos.cantidadEvaluaciones; i++) {
                        step3 += "<div data-pos='" + i + "'><img width='100'  src='http://placehold.it/100x100/35bdf6/ffffff&text=" + i + "' alt='' /></div>";
                    }
                    $("#slideshow-evaluaciones").html(step3);

                    $("#coverDisplay").css({
                        "opacity": "0",
                        "width": "0",
                        "height": "0"
                    });
                    $("#modal-step-1").modal({
                        keyboard: false,
                        backdrop: "static"
                    });
                    seleccionOponente();


                    /*  $(".modal").modal('hide');
                     $.each(data.datos, function(reto, ruta) {
                     evaluacionOReto = "reto";
                     $("#contenedor-frame iframe").attr("src", base_url + ruta);
                     $("#coverDisplay").css({
                     "opacity": "1",
                     "width": "100%",
                     "height": "100%"
                     });
                     $("#botonCerrarFrame").addClass("hide");
                     $("#contenedor-frame").removeClass("hide");
                     fechaInicioReto = date_to_server_date(new Date());
                     });*/
                    break;

                case "desconectado_antes":
                    $(".modal").modal('hide');
                    cerrarReto();
                    $.each(data.datos, function(id_usuario, nombre_usuario) {
                        $(".modal").modal('hide');
                        $("#modal-desconectado-antes").modal();
                    });
                    break;

                case "desconectado":
                    $(".modal").modal('hide');
                    cerrarReto();
                    $.each(data.datos, function(id_usuario, nombre_usuario) {
                        $(".modal").modal('hide');
                        $("#nombre-usuario-desconectado").html(nombre_usuario);
                        $("#ganador-reto-por-w").modal();
                    });
                    break;

                case "empate":
                    $(".modal").modal('hide');
                    cerrarReto();
                    $.each(data.datos, function(id_usuario, nombre_usuario) {
                        $(".modal").modal('hide');
                        $("#custom-modal-title").html("Empate");
                        $("#body-custom-modal").html("Se ha producido un empate");
                        $("#custom-modal").modal();
                    });
                    break;

                case "ganador":
                    $(".modal").modal('hide');
                    cerrarReto();
                    $.each(data.datos, function(id_usuario, nombre_usuario) {
                        $(".modal").modal('hide');
                        $("#custom-modal-title").html("Ganador");
                        $("#body-custom-modal").html("El usuario " + nombre_usuario + " ha  ganado el reto");
                        $("#custom-modal").modal();
                    });
                    break;

                case "no_hay_oponentes":// Notificacion de que ha sido retado
                    $(".modal").modal('hide');
                    $.each(data.datos, function(id_usuario, nombre_usuario) {
                        $(".modal").modal('hide');
                        $("#custom-modal-title").html("Reto");
                        $("#body-custom-modal").html("No hay oponentes");
                        $("#custom-modal").modal();
                    });
                    break;
            }
        }
    };
    conn.onclose = function(e) {
        statusSocket = "off";
        console.log("Connection closed!");
    };
}
function date_to_server_date(date) {
    var anio = date.getFullYear();
    var mes = date.getMonth() + 1;
    var dia = date.getDate();
    var hora = date.getHours();
    var min = date.getMinutes();
    var sec = date.getSeconds();
    mes = (mes < 10) ? "0" + mes : mes;
    dia = (dia < 10) ? "0" + dia : dia;
    hora = (hora < 10) ? "0" + hora : hora;
    min = (min < 10) ? "0" + min : min;
    sec = (sec < 10) ? "0" + sec : sec;
    return anio + "-" + mes + "-" + dia + " " + hora + ":" + ":" + min + ":" + sec;
}
function cerrarReto() {
    console.log("si");
    $("#coverDisplay").css({
        "opacity": "0",
        "width": "0",
        "height": "0"
    });
    $("#contenedor-frame").removeClass("class-contenedor-pdf").addClass("hide");
}


/* Preambulo Duelo*/

var velocidad = 100;
var count = 0;

function seleccionOponente() {
    $('#slideshow').stop().animate({scrollLeft: 100}, velocidad, 'linear', function() {
        $(this).scrollLeft(0).find('div:last').after($('div:first', this));
        if (count > 30)
            velocidad += 15;
        else
            count++;
        if (velocidad < 400) {
            seleccionOponente();
        }
        else {

            $("#info-oponente-before").addClass("hide");
            $("#info-oponente").removeClass("hide");
            setTimeout(function() {
                seleccionModulo();
            }, 1000);

        }
    });
}



function seleccionModulo() {

    $("#marco-step-1").addClass("hide");
    $("#marco-step-2").removeClass("hide");
    var d = 2260;
    var elem = $("#pie-step-2");
    $({deg: 0}).animate({deg: d}, {
        duration: 5000,
        linear: 'easeOutQuart',
        step: function(now) {
            elem.css({
                transform: "rotate(" + now + "deg)"
            });
        },
        complete: function() {
            $("#info-modulo-before").addClass("hide");
            $("#info-modulo").removeClass("hide");

            setTimeout(function() {
                velocidad = 100;
                count = 0;
                $("#marco-step-2").addClass("hide");
                $("#marco-step-3").removeClass("hide");
                console.log(posEv + " " + cantidadEvalucaiones);
                seleccionPregunta(posEv, cantidadEvalucaiones);
            }, 1000);
        }
    });
}




function seleccionPregunta(pos, cantidadEv) {
    $('#slideshow-evaluaciones').stop().animate({scrollLeft: 100}, velocidad, 'linear', function() {
        var current = $(this).find("div:first").data("pos");
        current = current + 2;
        current = current % cantidadEv;
        $(this).scrollLeft(0).find('div:last').after($('div:first', this));

        if (count > 30 && velocidad < 300)
            velocidad += 15;
        else
            count++;
        if (velocidad < 300 || current != pos) {
            seleccionPregunta(pos, cantidadEv);
        }
        else {
            $("#info-pregunta-before").addClass("hide");
            $("#info-pregunta").removeClass("hide");

            setTimeout(function() {
                seleccionMonto();
            }, 1000);

        }
    });
}




function seleccionMonto() {
    $("#marco-step-3").addClass("hide");
    $("#marco-step-4").removeClass("hide");
    var img = $("#imagen-dado");
    var url = $(img).data("base-url");
    url += "/assets/img/dados/";
    var i;
    var j = 0;
    var direccion;
    var timer = setInterval(function() {
        i = j % 6;
        direccion = j % 4;
        i++;
        j++;
        direccion++;
        $(img).attr("src", url + i + ".jpg");
        if (direccion == 1) {
            $(img).css('top', '0px').removeClass('dado-right');
            $(img).css('left', '-10px').addClass('dado-left');
        } else if (direccion == 2) {
            $(img).css('left', '0px').removeClass('dado-left');
            $(img).css('top', '-10px').addClass('dado-right');
        } else if (direccion == 3) {
            $(img).css('top', '0px').removeClass('dado-right');
            $(img).css('left', '10px').addClass('dado-left');
        } else if (direccion == 4) {
            $(img).css('left', '0px').removeClass('dado-left');
            $(img).css('top', '10px').addClass('dado-right');
        }

        if (j == 20) {
            $(img).removeClass('dado-right').removeClass('dado-left');
            clearInterval(timer);
        }

    }, 150);

    var img2 = $("#imagen-dado2");
    var url2 = $(img).data("base-url");
    url2 += "/assets/img/dados/";
    var i2;
    var j2 = 0;
    var direccion2;
    var timer2 = setInterval(function() {
        i2 = j2 % 6;
        direccion2 = j2 % 4;
        i2++;
        j2++;
        direccion++;
        $(img2).attr("src", url + i2 + ".jpg");
        if (direccion2 == 1) {
            $(img2).css('top', '0px').removeClass('dado-left');
            $(img2).css('left', '-10px').addClass('dado-right');
        } else if (direccion2 == 2) {
            $(img2).css('left', '0px').removeClass('dado-right');
            $(img2).css('top', '-10px').addClass('dado-left');
        } else if (direccion2 == 3) {
            $(img2).css('top', '0px').removeClass('dado-left');
            $(img2).css('left', '10px').addClass('dado-right');
        } else if (direccion2 == 4) {
            $(img2).css('left', '0px').removeClass('dado-right');
            $(img2).css('top', '10px').addClass('dado-left');
        }

        if (j2 == 20) {
            clearInterval(timer2);
            $(img2).removeClass('dado-right').removeClass('dado-left');
            $("#info-monto-before").addClass("hide");
            $("#info-monto").removeClass("hide");
            setTimeout(function() {
                $("#modal-step-1").modal("hide");
                vs();
            }, 2000);


        }

    }, 170);

}
function vs() {
    var count = 2;

    $("#modal-vs").modal({
        keyboard: false,
        backdrop: "static"
    });
    var time = 2000;


    var timer = setInterval(function() {
        $("#duelo-cuenta-regresiva").html(count);
        if (count == 0) {
            clearInterval(timer);
        }
        count--;
    }, 1000);
    setTimeout(function() {


        $("#avatar-retador").animate({"left": "500px"}, time);
        $("#foto-retador").animate({"left": "430px"}, time);
        $("#avatar-retado").animate({"right": "500px"}, time);
        $("#foto-retado").animate({"right": "430px"}, time, function() {
            complete: {
                $("#modal-vs").modal("hide");
            }
        });
        setTimeout(function() {
            $("#avatar-retador").removeClass("rotar180");
            $("#avatar-retado").addClass("rotar180");
        }, time / 2);
    }, 1000);
}