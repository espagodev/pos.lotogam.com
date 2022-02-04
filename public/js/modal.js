$(document).ready(function () {
    // $(".view_register").on("shown.bs.modal", function () {
       
    // });

    $(document).on("click", ".btn-modal", function (e) {
        e.preventDefault();
        var container = $(this).data("container");
        $.ajax({
            url: $(this).data("href"),
            dataType: "html",
            success: function (result) {
                $(container).html(result).modal("show");
            },
        });
    });
});



$(document).on('click', '.view_ticket_modal', function(e) {
    e.preventDefault();
    var container = $('.ticket_modal'); 

    $.ajax({
        url: $(this).attr('href'),
        dataType: 'html',
        success: function(result) {
            $(container)
                .html(result)
                .modal('show');
            __currency_convert_recursively(container);
        },
    });
});