$(document).ready(function() {

    if ($("#report_range").length == 1) {
        $("#report_range").daterangepicker(dateRangeSettings, function(start,end) {
            $("#report_range span").val(start.format(moment_date_format) + " ~ " +  end.format(moment_date_format));
            
            reporte_ventas.ajax.reload();
            
        });

        $("#report_range").on("cancel.daterangepicker", function(ev,picker) {
            $("#report_range").val("");            
            reporte_ventas.ajax.reload();

        });

    }

    $('#reporte_ventas,  #loterias_modal_id').change(
        function() {
            reporte_ventas.ajax.reload();
        }
    );

    $('.view_register').on('shown.bs.modal', function () {
        __currency_convert_recursively($(this));
    });

    $(function() {
        $(".btnReporteVentas").click(function() {          
            html2canvas(document.getElementById('reporte_ventas')).then(function(canvas) {
                // document.body.appendChild(canvas);
                var a = document.createElement('a');
                      // toDataURL defaults to png, so we need to request a jpeg, then convert for file download.
                      a.href = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
                      a.download = 'reporte_ventas.png';
                      a.click();
               });

        });
    });
    
       //Reporte de ventas mes
       reporte_ventas =  $('#reporte_ventas').DataTable({
        processing: true,
        serverSide: true,
        aaSorting: false,
        searching: false,
        paging:    false,
        ajax: {
                url: '/reportes/getListaReporteVentas',
                dataType: "json",
                data: function(d) {

                d.loterias_id = $('select#loterias_modal_id').val();               

                var start = '';
                var end = '';
                if ($('input#report_range').val()) {
                    start = $('input#report_range')
                        .data('daterangepicker')
                        .startDate.format('YYYY-MM-DD');
                    end = $('input#report_range')
                        .data('daterangepicker')
                        .endDate.format('YYYY-MM-DD');
                }
                d.start_date = start;
                d.end_date = end;
            },
        },
        columns: [
                { data: 'lot_nombre', name: 'lot_nombre', orderable: false, searchable: false  },
                { data: 'total_venta', name: 'total_venta', orderable: false, searchable: false  },
                { data: 'total_venta_promo', name: 'total_venta_promo', orderable: false, searchable: false  },
                { data: 'total_comision', name: 'total_comision', orderable: false, searchable: false  },
                { data: 'total_premios', name: 'total_premios', orderable: false, searchable: false  },       
                { data: 'total_premios_promo', name: 'total_premios_promo' , orderable: false, searchable: false  },
                { data: 'tic_ganancia', name: 'tic_ganancia' , orderable: false, searchable: false  },
         ],
         footerCallback: function (row, data, start, end, display) {
           
            var totalVenta = 0;
            var totalPromocion = 0;
            var totalComision = 0;
            var totalPremios = 0;
            var total_premios_promocion = 0;
            var totalGanancia = 0;

            for (var r in data){               
                totalVenta +=  $(data[r].total_venta).data('orig-value') ? parseFloat($(data[r].total_venta).data('orig-value')) : 0;
                totalPromocion += $(data[r].total_venta_promo).data('orig-value') ? parseFloat($(data[r].total_venta_promo).data('orig-value')) : 0; 
                totalComision += $(data[r].total_comision).data('orig-value') ? parseFloat($(data[r].total_comision).data('orig-value')) : 0;                
                totalPremios += $(data[r].total_premios).data('orig-value') ? parseFloat($(data[r].total_premios).data('orig-value')) : 0;
                total_premios_promocion += $(data[r].total_premios_promo).data('orig-value') ? parseFloat($(data[r].total_premios_promo).data('orig-value')) : 0; 
                totalGanancia += $(data[r].tic_ganancia).data('orig-value') ? parseFloat($(data[r].tic_ganancia).data('orig-value')) : 0;   
            }

            $('.totalVenta').html(__currency_trans_from_en(totalVenta));
            $('.totalPromocion').html(__currency_trans_from_en(totalPromocion));
            $('.totalComision').html(__currency_trans_from_en(totalComision));
            $('.totalPremios').html(__currency_trans_from_en(totalPremios));
            $('.total_premios_promocion').html(__currency_trans_from_en(total_premios_promocion));
            $('.totalGanancia').html(__currency_trans_from_en(totalGanancia));
         },
        fnDrawCallback: function(oSettings) {
            __currency_convert_recursively($('#reporte_ventas'));
        },
    });

});