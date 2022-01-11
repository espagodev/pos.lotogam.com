$(document).ready(function () {

    if ($("#reportrange").length == 1) {
        $("#reportrange").daterangepicker(dateRangeSettings, function(start,end) {
            $("#reportrange span").val(start.format(moment_date_format) + " ~ " +  end.format(moment_date_format));            
            balance_diario_table.ajax.reload();
            movimientos_diarios_datatable.ajax.reload();   
            getCajaGeneral()    
        });

        $("#reportrange").on("cancel.daterangepicker", function(ev,picker) {
            $("#reportrange").val("");            
            balance_diario_table.ajax.reload();
            movimientos_diarios_datatable.ajax.reload();
            getCajaGeneral()
        });
        getCajaGeneral()
    }

    $('#balance_diario_table, #movimientos_diarios_table,  #movimiento_id').change(
        function() {
            balance_diario_table.ajax.reload();
            movimientos_diarios_datatable.ajax.reload();
        }
    );


    balance_diario_table =  $('#balance_diario_table').DataTable({
            processing: true,
            serverSide: true,
            scrollY:        "500px",
            
            scrollCollapse: true,
            paging:         false,
            fixedColumns:   true,
        ajax: {
                url: '/cuadre_caja/getListadoCuadreCaja',
                dataType: "json",
                data: function(d) {

                  
                    d.movimiento_id = $('select#movimiento_id').val();
                    var start = '';
                    var end = '';
                    if ($('input#reportrange').val()) {
                        start = $('input#reportrange')
                            .data('daterangepicker')
                            .startDate.format('YYYY-MM-DD');
                        end = $('input#reportrange')
                            .data('daterangepicker')
                            .endDate.format('YYYY-MM-DD');
                    }
                    d.start_date = start;
                    d.end_date = end;
                },
            },
            columns: [
                {
                    data: "users_id",
                    name: "users_id",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "cgc_balance_inicial",
                    name: "cgc_balance_inicial",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "cgc_total_entradas",
                    name: "cgc_total_entradas",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "cgc_total_salidas",
                    name: "cgc_total_salidas",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "cgc_total_venta",
                    name: "cgc_total_venta",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "cgc_total_venta_neta",
                    name: "cgc_total_venta_neta",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "cgc_total_comisiones",
                    name: "cgc_total_comisiones",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "cgc_total_premios",
                    name: "cgc_total_premios",
                    orderable: false,
                    searchable: false
                },
                
                {
                    data: "cgc_balance_final",
                    name: "cgc_balance_final",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "disponible",
                    name: "disponible",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "cgc_fecha_movimiento",
                    name: "cgc_fecha_movimiento",
                    orderable: false,
                    searchable: false
                }
            ],
            fnDrawCallback: function(oSettings) {
                __currency_convert_recursively(
                    $("#balance_diario_table")
                );
            },
            createdRow: function (row, data, dataIndex) {
                $('td:eq(9)', row).css('background-color', '#9EF395');                
            }
    });

    movimientos_diarios_datatable = $("#movimientos_diarios_table").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: false,
        scrollY:        "500px",
        // scrollX:        true,
        scrollCollapse: true,
        paging:         false,
       

        ajax: {
            url: "/cuadre_caja/getListadoMovimientosDiarios",
            dataType: "json",
            data: function(d) {
                d.bancas_id = $("select#bancas_id").val();
                d.users_id = $("select#users_id").val();
                d.movimiento_id = $("select#movimiento_id").val();

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
            }
        },
        columns: [
            {
                data: "cag_movimiento",
                name: "cag_movimiento",
                orderable: false,
                searchable: false
            },
            {
                data: "cag_fecha_movimiento",
                name: "cag_fecha_movimiento",
                orderable: false,
                searchable: false
            },
            {
                data: "bancas_id",
                name: "bancas_id",
                orderable: false,
                searchable: false
            },
            {
                data: "users_id",
                name: "users_id",
                orderable: false,
                searchable: false
            },
            {
                data: "cag_monto",
                name: "cag_monto",
                orderable: false,
                searchable: false
            },
            {
                data: "cag_nota_movimiento",
                name: "cag_nota_movimiento",
                orderable: false,
                searchable: false
            }
        ],
        fnDrawCallback: function(oSettings) {
            __currency_convert_recursively($("#movimientos_diarios_table"));
        }
    });

    $(function() {
        $(".btnSave").click(function() {          
            html2canvas(document.getElementById('balance_diario_table')).then(function(canvas) {
                // document.body.appendChild(canvas);
                var a = document.createElement('a');
                      // toDataURL defaults to png, so we need to request a jpeg, then convert for file download.
                      a.href = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
                      a.download = 'balanceDiario.png';
                      a.click();
               });

        });
    });

    $(function() {
        $(".btnMovimientos").click(function() {          
            html2canvas(document.getElementById('movimientos_diarios_table')).then(function(canvas) {
                // document.body.appendChild(canvas);
                var a = document.createElement('a');
                      // toDataURL defaults to png, so we need to request a jpeg, then convert for file download.
                      a.href = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
                      a.download = 'movimientos.png';
                      a.click();
               });

        });
    });
});

function getCajaGeneral() {
    var start = $("#reportrange")
        .data("daterangepicker")
        .startDate.format("YYYY-MM-DD");
    var end = $("#reportrange")
        .data("daterangepicker")
        .endDate.format("YYYY-MM-DD");
    var bancas_id = $("#bancas_id").val();

    var data = { start_date: start, end_date: end, bancas_id: bancas_id };

    var loader = '<div class ="text-center"><div class ="spinner-border"><span class="sr-only">...Cargando</span></div></div>';

    $(".balance_inicial").html(loader);
    $(".total_entradas").html(loader);
    $(".total_salidas").html(loader);
    $(".total_cupo").html(loader);
    $(".total_venta").html(loader);
    $(".balance_final").html(loader);

    $.ajax({
        method: "GET",
        url: "/cuadre_caja/getCuadreCajaDetalle",
        dataType: "json",
        data: data,
        success: function(data) { 
            $(".balance_inicial").html(
                __currency_trans_from_en(data.balance_inicial, true)
            );
            $(".total_entradas").html(
                __currency_trans_from_en(data.total_entradas, true)
            );
            $(".total_salidas").html(
                __currency_trans_from_en(data.total_salidas, true)
            );
            $(".total_cupo").html(
                __currency_trans_from_en(data.total_cupo, true)
            );
            $(".total_venta").html(
                __currency_trans_from_en(data.total_venta, true)
            );
            $(".balance_final").html(
                __currency_trans_from_en(data.balance_final, true)
            );
        }
    });
}
