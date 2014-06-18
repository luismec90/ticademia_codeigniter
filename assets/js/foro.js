$(function() {
    $('#crearTema').click(function() {
        $('#modalCrearTema').modal({
            keyboard: false,
            backdrop: "static"
        });
    });
    $('#tabla-foro .close').click(function() {
        $("#idTemaEliminar").val($(this).data("id-tema"));
        $('#modalEliminarTema').modal({
            keyboard: false,
              backdrop: "static"
        });
    });
    $('#tabla-tema .close').click(function() {
        $("#idRespuestaEliminar").val($(this).data("id-respuesta"));
        $('#modalEliminarRespuesta').modal({
            keyboard: false,
              backdrop: "static"
        });
    });
});
