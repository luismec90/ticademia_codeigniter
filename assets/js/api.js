API = new Object();
API.LMSInitialize = function(a) {
    $.ajax({
        url: "../api/LMSInitialize",
        method: "post",
        data: {
            param1: a,
            idEvaluacion: idEvaluacion,
        },
        success: function(data) {
        }
    });
}
API.LMSFinish = function(a) {
    $.ajax({
        url: "../api/LMSFinish",
        method: "post",
        data: {
            param1: a
        },
        success: function(data) {
        }
    });
}
API.calificar = function(calificacion, feedback) {
    var stopEvaluation = new Date();
    var durationEvaluation = Math.round((stopEvaluation - startEvaluation) / 1000);
    $.ajax({
        url: "../api/calificar",
        method: "post",
        data: {
            idEvaluacion: idEvaluacion,
            calificacion: calificacion,
            duracion: durationEvaluation,
            feedback: feedback
        },
        success: function(data) {
        }
    });
}
API.LMSSetValue = function(a, b) {
    $.ajax({
        url: "../api/LMSSetValue",
        method: "post",
        data: {
            param1: a,
            param2: b
        },
        success: function(data) {
        }
    });
}
API.notifyDaemon = function(calificacion) {
    if (calificacion == 1) {
        var status = "correcto";
    } else {
        var status = "incorrecto";
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
}