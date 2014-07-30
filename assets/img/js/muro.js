$(function() {
    $("#contenedor .comentar").click(function() {
        $(this).parent().parent().parent().find(".ocultar").toggle();
    });
     $("#contenedor .eliminar").click(function() {
      var idMensaje=$(this).data("id-mensaje");
      $("#id-mensaje-eliminar").val(idMensaje);
      $("#modal-eliminar-mensaje").modal();
    });
}); 