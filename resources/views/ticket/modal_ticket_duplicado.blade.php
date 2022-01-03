<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="vCenterModal">Duplicar Ticket</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            @include('ticket.partials.ticket')
        </div>
        <div class="modal-footer">    
            <a href="{{route('getDuplicarTicket', [$ticketId])}}" class=" btn btn-primary"><i class="fa fa-clone" aria-hidden="true"></i> Duplicar Ticket</a>       
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>