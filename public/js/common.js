$(document).on("submit", "form", function (e) {
    if (!__is_online()) {
        e.preventDefault();
        toastr.error("No estas conectada a una red");
        return false;
    }

    $(this).find('button[type="submit"]').attr("disabled", true);
});

$(document).ready(function () {

    __progressBar();

    window.addEventListener('online',  updateOnlineStatus);
    window.addEventListener('offline', updateOnlineStatus);

    $.ajaxSetup({
        beforeSend: function(jqXHR, settings) {
            if (!__is_online()) {
                toastr.error("No estas conectada a una red");
                return false;
            }
            if (settings.url.indexOf('http') === -1) {
                settings.url = base_path + settings.url;
            }
        },
    });

    //Establecer la moneda global que se utilizará en la aplicación

    __currency_symbol = $("input#__symbol").val();
    __currency_thousand_separator = $("input#__thousand").val();
    __currency_decimal_separator = $("input#__decimal").val();
    __currency_symbol_placement = $("input#__symbol_placement").val();
    if ($("input#__precision").length > 0) {
        __currency_precision = $("input#__precision").val();
    } else {
        __currency_precision = 2;
    }

    if ($("input#__quantity_precision").length > 0) {
        __quantity_precision = $("input#__quantity_precision").val();
    } else {
        __quantity_precision = 2;
    }

    //Establezca la moneda de nivel de página que se utilizará para algunas páginas. (Página de compra)
    if ($("input#p_symbol").length > 0) {
        __p_currency_symbol = $("input#p_symbol").val();
        __p_currency_thousand_separator = $("input#p_thousand").val();
        __p_currency_decimal_separator = $("input#p_decimal").val();
    }

    __currency_convert_recursively($(document), $("input#p_symbol").length);

    //Toastr setting
    toastr.options.preventDuplicates = true;
    toastr.options.timeOut = "3000";

    //Play notification sound on success, error and warning
    toastr.options.onShown = function () {
        if ($(this).hasClass("toast-success")) {
            var audio = $("#success-audio")[0];
            if (audio !== undefined) {
                audio.play();
            }
        } else if ($(this).hasClass("toast-error")) {
            var audio = $("#error-audio")[0];
            if (audio !== undefined) {
                audio.play();
            }
        } else if ($(this).hasClass("toast-warning")) {
            var audio = $("#warning-audio")[0];
            if (audio !== undefined) {
                audio.play();
            }
        } else if ($(this).hasClass("toast-info")) {
            var audio = $("#warning-audio")[0];
            if (audio !== undefined) {
                audio.play();
            }
        }
    };

    //Datables

    // var buttons = [
    //     {
    //         extend: 'copy',
    //         text: '<i class="fa fa-files-o" aria-hidden="true"></i> ' + "Copiar",
    //         className: 'bg-info',
    //         exportOptions: {
    //             columns: ':visible',
    //         },
    //         footer: true,
    //     },
    //     {
    //         extend: 'csv',
    //         text: '<i class="fa fa-file-text-o" aria-hidden="true"></i> ' + "Exportar a CSV",
    //         className: 'bg-info',
    //         exportOptions: {
    //             columns: ':visible',
    //         },
    //         footer: true,
    //     },
    //     {
    //         extend: 'excel',
    //         text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i> ' + "Exportar a Excel",
    //         className: 'bg-info',
    //         exportOptions: {
    //             columns: ':visible',
    //         },
    //         footer: true,
    //     },
    //     {
    //         extend: 'print',
    //         text: '<i class="fa fa-print" aria-hidden="true"></i> ' + "Impresión",
    //         className: 'bg-info',
    //         exportOptions: {
    //             columns: ':visible',
    //             stripHtml: false,
    //         },
    //         footer: true,
    //     },
    //     {
    //         extend: 'colvis',
    //         text: '<i class="fa fa-columns" aria-hidden="true"></i> ' + "Visibilidad de columna",
    //         className: 'bg-info',
    //     },
    // ];

    // var pdf_btn = {
    //     extend: 'pdf',
    //     text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> ' + "Exportar a PDF",
    //     className: 'bg-info',
    //     exportOptions: {
    //         columns: ':visible',
    //     },
    //     footer: true,
    // };

    jQuery.extend($.fn.dataTable.defaults, {
        fixedHeader: true,
        dom: '<"row margin-bottom-20 text-center"<"col-sm-2"l><"col-sm-7"B><"col-sm-3"f> r>tip',
        // buttons: buttons,
        aLengthMenu: [
            [25, 50, 100, 200, 500, 1000, -1],
            [25, 50, 100, 200, 500, 1000, "Todas"],
        ],
        iDisplayLength: __datos_pagina_predeterminado,
        // iDisplayLength: 25,
        language: {
            searchPlaceholder: "Buscar...",
            search: "",
            lengthMenu: "Mostrando" + " _MENU_ " + "Entradas",
            emptyTable: "No hay datos disponibles para mostrar",
            info: "Mostrando _START_ a _END_ de _TOTAL_ entradas",
            infoEmpty: "Mostrando 0 a 0 de 0 entradas",
            loadingRecords: "Cargando...",
            processing: "Processando...",
            zeroRecords: "Mostrando 0 a 0 de 0 entradas",
            paginate: {
                first: "Primero",
                last: "Ultimo",
                next: "Siguiente",
                previous: "Anterior",
            },
        },
    });

        //Se utiliza para el ticket
        $(document).on('click', 'a.print-invoice', function (e) {
            e.preventDefault();
            // var href = $(this).data('href') + "?ticket_copia=true";
            var href = $(this).data('href');
           
            $.ajax({
                method: 'GET',
                url: href,
                dataType: 'json',
                success: function (result) {
    
                    if (result.success == 1 && result.receipt.html_content != '') {
                        $('#receipt_section').html(result.receipt.html_content);
    
                        __currency_convert_recursively($('#receipt_section'));
                        __print_receipt('receipt_section');
                    } else {
                        toastr.error(result.mensaje);
                    }
                },
            });
        });


        $(function() {
            $(".btnGenerarTicket").click(function() {   
                html2canvas(document.getElementById('receipt')).then(function(canvas) {
                    // document.body.appendChild(canvas);
                    var a = document.createElement('a');
                          // toDataURL defaults to png, so we need to request a jpeg, then convert for file download.
                          a.href = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
                          a.download = Math.random()+'.png';
                          a.click();
                   });
    
            });
        });

        //anular ticket
    $(document).on('click', '.anularTicket', function(e) {

        var tickets_id = $('#tickets_id').val();
        var pin = $('#tic_pin').val();
        var detalle = $('#tia_detalle').val();

        $(this).prop("disabled", true);
        $(this).html(
            `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`
        );
        var data = { tickets_id: tickets_id, pin: pin, detalle: detalle };

            $.ajax({
                method: 'GET',
                url: $(this).data('href'),
                
                dataType: 'json',
                data: data,
                success: function(result) {
                    if (result.success == true) {

                            $('div.view_ticket_modal').modal('hide');
                            $('div.view_register').modal('hide');
                            toastr.success(result.msg);     

                    } else {
                        toastr.error(result.msg); 
                    }
                }
            });
    });
    
});

//Configuración predeterminada para daterangePicker
var ranges = {};
ranges["Hoy"] = [moment(), moment()];
ranges["Ayer"] = [moment().subtract(1, "days"), moment().subtract(1, "days")];
ranges["Los últimos 7 días"] = [moment().subtract(6, "days"), moment()];
ranges["Últimos 30 días"] = [moment().subtract(29, "days"), moment()];
ranges["Este mes"] = [moment().startOf("month"), moment().endOf("month")];
ranges["El mes pasado"] = [
    moment().subtract(1, "month").startOf("month"),
    moment().subtract(1, "month").endOf("month"),
];
ranges["Este año"] = [moment().startOf("year"), moment().endOf("year")];

var dateRangeSettings = {
    ranges: ranges,
    
    locale: {
        cancelLabel: "Borrar",
        applyLabel: "Aplicar",
        customRangeLabel: "Rango personalizado",
        format: moment_date_format,
        toLabel: "~",
    },
};


function updateOnlineStatus(){ 
    if (!__is_online()) {
        $('#status').removeClass('online');
        $('#status').addClass('busy');
    } else {
        $('#status').removeClass('busy');
        $('#status').addClass('online');
    }
};

