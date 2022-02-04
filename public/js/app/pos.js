document
    .getElementById("tid_valor")
    .addEventListener("keydown", inputCharacters);

function inputCharacters(event) {
    if (event.keyCode == 13) {
        document.getElementById("tid_apuesta").focus();
    }
}

$(document).ready(function () {

    pos_form_obj = $("form#add_pos_sell_form");

    if ($("input#product_row_count").length > 0) {
        initialize_printer();
    }
    

    function initialize_printer() {
        if (__datos_tipo_impresora == 'printer') {
            
            initializeSocket();
        }
    }

    horarioLoteriasDia();
    horarioSuperPale();
    MostrarJugadas();
    __progressBar();

    //Finalizar sin mostrar opciones de pago
    $("button.pos-express-finalize").click(function () {
        pos_form_obj.submit();
    });

    //Cancelar ticket
    $("button#pos-cancel").click(function () {
        reset_pos_form();
    });

    //VALIDA EL MONTO Y NUMERO PARA SER INGRESADOS

    $("#tid_apuesta").keydown(function(event) {
        if ($("input[name='lot_id[]']:checked").length >= 1) {
            var bancas_id = $("input#bancas_id").val();
            var users_id = $("input#users_id").val();
            var loterias_id = $("input[name='lot_id[]']:checked")
                .map(function() {
                    return this.value;
                })
                .get();
            var numero = $("input[name=tid_apuesta]").val();
            var valor = $("input[name=tid_valor]").val();

            __validarLoteriaSelecconada(
                bancas_id,
                users_id,
                loterias_id,
                numero,
                valor
            );
        }
    });

    

    //crear jugada
    $("#tid_valor, #tid_apuesta").keydown(function (event) {
        var numero = $("input[name=tid_apuesta]").val();
        var valor = $("input[name=tid_valor]").val();
        var bancas_id = $("input#bancas_id").val();
        var users_id = $("input#users_id").val();
        var loterias_id = $("input[name='lot_id[]']:checked")
                .map(function () {
                    return this.value;
                })
                .get();

        if (event.keyCode == 13 && numero != "" && valor != "") {
            $.when(
                $.ajax({
                    async: false,
                    url: "/pos/postApuestaTemporal",
                    method: "get",
                    dataType: "json",
                    data: {
                        tid_apuesta: numero,
                        tid_valor: valor,
                        bancas_id: bancas_id,
                        users_id: users_id,
                        loterias_id: loterias_id,
                    },
                })
            ).then(function (result) {
                if (result.status == "NumeroCaliente") {
                    $("input[name=tid_apuesta]").focus();
                    toastr.warning(result.mensaje);
                }
                if (result.status == 1) {
                    $("input[name=tid_valor]").focus().val("");
                    $("input[name=tid_apuesta]").val("");
                    toastr.error(result.mensaje);
                }
                if (result.status == 2) {
                    
                    $("input[name=tid_valor]").focus().val("");
                    toastr.error(result.mensaje);
                }

                if (result.status == "LimiteSuperado") {
                    $("input[name=tid_valor]").focus();
                    toastr.warning(result.mensaje);
                }
                if (result.status == "Comision") {
                    $("input[name=tid_valor]").focus();
                    toastr.warning(result.mensaje);
                }
                if (result.status == "montoIndividual") {
                    $("input[name=tid_valor]").focus();
                    toastr.warning(result.mensaje);
                }
                if (result.status == "montoGlobal") {
                    $("input[name=tid_valor]").focus();
                    toastr.info(result.mensaje);
                }
                if (result.status == "success") {
                    $("input[name=tid_apuesta]").val("");
                    $("input[name=tid_valor]").focus().val("");
                    MostrarJugadas();
                }
            });
        } else if (event.keyCode == 13 && numero != "" && valor == "") {
            $("input[name=tid_valor]").focus();
        } else if (event.keyCode == 13 && numero == "" && valor == "") {
            $("input[name=tid_valor]").focus();
        }
    });

    //BORRAR jugada
    $(document).ready(function () {
        $(document).on("click", ".borrar", function () {
            var id = $(this).attr("data-record-id");

            $.when(
                $.ajax({
                    async: false,
                    url: "/pos/eliminarApuestaTemporal",
                    method: "get",

                    data: {
                        apuesta_id: id,
                    },
                })
            ).then(function (resp) {
                if (resp.status == "success") {
                    $("input[name=tid_apuesta]").val("");
                    $("input[name=tid_valor]").focus().val("");
                    MostrarJugadas();
                    toastr.success(resp.message);
                }
                if (resp.status == "error") {
                    toastr.error(resp.message);
                }
            });
        });
    });

    //VALIDAR TICKET PARA GENERAR
    $("button.pos-validar, button.pos-generar").click(function () {
        //Compruebe si hay almenos una apuesta.
        if ($("table#pos_table tbody").find(".product_row").length <= 0) {
            toastr.warning("Agregue Algunas Jugadas Primero.");
            $('.pos-generar').prop("disabled", false);
            $('.pos-express-finalize').prop("disabled", false);
            return false;
            
        }
    });

    $("button.pos-generar").click(function() {
  
        
        var price_total = 0;
        var total_payable = 0;

        $("table#pos_table tbody tr").each(function () {
            price_total =
                price_total + __read_number($(this).find("input.pos_line_total"));
        });

        var loterias = $("input[name='lot_id[]']:checked")
            .map(function() {
                return this.value;
            })
            .get();

        var loterias = $("input[name='lot_id[]']:checked")
            .map(function() {
                return this.value;
            })
            .get();
        var product_row = $("input#product_row_count").val();
        var promocion = $("input[name='tic_promocion']:checked").val();
        var agrupado = $("input[name='tic_agrupado']:checked").val();
        var tic_fecha_sorteo = $("input#tic_fecha_sorteo").val();
        var token = $('meta[name="csrf-token"]').attr("content");
        var getImagen = 1;

        
        if (loterias.length == 0) {
            total_payable = 0;
        } else {
            total_payable = price_total * loterias.length;
        }           
        
        var totalTickets = total_payable;

        $.ajax({
            method: "get",
            url: $("#add_pos_sell_form").attr("action"),
            dataType: "json",
            data: {
                product_row: product_row,
                _token: token,
                loterias_id: loterias,
                tic_promocion: promocion,
                tic_fecha_sorteo: tic_fecha_sorteo,
                tic_agrupado: agrupado,
                getImagen: getImagen,
                totalTickets: totalTickets
            },
            
            success: function(result) {

                if (result.success == true) {

                    var receipt = result.receipt.html_content;      
                               
                    $("#receipt_section_generar").html(receipt);
                    $("#generarModal").modal("show");
                    
                    toastr.success(result.mensaje);

                    reset_pos_form();
                    horarioLoteriasDia();
                    horarioSuperPale();
                    __progressBar();
                } else {
                    toastr.error(result.mensaje);
                    horarioLoteriasDia();
                    horarioSuperPale();
                }

                $("div.pos-processing").hide();
                $("#pos-save").removeAttr("disabled");
                $("span#total_payable").text(
                    __currency_trans_from_en(0, true)
                );
                $("span#total_loterias").text(0);
                $("input[name='tic_promocion']").each(function() {
                    this.checked = false;
                });
                $("input[name='tic_agrupado']").prop("disabled", true);
                $("input[name='tic_agrupado']").each(function() {
                    this.checked = false;
                });
                // enable_pos_form_actions();
            }
        });
        $("input[name=tid_valor]").focus();
        return false;
    });

    pos_form_obj.validate({
        submitHandler: function(form) {         
           
            var price_total = 0;
            var total_payable = 0;

            $("table#pos_table tbody tr").each(function () {
                price_total =
                    price_total + __read_number($(this).find("input.pos_line_total"));
            });

            var loterias = $("input[name='lot_id[]']:checked")
                .map(function() {
                    return this.value;
                })
                .get();

            var product_row = $("input#product_row_count").val();
            var promocion = $("input[name='tic_promocion']:checked").val();
            var agrupado = $("input[name='tic_agrupado']:checked").val();
            var tic_fecha_sorteo = $("input#tic_fecha_sorteo").val();
            var token = $('meta[name="csrf-token"]').attr("content");
            var getImagen = 0;
           
            
            if (loterias.length == 0) {
                total_payable = 0;
            } else {
                total_payable = price_total * loterias.length;
            }           
            
            var totalTickets = total_payable;
           
            var url = $(form).attr("action");

            $('.pos-generar').prop("disabled", true);
            $('.pos-express-finalize').prop("disabled", true);

            $.ajax({
                method: "get",
                url: url,
                data: {
                    product_row: product_row,
                    _token: token,
                    loterias_id: loterias,
                    tic_promocion: promocion,
                    tic_fecha_sorteo: tic_fecha_sorteo,
                    tic_agrupado: agrupado,
                    getImagen: getImagen,
                    totalTickets: totalTickets
                },
                dataType: "json",
                success: function(result) {
                   
                    var receipt = result.receipt;
                       
                    if (result.success == 1) {
                        toastr.success(result.mensaje);
                       
                        reset_pos_form();
                        horarioLoteriasDia();
                        horarioSuperPale();
                        __progressBar();                        
                        __pos_print(receipt);
                       
                        
                    } else {
                        toastr.error(result.mensaje);
                        horarioLoteriasDia();
                        horarioSuperPale();
                    }

                    $("div.pos-processing").hide();
                    $("#pos-save").removeAttr("disabled");
                    $("span#total_payable").text(
                        __currency_trans_from_en(0, true)
                    );
                    $("span#total_loterias").text(0);
                    $("input[name='tic_promocion']").each(function() {
                        this.checked = false;
                    });
                    $("input[name='tic_agrupado']").prop("disabled", true);
                    $("input[name='tic_agrupado']").each(function() {
                        this.checked = false;
                    });
                    $('.pos-generar').prop("disabled", false);
                    $('.pos-express-finalize').prop("disabled", false);
                }
            });

            $("input[name=tid_valor]").focus();
            return false;
        }
    });

    //pagar premio
    $(document).on('click', '.pagarPremio', function(e) {

        var tickets_id = $('#tickets_id').val();
        var pin = $('#tic_pin').val();
        var premio = $('#tic_ganado').val();

        var data = { tickets_id: tickets_id, pin: pin, premio: premio };

        $(this).prop("disabled", true);
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
                            $('div.view_ticket_modal').modal('hide');
                            // $('div.view_register').modal('hide');
                            toastr.success(result.msg);                           
                        } else {
                            toastr.error(result.msg);                            
                        }
                }
            });
    });

   


});

//validar loterias seleccionadas
$(document).on('click', '.validar_jugada_loteria', function(){

    var loterias_id = $(this).attr("data-loterias_id");
    var lot_superpale = $(this).attr("data-superpale");
    var product_row = $("input#product_row_count").val()


    if (product_row >= 1) {
        // __validarMontos(loterias_id,  lot_superpale ); 
        $.ajax({
            type: "get",
            url: '/pos/getvalidarLoteriaIndividual',
            dataType: 'json',
            data: {              
                loteriaId: loterias_id,
                lotSuperpale: lot_superpale
            },
            success: function (result) {
               
            if (result.status == 1) {
                $("input[name=tid_valor]").focus().val("");
                toastr.error(result.mensaje);
            }
            if (result.status == 2) {
                $("input[name=tid_valor]").focus().val("");
                $("input[name=tid_apuesta]").val("");
                toastr.error(result.mensaje);
            }
            },
        });
       }
    
});

$(document).on("shown.bs.modal", "#generarModal", function() {});

function reset_pos_form() {
    var banca = $("input#bancas_id").val();
    var usuario = $("input#users_id").val();

    $.when(
        $.ajax({
            async: false,
            url: "/pos/deleteApuestaTemporal",
            method: "get",
            data: {
                banca: banca,
                usuario: usuario,
            },
        })
    ).then(function (resp) {
        if (resp.status == "success") {
            $("input[name=tid_apuesta]").val("");
            $("input[name=tid_valor]").focus().val("");
            toastr.success(resp.msg);
        }
        if (resp.status == "error") {
            toastr.error(resp.msg);
        }
        MostrarJugadas();
    });
}

function pos_total_ticket() {

    var price_total = 0;
    var total_payable = 0;


    $("table#pos_table tbody tr").each(function () {
        price_total =
            price_total + __read_number($(this).find("input.pos_line_total"));
    });

    $("span.price_total").text(__currency_trans_from_en(price_total, true));

    $("input[name='lot_id[]']").on("click", function () {
        var checked = $("input[name='lot_id[]']:checked").length;
       
        if (checked == 0) {
            total_payable = 0;
        } else {
            total_payable = price_total * checked;
        }

        $("span#total_payable").text(
            __currency_trans_from_en(total_payable, true)
        );

        $("span#total_loterias").text(checked);
       
    });

    return total_payable;
}

//MOSTRAR JUGADAS
function MostrarJugadas() {
    var banca = $("input#bancas_id").val();
    var usuario = $("input#users_id").val();
    $.ajax({
        url: "/pos/getApuestaTemporal",
        method: "get",
        dataType: "json",
        data: {
            banca: banca,
            usuario: usuario,
        },
        success: function (result) {
            $("table#pos_table tbody").html(result.ticketDetalles);

            $("input#product_row_count").val(result.row_count);

            $("span.total_quantity").each(function () {
                $(this).html(__number_f(result.row_count));
            });

            var this_row = $("table#pos_table tbody").find("tr");

            __currency_convert_recursively(this_row);
            pos_total_ticket();
            // activarLoterias(result.row_count);
        },
    });
}

//LOTERIAS
function horarioLoteriasDia() {
    var bancas_id = $("#bancas_id").val();

    // var data = { bancas_id: bancas_id };

    var loader = '<i class="icon-refresh-ccw"></i>';

    $(".loterias").html(loader);

    $.ajax({
        method: "GET",
        url: "/pos/getHorarioLoterias",
        dataType: "html",
        // data: data,
        success: function (data) {
            $(".loterias").html(data);
        },
    });
}

function horarioSuperPale() {
    var bancas_id = $("#bancas_id").val();
    // var data = { bancas_id: bancas_id };

    var loader = '<i class="icon-refresh-ccw"></i>';
    $(".superPale").html(loader);

    $.ajax({
        method: "GET",
        url: "/pos/getHorarioSuperPale",
        dataType: "html",
        // data: data,
        success: function (data) {
            $(".superPale").html(data);
        },
    });
}

//valid cuando ya hay loterias seleccionadas
function __validarLoteriaSelecconada(
    bancas_id,
    users_id,
    loterias_id,
    numero,
    valor
) {
    $.when(
        $.ajax({
            type: "get",
            url: "/pos/validarLoteriaSeleccionada",
            dataType: "json",
            data: {
                bancas_id: bancas_id,
                users_id: users_id,
                loterias_id: loterias_id,
                tid_apuesta: numero,
                tid_valor: valor,
            },
        })
    ).then(function (result) {
        
        if (result.status == 1) {
            $("input[name=tid_valor]").focus().val("");
            toastr.error(result.mensaje);
        }
        if (result.status == 2) {
            $("input[name=tid_valor]").focus().val("");
            $("input[name=tid_apuesta]").val("");
            toastr.error(result.mensaje);
        }

        
    });
}

//Valida loterias al momento de seleccionarlas
function __validarMontos(loterias_id,  lot_superpale) {


    $.ajax({
        type: "get",
        url: '/pos/getvalidarLoteriaIndividual',
        dataType: 'json',
        data: {              
            loteriaId: loterias_id,
            lotSuperpale: lot_superpale
        },
        success: function (result) {
           
        if (result.status == 1) {
            $("input[name=tid_valor]").focus().val("");
            toastr.error(result.mensaje);
        }
        if (result.status == 2) {
            $("input[name=tid_valor]").focus().val("");
            $("input[name=tid_apuesta]").val("");
            toastr.error(result.mensaje);
        }
        },
    });
 
    //     $.ajax({

    //         type: "get",
    //         url: '/pos/getvalidarLoteriaIndividual',
    //         dataType: 'json',
    //         data: {              
    //             loteriaId: loterias_id,
    //             lotSuperpale: lot_superpale
    //         },
    //     })
    //     success: function (result) {
    // ).then(function (result) {

    //     if (result.status == 1) {
    //         $("input[name=tid_valor]").focus().val("");
    //         toastr.error(result.mensaje);
    //     }
    //     if (result.status == 2) {
    //         $("input[name=tid_valor]").focus().val("");
    //         $("input[name=tid_apuesta]").val("");
    //         toastr.error(result.mensaje);
    //     }

    // });

}

//agrupado
$(document).click(function() {
    var checked = $("input[name='lot_id[]']:checked").length;
    if (checked > 1) {
        $("input[name='tic_agrupado']").prop("disabled", false);
    } else {
        $("input[name='tic_agrupado']").prop("disabled", true);
        $("input[name='tic_agrupado']").each(function() {
            this.checked = false;
        });
    }
});
