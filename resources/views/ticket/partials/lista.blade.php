<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="accordion" id="withFiltroTicket">							

            <div class="accordion-container">
                <div class="accordion-header" id="withIconFiltroTicket">
                    <a  href="" class="collapsed" data-toggle="collapse" data-target="#collapseFiltroTicket" aria-expanded="false" aria-controls="collapseFiltroTicket">
                        <i class="icon icon-filter"></i>Filtro
                    </a>
                </div>
                <div id="collapseFiltroTicket" class="collapse" aria-labelledby="withIconFiltroTicket" data-parent="#withFiltroTicket">
                    <div class="accordion-body">
                        @include('ticket.partials.filtro')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table id="tickets"  class="table custom-table table-sm">
        <thead>
            <tr>                
                <th>Ticket</th>
                <th>Loteria</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Opciones</th>
            </tr>
        </thead>       
    </table>
</div>
 <script src="{{ asset('js/app/ticket.js?v=' . $asset_v) }}"></script>