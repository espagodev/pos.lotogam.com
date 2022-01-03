$(document).ready(function() {

    if ($("#reportrange").length == 1) {
        $("#reportrange").daterangepicker(dateRangeSettings, function(start,end) {
            $("#reportrange span").val(start.format(moment_date_format) + " ~ " +  end.format(moment_date_format));            
            listado_resultados.ajax.reload();            
        });

        $("#reportrange").on("cancel.daterangepicker", function(ev,picker) {
            $("#reportrange").val("");            
            listado_resultados.ajax.reload();

        });

       
    }

    $('#listado_resultados,  #loterias_id').change(
        function() {
            listado_resultados.ajax.reload();
        }
    );

    //listado de resultados
    listado_resultados =  $('#listado_resultados').DataTable({
        processing: true,
        serverSide: true,
         aaSorting: false,
         searching: false,
        ajax: {
                url: '/resultados/getListadoResultados',
                dataType: "json",
                data: function(d) {

                d.loterias_id = $('select#loterias_id').val();

                var start = '';
                var end = '';
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
                { data: 'lot_nombre', name: 'loteria', orderable: false, searchable: false  },
                { data: 'res_fecha', name: 'res_fecha', orderable: false, searchable: false  },
                { data: 'res_premio1', name: 'res_premio1', orderable: false, searchable: false  },
                { data: 'res_premio2', name: 'res_premio2', orderable: false, searchable: false  },
                { data: 'res_premio3', name: 'res_premio3', orderable: false, searchable: false  },
                { data: 'action', name: 'action'  },
         ],
        fnDrawCallback: function(oSettings) {
            __currency_convert_recursively($('#listado_resultados'));
        },
    });
});

