
$(function() {
    $(".formSubmit").submit(function() {
        $("#coverDisplay").css({
            "opacity": "1",
            "width": "100%",
            "height": "100%"
        });
    });
    $("#toast-container").delay(4000).fadeOut('normal');
    $(document).on("click", "img.rank", function() {
        var idCurso = $(this).data("id-curso");
        var idUsuario = $(this).data("id-estudiante");
        modalInfoUsuario(idUsuario, idCurso);

    });
    $("#cerrarPopover").click(function() {
        $("img.rank").removeClass("clicked");
        $("#infoUsuario").hide();
    });
    /*
     $("img.rank").click(function(e) {
     $("#infoUsuario").show();
     }); */
    $('.modal').on('hidden.bs.modal', function() {
        var form = $(this).find('form');
        if (form.length > 0) {
            form[0].reset();
        }
    });
    $(".btn-file :file").change(function() {

        var input = $(this);
        var label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.parent().parent().siblings("input").val(label);
    });
    $("#link-foro").click(function() {
        $.ajax({
            method: "GET",
            url: base_url + "ajax/notificaciones/foroOff",
            success: function(data) {
                //   console.log(data);
            }
        });
    });
    $(".info-usuario").click(function() {
        var idCurso = $(this).data("id-curso");
        var idUsuario = $(this).data("id-usuario");
        modalInfoUsuario(idUsuario, idCurso);
    });
   
    verificarNuevoLogro();
});

function modalInfoUsuario(idUsuario, idCurso) {
    $("#coverDisplay").css({
        "opacity": "1",
        "width": "100%",
        "height": "100%"
    });
    $.ajax({
        url: base_url + "usuario/info",
        data: {
            idCurso: idCurso,
            idUsuario: idUsuario
        },
        success: function(data) {
            $("#coverDisplay").css({
                "opacity": "0",
                "width": "0",
                "height": "0"
            });
            $("#body-modal-info-usuario").html(data);
            $("#modal-info-usuario").modal();
        }
    });

}

function verificarNuevoLogro() {
    $.ajax({
        method: "GET",
        url: base_url + "ajax/logro",
        success: function(data) {
            var json = JSON.parse(data);
            $.each(json, function(key, value) {
                $("#img-logro").attr("src", value.imagen);
                $("#nombre-logro").html(value.nombre);
                $("#nombre-asignatura").html(value.nombre_asignatura);
                $("#descripcion-logro").html(value.descripcion);
                $("#fecha-logro").html(value.fecha_obtencion);
                $("#idUsuarioCursoLogro").val(value.id_usuario_curso_logro);
                urlFacebook = value.share_facebook;
                urlTwitter = value.share_twitter;
                $("#modalLogro").modal();
            });
        }
    });
}

