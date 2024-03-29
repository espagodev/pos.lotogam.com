$(document).ready(function () {

    if ($("#report_range").length == 1) {
        $("#report_range").daterangepicker(dateRangeSettings, function(start,end) {
            $("#report_range span").val(start.format(moment_date_format) + " ~ " +  end.format(moment_date_format));
            
            tickets_lista.ajax.reload();
            
        });

        $("#report_range").on("cancel.daterangepicker", function(ev,picker) {
            $("#report_range").val("");            
            tickets_lista.ajax.reload();

        });

    }

    $('#tickets_lista,  #loterias_modal_id, #estado, #ticket').change(
        function() {
            tickets_lista.ajax.reload();
        }
    );

    //Reporte de tickets
    tickets_lista = $("#tickets_lista").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: false,
        searching: true,
        ajax: {
            url: "/ticket/getListadoTickets",
            dataType: "json",
            data: function (d) {
                d.loterias_id = $("select#loterias_modal_id").val();
                d.bancas_id = $("select#bancas_id").val();
                d.estado = $("select#estado").val();
                d.promocion = $("select#promocion").val();
                d.users_id = $("select#users_id").val();
                d.ticket = $("input#ticket").val();

                var start = "";
                var end = "";
                if ($("input#report_range").val()) {
                    start = $("input#report_range")
                        .data("daterangepicker")
                        .startDate.format("YYYY-MM-DD");
                    end = $("input#report_range")
                        .data("daterangepicker")
                        .endDate.format("YYYY-MM-DD");
                }
                d.start_date = start;
                d.end_date = end;
            },
        },
        columns: [
            {
                data: "tic_ticket",
                name: "tic_ticket",
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
                data: "tic_fecha_sorteo",
                name: "tic_fecha_sorteo",
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
                data: "tic_estado",
                name: "tic_estado",
                orderable: false,
                searchable: false,
            },
            { data: "action", name: "action" },
        ],
        fnDrawCallback: function (oSettings) {
            __currency_convert_recursively($("#tickets_lista"));
        },
    });
});


 