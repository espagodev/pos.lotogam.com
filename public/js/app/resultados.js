$(document).ready(function () {
    if ($("#reportrange").length == 1) {
        $("#reportrange").daterangepicker(
            dateRangeSettings,
            function (start, end) {
                $("#reportrange span").val(
                    start.format(moment_date_format) +
                        " ~ " +
                        end.format(moment_date_format)
                );
                listado_resultados.ajax.reload();
            }
        );

        $("#reportrange").on("cancel.daterangepicker", function (ev, picker) {
            $("#reportrange").val("");
            listado_resultados.ajax.reload();
        });
    }

    $("#listado_resultados,  #loterias_id").change(function () {
        listado_resultados.ajax.reload();
    });

    $(".loterias_id").hide();
    $(".numerosPremiados").hide();
    $(".guardarResultados").hide();
    $(".enproceso").hide();

    $("input[name=res_fecha]").change(function () {
        $(".loterias_id").show();
        $(".numerosPremiados").hide();
        $(".guardarResultados").hide();
    });

    $(document).on("click", ".nuevo-resultado", function (e) {
        e.preventDefault();
        var container = $(".view_register");

        $.ajax({
            url: $(this).data("href"),
            dataType: "html",
            success: function (result) {
                container.html(result).modal("show");

                $(".loterias_id").hide();
                $(".numerosPremiados").hide();
                $(".guardarResultados").hide();
                $(".enproceso").hide();

                datepicker();
                validar_loteria();
                fn_saltar();
                guardar_resultados();
                // container.html(result).modal("hide");
            },
        });
    });

    //listado de resultados
    listado_resultados = $("#listado_resultados").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: false,
        searching: false,
        ajax: {
            url: "/resultados/getListadoResultados",
            dataType: "json",
            data: function (d) {
                d.loterias_id = $("select#loterias_id").val();

                var start = "";
                var end = "";
                if ($("input#reportrange").val()) {
                    start = $("input#reportrange")
                        .data("daterangepicker")
                        .startDate.format("YYYY-MM-DD");
                    end = $("input#reportrange")
                        .data("daterangepicker")
                        .endDate.format("YYYY-MM-DD");
                }
                d.start_date = start;
                d.end_date = end;
            },
        },
        columns: [
            {
                data: "lot_nombre",
                name: "loteria",
                orderable: false,
                searchable: false,
            },
            {
                data: "res_fecha",
                name: "res_fecha",
                orderable: false,
                searchable: false,
            },
            {
                data: "res_premio1",
                name: "res_premio1",
                orderable: false,
                searchable: false,
            },
            {
                data: "res_premio2",
                name: "res_premio2",
                orderable: false,
                searchable: false,
            },
            {
                data: "res_premio3",
                name: "res_premio3",
                orderable: false,
                searchable: false,
            },
            { data: "action", name: "action" },
        ],
        fnDrawCallback: function (oSettings) {
            __currency_convert_recursively($("#listado_resultados"));
        },
    });
});

$(document).on("click", "button.delete_resultado_button", function () {
    // swal({
    //     title: "Estás seguro ?",
    //     icon: "warning",
    //     buttons: true,
    //     dangerMode: true,
    // }).then((willDelete) => {
    //     if (willDelete) {
            var href = $(this).data("href");
            var data = $(this).serialize();

            $.ajax({
                method: "GET",
                url: href,
                dataType: "json",
                data: data,
                success: function (result) {
                    if (result.status === true) {
                        toastr.success(result.msg);
                        listado_resultados.ajax.reload();
                    } else {
                        toastr.error(result.msg);
                    }
                },
            });
    //     }
    // });
});

function validar_loteria() {
    $("#loterias_cierre_id").bind("change", function () {
        var loterias_id = $("#loterias_cierre_id").val();
        var res_fecha = $("#res_fecha").val();

        $.when(
            $.ajax({
                async: false,
                url: "/resultados/getValidaHoraCierre",
                method: "get",
                dataType: "json",
                data: {
                    loteriasId: loterias_id,
                    resFecha: res_fecha,
                },
            })
        ).then(function (resp) {
            if (resp.status == "resultados") {
                $("input[name=res_fecha]").focus();
                toastr.warning(resp.mensaje);
            } else if (resp.status == "cierre") {
                $(".numerosPremiados").hide();
                $(".guardarResultados").hide();
                toastr.warning(resp.mensaje);
            } else if (resp.status == "fecha") {
                $("input[name=tid_apuesta]").focus();
                toastr.warning(resp.mensaje);
            } else if (resp.status == true) {
                $(".numerosPremiados").show();
                $(".guardarResultados").show();
            }
        });
    });
}

function guardar_resultados() {
    $(".guardarResultados").click(function () {
        $(".resultados").hide();
        $(".numerosPremiados").hide();
        $(".guardarResultados").hide();
        $(".cancelar").hide();
        $(".enproceso").show();

        var container = $(".view_register");

        var loterias_id = $("#loterias_cierre_id").val();
        var res_fecha = $("#res_fecha").val();
        var premio1 = $("#res_premio1").val();
        var premio2 = $("#res_premio2").val();
        var premio3 = $("#res_premio3").val();

        var delayInMilliseconds = 2000; //1 second
        setTimeout(function () {
            $.when(
                $.ajax({
                    async: false,
                    url: "/resultados/getGuardarResultados",
                    method: "get",
                    dataType: "json",
                    data: {
                        loteriasId: loterias_id,
                        resFecha: res_fecha,
                        premio1: premio1,
                        premio2: premio2,
                        premio3: premio3,
                    },
                })
            ).then(function (resp) {
                if (resp.status == true) {
                    $("input[name=res_fecha]").val("");
                    $("#loterias_id").val("");
                    $("#res_premio1").val("");
                    $("#res_premio2").val("");
                    $("#res_premio3").val("");
                    $(".numerosPremiados").hide();
                    $(".guardarResultados").hide();
                    $(".loterias_id").hide();
                    $(".enproceso").hide();

                    // $(".view_register").hide();
                    container.html(resp).modal("hide");
                    toastr.info(resp.msg);
                    listado_resultados.ajax.reload();
                }
            });
        }, delayInMilliseconds);
    });
}

function datepicker() {
    $("#res_fecha").pickadate({
        format: "dd/mm/yyyy",
        formatSubmit: "dd/mm/yyyy",
        today: "Hoy",
        clear: "",
        close: "Cancelar",
        min: -4,
        max: 0,
    });

    $("input[name=res_fecha]").change(function () {
        $(".loterias_id").show();
        $(".numerosPremiados").hide();
        $(".GuardarResultados").hide();
    });
}

function fn_saltar(pre_premio, orden) {
    if (orden == 1 && pre_premio.value.length == 2) $("#res_premio2").focus();
    else if (orden == 2 && pre_premio.value.length == 2)
        $("#res_premio3").focus();
}
