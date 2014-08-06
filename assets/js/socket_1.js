var conn;
var usuarioRetadorGlobal;
var statusSocket;
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
                $("#body-custom-modal").html("No hay conexión con el servidor, inténtelo más tarde.");
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

                case "reto_aceptado"://Notifocacion de iniciar el duelo, este mensaje le llega tanto al retado como al retador
                    $(".modal").modal('hide');
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
                    });
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