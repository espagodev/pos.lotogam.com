$(document).ready(function () {
    $(function() {
        $(".btnGenerarCopia").click(function() {   

            html2canvas(document.getElementById('receipt_imagen')).then(function(canvas) {
                // document.body.appendChild(canvas);
                var a = document.createElement('a');
                      // toDataURL defaults to png, so we need to request a jpeg, then convert for file download.
                      a.href = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
                      a.download = Math.random()+'.png';
                      a.click();
               });

        });
    });
});