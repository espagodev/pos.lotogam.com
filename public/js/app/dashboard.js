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
                getResultadosFecha();
            }
        );

        $("#reportrange").on("cancel.daterangepicker", function (ev, picker) {
            $("#reportrange").val("");
            getResultadosFecha();
        });
    }

    if ($("#lista_Resultados").length == 1) {
        $("#lista_Resultados").daterangepicker(dateRangeSettings, function(start,end) {
            $("#lista_Resultados").val(start.format(moment_date_format) + " ~ " +  end.format(moment_date_format));
            tickets_premiados.ajax.reload();
            
        });

        $("#lista_Resultados").on("cancel.daterangepicker", function(ev,picker) {
            $("#lista_Resultados").val("");            
            tickets_premiados.ajax.reload();
        });

    }

    var start = $('input[name="date-filter"]:checked').data("start");
    var end = $('input[name="date-filter"]:checked').data("end");

    getTotales(start, end);

    $(document).on("change", 'input[name="date-filter"]', function () {
        var start = $('input[name="date-filter"]:checked').data("start");
        var end = $('input[name="date-filter"]:checked').data("end");
        getTotales(start, end);
    });


    //Reporte de tickets premiados
    tickets_premiados = $("#tickets_premiados").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: false,
        searching: false,
        responsive: true,
        ajax: {
            url: "/dashboard/getReporteTicketsPremiados",
            dataType: "json",
            data: function (d) {
                d.bancas_id = $("select#bancas_id").val();
                d.users_id = $("select#users_id").val();
                var start = '';
                var end = '';
                if ($('input#lista_Resultados').val()) {
                    start = $('input#lista_Resultados')
                        .data('daterangepicker')
                        .startDate.format('YYYY-MM-DD');
                    end = $('input#lista_Resultados')
                        .data('daterangepicker')
                        .endDate.format('YYYY-MM-DD');
                }
                d.start_date = start;
                d.end_date = end;
                
            },
        },
        columns: [
            {
                data: "tic_ticket",
                name: "ticket",
                orderable: false,
                searchable: true,
            },
            {
                data: "tic_fecha_sorteo",
                name: "tic_fecha_sorteo",
                orderable: false,
                searchable: false,
            },
            {
                data: "lot_nombre",
                name: "loteria",
                orderable: false,
                searchable: false,
            },
            {
                data: "tic_apostado",
                name: "tic_apostado",
                orderable: false,
                searchable: false,
            },
            {
                data: "tic_ganado",
                name: "tic_ganado",
                orderable: false,
                searchable: false,
            },
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false,
            },
        ],
        fnDrawCallback: function (oSettings) {
            __currency_convert_recursively($("#tickets_premiados"));
        },
    });

    $(function() {
        $(".btnVentasMes").click(function() {          
            html2canvas(document.getElementById('ventas_mes')).then(function(canvas) {
                // document.body.appendChild(canvas);
                var a = document.createElement('a');
                      // toDataURL defaults to png, so we need to request a jpeg, then convert for file download.
                      a.href = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
                      a.download = 'reporte_ventas_mes.png';
                      a.click();
               });

        });
    });

    //Reporte de ventas mes
    ventas_mes = $("#ventas_mes").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: false,
        searching: false,
        paging: false,
        ajax: {
            url: "/dashboard/getVentasMes",
            dataType: "json",
            data: function (d) {
                d.bancas_id = $("select#bancas_id").val();
                d.users_id = $("select#users_id").val();               

                d.start_date = moment().startOf("month").format("YYYY-MM-DD");
                d.end_date = moment().endOf("month").format("YYYY-MM-DD");
            },
        },
        columns: [
            {
                data: "lot_nombre",
                name: "lot_nombre",
                orderable: false,
                searchable: false,
            },
            {
                data: "total_venta",
                name: "total_venta",
                orderable: false,
                searchable: false,
            },
            {
                data: "total_venta_promo",
                name: "total_venta_promo",
                orderable: false,
                searchable: false,
            },
            {
                data: "total_comision",
                name: "total_comision",
                orderable: false,
                searchable: false,
            },
            {
                data: "total_premios",
                name: "total_premios",
                orderable: false,
                searchable: false,
            },
            {
                data: "total_premios_promo",
                name: "total_premios_promo",
                orderable: false,
                searchable: false,
            },
            {
                data: "tic_ganancia",
                name: "tic_ganancia",
                orderable: false,
                searchable: false,
            },
        ],
        footerCallback: function (row, data, start, end, display) {
            var totalesVenta = 0;
            var totalesPromocion = 0;
            var totalesComision = 0;
            var totalesPremios = 0;
            var totales_premios_promocion = 0;
            var totalesGanancia = 0;

            for (var r in data) {
                
                totalesVenta += $(data[r].total_venta).data('orig-value')
                    ? parseFloat($(data[r].total_venta).data('orig-value'))
                    : 0;
                totalesPromocion += $(data[r].total_venta_promo).data('orig-value')
                    ? parseFloat($(data[r].total_venta_promo).data('orig-value'))
                    : 0;
                totalesComision += $(data[r].total_comision).data('orig-value')
                    ? parseFloat($(data[r].total_comision).data('orig-value'))
                    : 0;
                totalesPremios += $(data[r].total_premios).data('orig-value')
                    ? parseFloat($(data[r].total_premios).data('orig-value'))
                    : 0;
                totales_premios_promocion += $(data[r].total_premios_promo).data('orig-value')
                    ? parseFloat($(data[r].total_premios_promo).data('orig-value'))
                    : 0;
                totalesGanancia += $(data[r].tic_ganancia).data('orig-value')
                    ? parseFloat($(data[r].tic_ganancia).data('orig-value'))
                    : 0;
            }

            $(".totalesVenta").html(__currency_trans_from_en(totalesVenta));
            $(".totalesPromocion").html(__currency_trans_from_en(totalesPromocion));
            $(".totalesComision").html(__currency_trans_from_en(totalesComision));
            $(".totalesPremios").html(__currency_trans_from_en(totalesPremios));
            $(".totales_premios_promocion").html(
                __currency_trans_from_en(totales_premios_promocion)
            );
            $(".totalesGanancia").html(__currency_trans_from_en(totalesGanancia));
        },
        fnDrawCallback: function (oSettings) {
            __currency_convert_recursively($("#ventas_mes"));
        },
    });
});


function getTotales(start, end) {
    var bancas_id = "";
    if ($("#bancas_id").length > 0) {
        bancas_id = $("#bancas_id").val();
    }
    var data = { start: start, end: end, bancas_id: bancas_id };

    var loader =
        '<div class ="text-center"><div class ="spinner-border"><span class="sr-only">...Cargando</span></div></div>';

    $(".totalTickets").html(loader);
    $(".totalVenta").html(loader);
    $(".totalComision").html(loader);
    $(".totalPremios").html(loader);

    $.ajax({
        method: "get",
        url: "/dashboard/getTotales",
        dataType: "json",
        data: data,
        success: function (data) {
            $(".totalTickets").html(__number_uf(data.totalTickets));
            $(".totalVenta").html(
                __currency_trans_from_en(data.totalVenta, true)
            );

            // //sell details
            $(".totalComision").html(
                __currency_trans_from_en(data.totalComision, true)
            );
            $(".totalPremios").html(
                __currency_trans_from_en(data.totalPremios, true)
            );
        },
    });
}

function getResultadosFecha() {
    if ($("input#reportrange").val()) {
        start = $("input#reportrange")
            .data("daterangepicker")
            .startDate.format("YYYY-MM-DD");
        end = $("input#reportrange")
            .data("daterangepicker")
            .endDate.format("YYYY-MM-DD");
    }

    var data = { start_date: start, end_date: end };

    var loader =
        '<div class ="text-center"><div class ="spinner-border"><span class="sr-only">...Cargando</span></div></div>';

    $(".resultado_fecha").html(loader);

    $.ajax({
        method: "GET",
        url: "/dashboard/getResultadosFecha",
        dataType: "html",
        data: data,
        success: function (data) {
            $(".resultado_fecha").html(data);
        },
    });
}

