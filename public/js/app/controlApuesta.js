
   $(document).ready(function(){

    if ($("#report_range").length == 1) {
        $("#report_range").daterangepicker(dateRangeSettings, function(start,end) {
            $("#report_range span").val(start.format(moment_date_format) + " ~ " +  end.format(moment_date_format));
            
            controlApuestas.ajax.reload();
            
        });

        $("#report_range").on("cancel.daterangepicker", function(ev,picker) {
            $("#report_range").val("");            
            controlApuestas.ajax.reload();

        });

    }

    $('#controlApuestas,  #loterias_modal_id, #modalidades_id').change(
        function() {
            controlApuestas.ajax.reload();
        }
    );

         //Reporte de tickets 
         controlApuestas =  $('#controlApuestas').DataTable({
            processing: true,
            serverSide: true,
             aaSorting: false,
             searching: false,
            ajax: {
                    url: '/controlApuestas/getControlApuestas',
                    dataType: "json",
                    data: function(d) {
    
                        d.loterias_id = $('select#loterias_modal_id').val();
                        d.modalidades_id = $('select#modalidades_id').val();
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
                { data: 'lot_nombre', name: 'loteria', orderable: false, searchable: false  },
                { data: 'ban_nombre', name: 'ban_nombre', orderable: false, searchable: false  },
                { data: 'mod_nombre', name: 'mod_nombre', orderable: false, searchable: true  },
                { data: 'cnj_numero', name: 'cnj_numero', orderable: false, searchable: false  },
                { data: 'cnj_contador', name: 'cnj_contador', orderable: false, searchable: false  },
                { data: 'cnj_fecha', name: 'cnj_fecha', orderable: false, searchable: false  },
             ],
            fnDrawCallback: function(oSettings) {
                __currency_convert_recursively($('#controlApuestas'));
            },
        });
    });
