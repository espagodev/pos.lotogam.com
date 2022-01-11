<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myExtraLargeModalLabel">Anular Ticket # {{ $ticket->invoice_no }}  Para el Sorteo del  ( {{ $ticket->invoice_date }} )</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            @include('ticket.partials.ticket_anulado')
        </div>
        <div class="modal-footer">
            <input type="hidden" id="tickets_id" name="tickets_id" value="{{ $ticketId }}">
            <a href="#" data-href="{{route('getAnular')}}" class="anularTicket btn btn-danger" ><i class="icon-x-circle" aria-hidden="true"></i> Anular</a>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            
        </div>
    </div>
</div>
