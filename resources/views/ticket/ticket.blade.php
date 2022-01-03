<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="vCenterModal">Ticket #. {{ $ticket->invoice_no }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            @include('ticket.partials.ticket')
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info btnGenerarCopia"><i class="icon-image"></i> Generar Imagen</button>
            <a href="#" data-href="{{route('getImprimirTicket', [$ticketId])}}" class="print-invoice btn btn-primary" ><i class="icon-printer" aria-hidden="true"></i> Imprimir</a>
      
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>
<script src="{{ asset('js/app/receipt_imagen.js?v=' . $asset_v) }}"></script>