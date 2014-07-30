google.load('visualization', '1.0', {'packages': ['corechart']});
var player;
var idMaterial;
var startPdf;
var startVideo;
var startEvaluation;
var durationVideo;
var idEvaluacion;


function cargarModulo(idModulo) {
    $("#coverDisplay").css({
        "opacity": "1",
        "width": "100%",
        "height": "100%"
    });
    if (idModulo == -1) {
        idModulo = $("#contenido").data("id-modulo");
    } else {
        $("#contenido").data("id-modulo", idModulo);
    }

    $.ajax({
        url: "../curso/getmodulo",
        data: {
            idModulo: idModulo,
            idCurso: idCursoGlobal
        },
        success: function(data) {
            $("#contenido").html(data);
//            eventosModulo();
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


            if (rolGlobal == 1) {
                var readOnly = false;
            } else {
                var readOnly = true;
            }
            $('.estrellas').raty({
                path: '../assets/libs/raty/lib/img',
                half: true,
                readOnly: readOnly,
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
            $("#coverDisplay").css({
                "opacity": "0",
                "width": "0",
                "height": "0"
            });
            if (countCallsCargarModulo) {
                verificarNuevoLogro();
            }
            countCallsCargarModulo++;
            $('.tip').tooltip();
            if (idModulo == -1) {
                $("#desde").datepicker({
                    changeMonth: true,
                    dateFormat: "yy-mm-dd",
                    monthNamesShort: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                    dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Juv", "Vie", "Sab"],
                    onClose: function(selectedDate) {
                        $("#hasta").datepicker("option", "minDate", selectedDate);
                    }
                });

                $("#hasta").datepicker({
                    changeMonth: true,
                    dateFormat: "yy-mm-dd",
                    monthNamesShort: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                    dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Juv", "Vie", "Sab"],
                    onClose: function(selectedDate) {
                        $("#desde").datepicker("option", "maxDate", selectedDate);
                    }
                });
            } else if (rolGlobal == 2) {
                $("#desde,#editarDesdeModulo").datepicker({
                    changeMonth: true,
                    dateFormat: "yy-mm-dd",
                    monthNamesShort: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                    dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Juv", "Vie", "Sab"],
                    onClose: function(selectedDate) {
                        $("#editarHastaModulo").datepicker("option", "minDate", selectedDate);
                    }
                });

                $("#hasta,#editarHastaModulo").datepicker({
                    changeMonth: true,
                    dateFormat: "yy-mm-dd",
                    monthNamesShort: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                    dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Juv", "Vie", "Sab"],
                    onClose: function(selectedDate) {
                        $("#editarDesdeModulo").datepicker("option", "maxDate", selectedDate);
                    }
                });
            }
        }
    });
}

$(function() {
    $('#modalRespuestaEvaluacion').on('hidden.bs.modal', function() {
        cargarModulo(-1);
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
                    if (rolGlobal == 1) {
                        $.ajax({
                            method: "POST",
                            url: "../material/actualizar",
                            data: {
                                idMaterial: idMaterial,
                                duracion: durationVideo
                            },
                            success: function(data) {
                                cargarModulo(-1);
                            }
                        });
                    }
                }
            }, false);
        }
    });
    $("#contenedor").on("click", ".video", function() {
        $("#coverDisplay").css({
            "opacity": "1",
            "width": "100%",
            "height": "100%"
        });
        $("#contenedor-video").addClass("class-contenedor-video").removeClass("hide");
        idMaterial = $(this).data("id-material");
        if (rolGlobal == 1) {
            $.ajax({
                method: "POST",
                url: "../material/crearRegistro",
                data: {
                    idMaterial: idMaterial
                }
            });
        }
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
    $("#contenedor").on("click", ".pdf", function() {
        startPdf = new Date();
        idMaterial = $(this).data("id-material");
        if (rolGlobal == 1) {
            $.ajax({
                method: "POST",
                url: "../material/crearRegistro",
                data: {
                    idMaterial: idMaterial
                }
            });
        }
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
        if (rolGlobal == 1) {
            $.ajax({
                method: "POST",
                url: "../material/actualizar",
                data: {
                    idMaterial: idMaterial,
                    duracion: duration
                },
                success: function(data) {
                    cargarModulo(-1);
                }
            });
        }
        $("#coverDisplay").css({
            "opacity": "0",
            "width": "0",
            "height": "0"
        });
        $("#contenedor-pdf").addClass("hide");

    });
    $("#contenedor").on("click", ".open,.solved", function() {
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
        if (evaluacionOReto == "evaluacion") {
            $.ajax({
                url: "../api/checkSinInformacion",
                method: "post",
                data: {
                    idEvaluacion: idEvaluacion
                },
                success: function(data) {
                    cargarModulo(-1);
                }
            });
        }

    });
    $("#contenedor").on("click", ".editarMaterial", function() {
        $("#inputIdMaterial").val($(this).data("id-material"));
        $("#editarNombreMaterial").val($(this).data("nombre"));
        $("#editarDescripcionMaterial").val($(this).data("descripcion"));
    });

    $("#contenedor").on("click", ".eliminarMaterial", function() {
        $("#inputEliminarIdMaterial").val($(this).data("id-material"));
        $("#eliminarNombreMaterial").html($(this).data("nombre"));
    });

    $("#contenedor").on("click", ".editarEvaluacion", function() {
        var idEvaluacion = $(this).data("id-evaluacion");
        $("#inputIdEvaluacion").val(idEvaluacion);
        $("#editarTipoEvaluacion").val($(this).data("tipo"));
        $("#modalEditarEvaluacion .input-check").prop("checked", false);
        $.ajax({
            url: "../evaluacion/materialesrelacionados",
            data: {
                idEvaluacion: idEvaluacion
            },
            success: function(data) {
                var json = JSON.parse(data);
                $.each(json, function(key, value) {
                    $("#check-evaluacion-" + value.id_material).prop("checked", true);
                });
            }
        });
    });

    $("#contenedor").on("click", ".eliminarEvaluacion", function() {
        $("#inputEliminarIdEvaluacion").val($(this).data("id-evaluacion"));
        $("#eliminarNumeroEvaluacion").html($(this).data("numero"));
    });

    $("#contenedor").on("click", ".saltarEvaluacion", function() {
        $("#idEvaluacionSaltar").val($(this).data("id-evaluacion"));
        $("#modalSaltarEvaluacion").modal();
    });


    $("#contenedor").on("click", "a.ver-comentarios", function() {
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
    $("#contenedor").on("click", "a.pagina-valoracion-material", function() {
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

    $("#contenedor").on("click", ".estadisticasMaterial", function() {
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
        chart.draw(data, {title: "Valoraciones", width: 550});

        var jsonData2 = $.ajax({
            url: "../material/estadisticasAccesos?idMaterial=" + idMaterial + "&tipo=" + tipo + "&idCurso=" + idCursoGlobal,
            dataType: "json",
            async: false
        }).responseText;

        var data = new google.visualization.DataTable(jsonData2);

        var chart = new google.visualization.LineChart(document.getElementById('modal-estadistica2'));
        chart.draw(data, {title: "Vistas por día", width: 400, hAxis: {showTextEvery: 4}, width:550});

        $("#modalEstadisticasMaterial").modal();

    });

    $("#contenedor").on("click", ".estadisticasEvaluacion", function() {
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
        chart.draw(data, {title: "Respuestas", width: 550});

        var jsonData2 = $.ajax({
            url: "../evaluacion/estadisticasRespuestas2?idEvaluacion=" + idEvaluacion + "&idCurso=" + idCursoGlobal,
            dataType: "json",
            async: false
        }).responseText;

        var data = new google.visualization.DataTable(jsonData2);
        var chart = new google.visualization.LineChart(document.getElementById('modal-estadistica-evaluacion2'));
        chart.draw(data, {title: "Respuestas", hAxis: {showTextEvery: 4}, width: 550});

        $("#modalEstadisticasEvaluacion").modal();
    });

    $("#contenedor").on('mouseenter', 'tr.material', function(event) {
        var idMaterial = $(this).data("id-material");
        $(".resaltar-evaluacion-" + idMaterial).addClass("resaltar-evaluacion");
    });
    $("#contenedor").on('mouseleave', 'tr.material', function() {
        var idMaterial = $(this).data("id-material");
        $(".resaltar-evaluacion-" + idMaterial).removeClass("resaltar-evaluacion");
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
