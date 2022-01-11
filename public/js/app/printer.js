var socket = null;
var socket_host = 'ws://127.0.0.1:6441';

initializeSocket = function() {   
    try {
       
        if (socket == null) {           
            socket = new WebSocket(socket_host);
            socket.onopen = function() {
                var print = ' <h4 class=" text-success"><i class="icon-print"></i></h4> ';
                $(".print").html(print);
            };
            socket.onmessage = function(msg) {};
            socket.onclose = function() {
                var print = '<h4 class=" text-danger"><i class="icon-print"></i></h4> ';
                $(".print").html(print);
                socket = null;
            };
        }

    } catch (e) {
        console.log(e);
    }
};
