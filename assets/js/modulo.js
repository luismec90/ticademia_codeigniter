google.load('visualization', '1.0', {'packages': ['corechart']});
var player;
var idMaterial;
var startPdf;
var startVideo;
var startEvaluation;
var durationVideo;
var idEvaluacion;
$(function() {
    $('#modalRespuestaEvaluacion').on('hidden.bs.modal', function() {
        location.reload();
    });

    $('#lista-material .ver-mas').click(function(e) {
        var titulo = $(this).data("titulo");
        //     var contenido=$(this).data("contenido");
        $("#popover-titulo").html(titulo);
        var height = $("#custom-popover").css("display", "block")[0].offsetHeight;
        var widthPopover = $("#custom-popover")[0].offsetWidth;
        var widthLi = $(this).parent()[0].offsetWidth;
        $("#custom-popover").css({
            left: e.pageX - widthLi + 40 - widthPopover / 2,
            top: e.pageY - height - 5
        });
        //    $('#lista-material .ver-mas').popover("hide");
    });
    $("#cerrar-popover").click(function() {
        $("#custom-popover").css("display", "none");
    });
    //   $('#lista-material .ver-mas').popover();

    player = new MediaElementPlayer('#video', {
        success: function(mediaElement) {
            mediaElement.addEventListener('playing', function(e) {
                startVideo = new Date();
            }, false);
            mediaElement.addEventListener('pause', function(e) {
                var stopVideo = new Date();
                durationVideo += (stopVideo - startVideo) / 1000;
                if (!$("#contenedor-video").is(":visible")) {
                    $.ajax({
                        method: "POST",
                        url: "../material/actualizar",
                        data: {
                            idMaterial: idMaterial,
                            duracion: durationVideo
                        },
                        success: function(data) {
                            location.reload();
                        }
                    });
                }
            }, false);
        }
    });
    $("#contenedor .video").click(function() {
        $("#coverDisplay").css({
            "opacity": "1",
            "width": "100%",
            "height": "100%"
        });
        $("#contenedor-video").addClass("class-contenedor-video").removeClass("hide");
        idMaterial = $(this).data("id-material");
        $.ajax({
            method: "POST",
            url: "../material/crearRegistro",
            data: {
                idMaterial: idMaterial
            }
        });
        durationVideo = 0;
        player.setSrc($(this).data("ubicacion"));
        player.load();
        player.play();
    });


    $("#botonCerrarVideo").click(function() {
        $("#coverDisplay").css({
            "opacity": "0",
            "width": "0",
            "height": "0"
        });
        $("#contenedor-video").removeClass("class-contenedor-video button").addClass("hide");
        player.play();
        player.pause();

    });

    $("#contenedor .pdf").click(function() {
        startPdf = new Date();
        idMaterial = $(this).data("id-material");
        $.ajax({
            method: "POST",
            url: "../material/crearRegistro",
            data: {
                idMaterial: idMaterial
            }
        });
        $("#pdf").attr("src", $(this).data("ubicacion"));
        $("#coverDisplay").css({
            "opacity": "1",
            "width": "100%",
            "height": "100%"
        });
        $("#contenedor-pdf").removeClass("hide");

    });
    $("#botonCerrarPdf").click(function() {
        var endPdf = new Date();
        var duration = Math.ceil((endPdf - startPdf) / 1000);
        $.ajax({
            method: "POST",
            url: "../material/actualizar",
            data: {
                idMaterial: idMaterial,
                duracion: duration
            },
            success: function(data) {
                location.reload();
            }
        });
        $("#coverDisplay").css({
            "opacity": "0",
            "width": "0",
            "height": "0"
        });
        $("#contenedor-pdf").addClass("hide");

    });
    $("#contenedor .open,#contenedor .solved").click(function() {
        evaluacionOReto = "evaluacion";
        idEvaluacion = $(this).data("id-evaluacion");
        startEvaluation = new Date();
        $("#contenedor-frame iframe").attr("src", $(this).data("ubicacion"))
        $("#coverDisplay").css({
            "opacity": "1",
            "width": "100%",
            "height": "100%"
        });
        $("#contenedor-frame").removeClass("hide");

    });
    $("#botonCerrarFrame").click(function() {
        $("#coverDisplay").css({
            "opacity": "0",
            "width": "0",
            "height": "0"
        });
        $("#contenedor-frame").removeClass("class-contenedor-pdf").addClass("hide");
        $("html, body").css({
            'overflow': 'content'
        });
        location.reload();
    });
    $("#div-material .editarMaterial").click(function() {
        $("#inputIdMaterial").val($(this).data("id-material"));
        $("#editarNombreMaterial").val($(this).data("nombre"));
        $("#editarDescripcionMaterial").val($(this).data("descripcion"));
    });
    $("#div-material .eliminarMaterial").click(function() {
        $("#inputEliminarIdMaterial").val($(this).data("id-material"));
        $("#eliminarNombreMaterial").html($(this).data("nombre"));
    });

    $("#container-evaluaciones .editarEvaluacion").click(function() {
        $("#inputIdEvaluacion").val($(this).data("id-evaluacion"));
        $("#editarTipoEvaluacion").val($(this).data("tipo"));
    });
    $("#container-evaluaciones .eliminarEvaluacion").click(function() {
        $("#inputEliminarIdEvaluacion").val($(this).data("id-evaluacion"));
        $("#eliminarNumeroEvaluacion").html($(this).data("numero"));
    });




    $("#sortableMateriales").sortable({
        update: function(event, ui) {
            var orden = $(this).sortable('toArray').toString();
            $("#ordenMateriales").val(orden);
        }
    });
    $("#sortableEvaluaciones").sortable({
        update: function(event, ui) {
            var orden = $(this).sortable('toArray').toString();
            $("#ordenEvaluaciones").val(orden);
        }
    });
    $('.link-material').popover({
        trigger: "hover"
    });

    $('.estrellas').raty({
        path: '../assets/libs/raty/lib/img',
        half: true,
        score: function() {
            return $(this).attr('data-score');
        },
        click: function(score, evt) {
            $("#idMaterial").val($(this).data('id-material'));
            $("#comentario").val($(this).data('comentario'));
            $('#preview-stars').raty({
                path: '../assets/libs/raty/lib/img',
                half: true,
                score: score});
            $("#modalValoracionMaterial").modal("show");
        }
    });
    $("#lista-material a.ver-comentarios").click(function() {
        var idMaterial = $(this).data("id-material");
        $.ajax({
            url: "../material/verComentarios",
            data: {
                idMaterial: idMaterial,
                pagina: 1
            },
            success: function(data) {
                $("#modal-body-ver-valoraciones").html(data);
            }
        });
    });
    $("#modalVerValoracionesMaterial").on("click", "a.pagina-valoracion-material", function() {
        var idMaterial = $(this).data("id-material");
        var pagina = $(this).data("pagina");
        $.ajax({
            url: "../material/verComentarios",
            data: {
                idMaterial: idMaterial,
                pagina: pagina
            },
            success: function(data) {
                $("#modal-body-ver-valoraciones").html(data);
            }
        });
    });

    $("#div-material .estadisticasMaterial").click(function() {
        document.getElementById('modal-estadistica1').innerHTML = "";
        document.getElementById('modal-estadistica2').innerHTML = "";
        var idMaterial = $(this).data("id-material");
        var tipo = $(this).data("tipo");

        var jsonData = $.ajax({
            url: "../material/estadisticasValoraciones?idMaterial=" + idMaterial,
            dataType: "json",
            async: false
        }).responseText;

        var data = new google.visualization.DataTable(jsonData);

        var chart = new google.visualization.PieChart(document.getElementById('modal-estadistica1'));
        chart.draw(data, {title: "Valoraciones"});

        var jsonData2 = $.ajax({
            url: "../material/estadisticasAccesos?idMaterial=" + idMaterial + "&tipo=" + tipo + "&idCurso=" + idCursoGlobal,
            dataType: "json",
            async: false
        }).responseText;

        var data = new google.visualization.DataTable(jsonData2);

        var chart = new google.visualization.LineChart(document.getElementById('modal-estadistica2'));
        chart.draw(data, {title: "Vistas por día", width: 400, hAxis: {showTextEvery: 4}});

        $("#modalEstadisticasMaterial").modal();

    });

    $("#container-evaluaciones .estadisticasEvaluacion").click(function() {
        document.getElementById('modal-estadistica-evaluacion1').innerHTML = "";
        document.getElementById('modal-estadistica-evaluacion2').innerHTML = "";
        var idEvaluacion = $(this).data("id-evaluacion");

        var jsonData = $.ajax({
            url: "../evaluacion/estadisticasRespuestas?idEvaluacion=" + idEvaluacion,
            dataType: "json",
            async: false
        }).responseText;

        var data = new google.visualization.DataTable(jsonData);
        var chart = new google.visualization.PieChart(document.getElementById('modal-estadistica-evaluacion1'));
        chart.draw(data, {title: "Respuestas"});

        var jsonData2 = $.ajax({
            url: "../evaluacion/estadisticasRespuestas2?idEvaluacion=" + idEvaluacion + "&idCurso=" + idCursoGlobal,
            dataType: "json",
            async: false
        }).responseText;

        var data = new google.visualization.DataTable(jsonData2);
        var chart = new google.visualization.LineChart(document.getElementById('modal-estadistica-evaluacion2'));
        chart.draw(data, {title: "Respuestas", hAxis: {showTextEvery: 4}});

        $("#modalEstadisticasEvaluacion").modal();
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
function modalEstadisticas1($data) {


}