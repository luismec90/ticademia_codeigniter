
$(function() {

    $(".datepicker").datepicker({
        dateFormat: "yy-mm-dd",
        monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        dayNamesMin: ["Dom", "Lun", "Mar", "Mié", "Juv", "Vie", "Sáb"]
    });

    $("#timeline-embed").on("click", ".editarModulo", function() {
        $("#editarIdModulo").val($(this).data("id-modulo"));
        $("#editarNombreModulo").val($(this).data("nombre"));
        $("#editarDesdeModulo").val($(this).data("desde"));
        $("#editarHastaModulo").val($(this).data("hasta"));
        $("#editarDescripcionModulo").val($(this).data("descripcion"));
    });
    $("#timeline-embed").on("click", ".eliminarModulo", function() {
        $("#eliminarIdModulo").val($(this).data("id-modulo"));
        $("#eliminarNombreModulo").html($(this).data("nombre"));
    });
    $("#timeline-embed").on("click", ".media-container .media-image img.media-image", function() {
        var div = $(this).parent().parent().find(".btn-info").data("id-modulo");
        window.location.href = '../modulo/' + div;
    });
});
function loadRankingMod(e) {

    var div = $(e).parent().parent();
    var count = div.find("img.rank").length;
    count--;
    count *= 210;
    if ($(e).hasClass("desabilitado")) {
        return false;
    } else {
        $(e).addClass("desabilitado")

        if (div.hasClass("foward")) {
            div.removeClass("foward").addClass("reverse");
            setTimeout(function() {
                div.removeClass("reverse");
                div.find("img.rank").addClass("hide");
                $(e).removeClass("desabilitado")
            }, 1000);
        } else {
            div.find("img.rank").removeClass("hide");
            div.addClass("foward");
            setTimeout(function() {
                $(e).removeClass("desabilitado")
            }, count);
        }
    }
}