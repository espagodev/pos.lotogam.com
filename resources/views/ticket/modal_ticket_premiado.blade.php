<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myExtraLargeModalLabel">Ticket Premiado # {{ $ticket->invoice_no }}  Para el Sorteo del  ( {{ $ticket->invoice_date }} )</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            @include('ticket.partials.ticket_premiado')
        </div>
        <div class="modal-footer">
            <input type="hidden" id="tickets_id" name="tickets_id" value="{{ $ticketId }}">
            <a href="#" data-href="{{route('getPagarPremio')}}" class="pagarPremio btn btn-success" ><i class="icon-local_atm" aria-hidden="true"></i> Realizar Pago</a>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            
        </div>
    </div>
</div>
