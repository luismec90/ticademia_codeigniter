var conn;
var usuarioRetadorGlobal;

$(function() {
    if (idUsuarioGlobal != -1) {
        socket();
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
                case "inicio":
                    var str = "";

                    $.each(data.datos, function(id_usuario, info) {
                        if (id_usuario != idUsuarioGlobal) {
                            str += "<li id='usuario-" + id_usuario + "'><a data-id-usuario='" + id_usuario + "'>" + info.nombre_usuario + "</a></li>";
                        }
                    });
                    $("#usuarios-conectados").html(str);
                    break;

                case "user_on":
                    var str = "";
                    $.each(data.datos, function(id_usuario, nombre_usuario) {
                        if (id_usuario != idUsuarioGlobal) {
                            str += "<li id='usuario-" + id_usuario + "'><a data-id-usuario='" + id_usuario + "'>" + nombre_usuario + "</a></li>";
                        }
                    });
                    $("#usuarios-conectados").append(str);
                    break;

                case "user_off":
                    $.each(data.datos, function(id_usuario, nombre_usuario) {
                        $("#usuario-" + id_usuario).remove();
                    });
                    break;
                case "retado":
                    $.each(data.datos, function(id_usuario, nombre_usuario) {
                        usuarioRetadorGlobal = id_usuario;
                        $("#body-modal-retado").html("El usuario " + nombre_usuario + " te ha retado a un duelo, deseas aceptar?");
                        $("#retado").modal();

                    });
                    break;
                case "reto_rechazado":
                    $.each(data.datos, function(id_usuario, nombre_usuario) {
                        $("#nombre-usuario-reto-rechazado").html(nombre_usuario);
                        $("#reto-rechazado").modal();
                    });
                    break;
                case "reto_aceptado":
                    $.each(data.datos, function(id_usuario, nombre_usuario) {
                        $("#comenzar-reto").modal();
                        fechaInicioReto = date_to_serve_date(new Date());
                    });
                    break;
                case "desconectado":
                    $.each(data.datos, function(id_usuario, nombre_usuario) {
                        $(".modal").modal('hide');
                        $("#nombre-usuario-desconectado").html(nombre_usuario);
                        $("#ganador-reto-por-w").modal();
                    });
                    break;

                case "desconectado_antes":
                    $.each(data.datos, function(id_usuario, nombre_usuario) {
                        $(".modal").modal('hide');
                        $("#modal-desconectado-antes").modal();
                    });
                    break;
            }
        }
    };
    conn.onclose = function(e) {
        console.log("Connection closed!");
    };
}
function date_to_serve_date(date) {
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