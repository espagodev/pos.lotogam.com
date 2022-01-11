$(document).ready(function () {
    tipo_impresora();

    
       
});

$(document).on('click', '.modificarImpresora', function(e) {

    var ban_tipo_impresora = $('#ban_tipo_impresora').val();
    var impresoras_pos_id = $('#impresoras_pos_id').val();

    var data = { 'ban_tipo_impresora': ban_tipo_impresora, impresoras_pos_id: impresoras_pos_id };

    $(this).html(
        `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`
      );
      $.ajax({
        method: 'GET',
        url: $(this).data('href'),

        dataType: 'json',
        data: data,
        success: function(result) {
             if (result.success === true) {                   
                    $('div.view_register').modal('hide');
                    toastr.info(result.msg);                           
                } else {
                    toastr.error(result.msg);                            
                }
        }
    });
});

function tipo_impresora() {
    if ($("select#ban_tipo_impresora").val() == "printer") {
        $("div#location_printer_div").show();
    } else {
        $("div#location_printer_div").hide();
    }

    $("select#ban_tipo_impresora").change(function () {
        var printer_type = $(this).val();
        if (printer_type == "printer") {
            $("div#location_printer_div").show();
        } else {
            $("div#location_printer_div").hide();
        }
    });
}
