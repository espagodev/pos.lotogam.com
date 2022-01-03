$(document).ready(function () {

    if ($("#reportrange").length == 1) {
        $("#reportrange").daterangepicker(dateRangeSettings, function(start,end) {
            $("#reportrange span").val(start.format(moment_date_format) + " ~ " +  end.format(moment_date_format));            
            listado_traslado.ajax.reload();            
        });

        $("#reportrange").on("cancel.daterangepicker", function(ev,picker) {
            $("#reportrange").val("");            
            listado_traslado.ajax.reload();

        });

    }

    $('#listado_traslado,  #loterias_id, #modalidades_id').change(
        function() {
            listado_traslado.ajax.reload();
        }
    );


    listado_traslado =  $('#listado_traslado').DataTable({
        processing: true,
        serverSide: true,
         paging:    false,
         responsive: true,
         searching: false,
        ajax: {
                url: '/traslado/getListadoTraslado',
                dataType: "json",
                data: function(d) {

                    d.loterias_id = $('select#loterias_id').val();
                    d.bancas_id = $('select#bancas_id').val();
                    d.modalidades_id = $('select#modalidades_id').val();
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
                { data: 'lot_nombre', name: 'loteria', orderable: false, searchable: false  },
                { data: 'mod_nombre', name: 'mod_nombre', orderable: false, searchable: false  },
                { data: 'tln_numero', name: 'tln_numero', orderable: false, searchable: false  },
                { data: 'tln_contador', name: 'tln_contador', orderable: false, searchable: false  },  
                { data: 'contador', name: 'contador', orderable: false, searchable: false  },
                { data: 'tln_fecha', name: 'tln_fecha', orderable: false, searchable: false  },
                // { data: 'tln_contador_traslado', name: 'tln_contador_traslado', orderable: false, searchable: false  },
         ],
          fnDrawCallback: function(oSettings) {
           
            __currency_convert_recursively($('#listado_traslado'));
        }
        ,
        createdRow: function( row, data, dataIndex){
            
            if((data["tln_contador_traslado"] != "0") && (data["tln_contador_updated"] == "0"))
            {             
                $('td:eq(4)', row).css('background-color', '#9EF395');    

            } else if((data["tln_contador_traslado"] != "0") && (data["tln_contador_updated"] == "1"))
            {
                $('td:eq(4)', row).css('background-color', '#F3959E');      
            }   
           
        },
        footerCallback: function (row, data, start, end, display) {

            var total_control = 0;
            var total_traslado = 0;


            for (var r in data){               
                total_control +=  parseFloat(data[r].tln_contador) ? parseFloat(data[r].tln_contador) : 0;
                total_traslado += parseFloat(data[r].tln_contador_traslado) ? parseFloat(data[r].tln_contador_traslado) : 0;                
            }
            
            $('.total_control').html(__currency_trans_from_en(total_control));
            $('.total_traslado').html(__currency_trans_from_en(total_traslado));


        }
    });
});

$(document).on('change', 'input.tln_contador_traslado', function() {

    var id = $(this).data('id');
    var traslado = $(`#tln_contador_traslado_${id}`).val();
    
    $.ajax({
        method: "get",
        url: "/traslado/getTrasladoNumero/" + id,
        dataType: 'json',
        data: {           
            tln_contador_traslado: traslado,
        },

        success: function(result) {
            if (result.success == "actualizado") {

                toastr.success(result.msg);


                listado_traslado.ajax.reload();
            } 
            if(result.success == "error") {
                toastr.error(result.msg);
            }
        },
    });
});
