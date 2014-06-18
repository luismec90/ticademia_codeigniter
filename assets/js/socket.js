var conn;
var usuarioRetadorGlobal;

$(function() {
    if (idUsuarioGlobal != -1) {
        socket();

        $("#usuarios-conectados").on("click", "a", function() {// Retar a alguien
            var data = {
                tipo: 'retar',
                id_curso: idCursoGlobal,
                id_usuario: idUsuarioGlobal,
                nombre_usuario: nombreUsuarioGlobal,
                usuario_retado: $(this).data("id-usuario")
            };
            conn.send(JSON.stringify(data));
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
            var respuestaCorrecta = 4;
            var respuestaUsuario = $("#respuesta-reto").val();
            var status = "incorrecto";
            if (respuestaCorrecta == respuestaUsuario) {
                status = "correcto"
            }
            var data = {
                tipo: 'enviar_respuesta',
                id_curso: idCursoGlobal,
                posible_ganador: idUsuarioGlobal,
                nombre_usuario: nombreUsuarioGlobal,
                estatus: status,
                fecha_inicio_reto: fechaInicioReto,
                fecha_fin_reto: date_to_server_date(new Date())
            };
            conn.send(JSON.stringify(data));
        });
    }

});
function socket() {
    conn = new WebSocket('ws://guiame.medellin.unal.edu.co:8080?id_curso=45');
    conn.onopen = function(e) {
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
                case "inicio":// Establecer conoexion
                    var str = "";
                    $.each(data.datos, function(id_usuario, info) {
                        if (id_usuario != idUsuarioGlobal) {
                            str += "<li id='usuario-" + id_usuario + "'><a data-id-usuario='" + id_usuario + "'>" + info.nombre_usuario + "</a></li>";
                        }
                    });
                    $("#usuarios-conectados").html(str);
                    break;

                case "user_on":// Notificacion de un usuario conecatdo
                    var str = "";
                    $.each(data.datos, function(id_usuario, nombre_usuario) {
                        if (id_usuario != idUsuarioGlobal) {
                            str += "<li id='usuario-" + id_usuario + "'><a data-id-usuario='" + id_usuario + "'>" + nombre_usuario + "</a></li>";
                        }
                    });
                    $("#usuarios-conectados").append(str);
                    break;

                case "user_off":// Notificacion de un usuario desconecatdo
                    $.each(data.datos, function(id_usuario, nombre_usuario) {
                        $("#usuario-" + id_usuario).remove();
                    });
                    break;

                case "retado":// Notificacion de que ha sido retado
                    $.each(data.datos, function(id_usuario, nombre_usuario) {
                        usuarioRetadorGlobal = id_usuario;
                        $("#body-modal-retado").html("El usuario " + nombre_usuario + " te ha retado a un duelo, deseas aceptar?");
                        $("#retado").modal();
                    });
                    break;

                case "reto_rechazado":// El usuario retado rechazo el reto
                    $.each(data.datos, function(id_usuario, nombre_usuario) {
                        $("#nombre-usuario-reto-rechazado").html(nombre_usuario);
                        $("#reto-rechazado").modal();
                    });
                    break;

                case "reto_aceptado"://Notifocacion de iniciar el duelo, este mensaje le llega tanto al retado como al retador
                    $.each(data.datos, function(id_usuario, nombre_usuario) {
                        $("#comenzar-reto").modal();
                        fechaInicioReto = date_to_server_date(new Date());
                    });
                    break;

                case "desconectado_antes":
                    $.each(data.datos, function(id_usuario, nombre_usuario) {
                        $(".modal").modal('hide');
                        $("#modal-desconectado-antes").modal();
                    });
                    break;

                case "desconectado":
                    $.each(data.datos, function(id_usuario, nombre_usuario) {
                        $(".modal").modal('hide');
                        $("#nombre-usuario-desconectado").html(nombre_usuario);
                        $("#ganador-reto-por-w").modal();
                    });
                    break;

                case "empate":
                    $.each(data.datos, function(id_usuario, nombre_usuario) {
                        $(".modal").modal('hide');
                        $("#custom-modal-title").html("Empate");
                        $("#body-custom-modal").html("Se ha producido un empate");
                        $("#custom-modal").modal();
                    });
                    break;

                case "ganador":
                    $.each(data.datos, function(id_usuario, nombre_usuario) {
                        $(".modal").modal('hide');
                        $("#custom-modal-title").html("Ganador");
                        $("#body-custom-modal").html("El usuaraio " + nombre_usuario + " ha  ganado el reto");
                        $("#custom-modal").modal();
                    });
                    break;
            }
        }
    };
    conn.onclose = function(e) {
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