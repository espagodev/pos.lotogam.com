

function __currency_trans_from_en(
    input,
    show_symbol = true,
    use_page_currency = false,
    precision = __currency_precision,
    is_quantity = false
) {
    if (use_page_currency && __p_currency_symbol) {
        var s = __p_currency_symbol;
        var thousand = __p_currency_thousand_separator;
        var decimal = __p_currency_decimal_separator;
    } else {
        var s = __currency_symbol;
        var thousand = __currency_thousand_separator;
        var decimal = __currency_decimal_separator;
    }

    symbol = '';
    var format = '%s%v';
    if (show_symbol) {
        symbol = s;
        format = '%s %v';
        if (__currency_symbol_placement == "after") {
            format = "%v %s";
        }
    }

    if (is_quantity) {
        precision = __quantity_precision;
    }

    return accounting.formatMoney(input, symbol, precision, thousand, decimal, format);
}

function __currency_convert_recursively(element, use_page_currency = false) {
    element.find('.display_currency').each(function () {
        var value = $(this).text();

        var show_symbol = $(this).data('currency_symbol');
        if (show_symbol == undefined || show_symbol != true) {
            show_symbol = false;
        }

        var highlight = $(this).data('highlight');
        if (highlight == true) {
            __highlight(value, $(this));
        }

        var is_quantity = $(this).data('is_quantity');
        if (is_quantity == undefined || is_quantity != true) {
            is_quantity = false;
        }

        if (is_quantity) {
            show_symbol = false;
        }

        $(this).text(__currency_trans_from_en(value, show_symbol, use_page_currency, __currency_precision, is_quantity));
    });
}

//Leer la entrada y convertirla en número natural
function __read_number(input_element, use_page_currency = false) {
    return __number_uf(input_element.val(), use_page_currency);
}

//Desformatea la moneda / número
function __number_uf(input, use_page_currency = false) {
    if (use_page_currency && __currency_decimal_separator) {
        var decimal = __p_currency_decimal_separator;
    } else {
        var decimal = __currency_decimal_separator;
    }

    return accounting.unformat(input, decimal);
}

//Si el valor es positivo, se aplicará la clase text-success; de lo contrario, text-danger
function __highlight(value, obj) {
    obj.removeClass('text-success').removeClass('text-danger');
    if (value > 0) {
        obj.addClass('text-success');
    } else if (value < 0) {
        obj.addClass('text-danger');
    }
}

//Alias de formato de moneda, número de formatos
function __number_f(
    input,
    show_symbol = false,
    use_page_currency = false,
    precision = __currency_precision
) {
    return __currency_trans_from_en(input, show_symbol, use_page_currency, precision);
}



function __is_online() {
    //if localhost always return true
    if ($('#__is_localhost').length > 0) {
        return true;
    }

    return window.navigator.onLine;
}

function __disable_submit_button(element) {
    if (__is_online()) {
        element.attr('disable', true);
    }
}

function incrementImageCounter() {
    img_counter++;
    if (img_counter === img_len) {
        window.print();

    }
}

function __print_receipt(section_id = null) {


    if (section_id) {
        var imgs = document.getElementById(section_id).getElementsByTagName("img");
    } else {
        var imgs = document.images;
    }

    img_len = imgs.length;

    if (img_len) {
        img_counter = 0;

        [].forEach.call(imgs, function (img) {
            img.addEventListener('load', incrementImageCounter, false);
        });
    } else {
        setTimeout(function () {
            window.print();

        }, 1000);
    }
}

//saldo disponible progress bar
function __progressBar() {
    //reset progress bar
    $(".progress-bar").css("width", "0%");
    $(".progress-bar").text("0%");
    $(".progress-bar").attr("data-progress", "0");
    
    $.ajax({
        type: "get",
        dataType: "json",
        url: "/pos/getSaldoDisponible",
        success: function(response) {

            var percentage = response.percentage;
            var total = __currency_trans_from_en(response.total, true);
            var limite = __currency_trans_from_en(response.limite, true);
            var totalVenta = __currency_trans_from_en(response.venta, true);
            var estado = total + " / " + limite;

            $(".progress-bar").css("width", percentage + "%");
            $(".progress-bar").text(percentage + "%");
            $(".progress-bar").attr("data-progress", percentage);
            $(".totalVentas").text(totalVenta);
            $(".progres-estado").text(estado);

            if (percentage >= 0 && percentage <= 80) {
                $(".progress-bar").addClass("bg-success");
            } else if (percentage >= 81 && percentage <= 99) {
                $(".progress-bar").addClass("bg-warning");           
                toastr.warning("Esta por Superar el Limite de Venta");
            } else if (percentage >= 100) {
                $(".progress-bar").addClass("bg-danger");
                toastr.error("Limite de Venta Superado, Por Favor Comuniquese con el Administrador ");
                $("input[name='lot_id[]']").prop("disabled", true);
                $("input[name='tid_valor']").prop("disabled", true);
                $("input[name='tid_apuesta']").prop("disabled", true);
                $('.pos-generar').prop("disabled", true);
                $('.pos-express-finalize').prop("disabled", true);
            }
        }
    });
}

//opcion de impresion
function __pos_print(receipt) {
    //Si es tipo de impresora, conéctese con websocket
   
    if (receipt.print_type == "printer") {
        var content = receipt;
        content.type = "print-receipt";

        //Compruebe si está listo o no, luego imprima.
        if (socket != null && socket.readyState == 1) {
            socket.send(JSON.stringify(content));
        } else {
            initializeSocket();
            setTimeout(function() {
                socket.send(JSON.stringify(content));
            }, 700);
        }
    } else if (receipt.html_content != "") {
        //Si la impresora escribe un navegador, imprima el contenido

        $("#receipt_section").html(receipt.html_content);
        __currency_convert_recursively($("#receipt_section"));
        __print_receipt("receipt_section");
    }
}