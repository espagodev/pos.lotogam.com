
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="accordion" id="withFiltroControl">							

            <div class="accordion-container">
                <div class="accordion-header" id="withIFiltroControl">
                    <a  href="" class="collapsed" data-toggle="collapse" data-target="#collapseFiltroControl" aria-expanded="false" aria-controls="collapseFiltroControl">
                        <i class="icon icon-filter"></i>Filtro
                    </a>
                </div>
                <div id="collapseFiltroControl" class="collapse" aria-labelledby="withIFiltroControl" data-parent="#withFiltroControl">
                    <div class="accordion-body">
                        @include('control_apuestas.partials.filtro')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table id="controlApuestas" class="table custom-table">
        <thead>
            <tr>
                <th>Loteria</th>
                <th>Banca</th>
                <th>Modalidad</th>
                <th>Numero</th>
                <th>Contador</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script src="{{ asset('js/app/controlApuesta.js?v=' . $asset_v) }}"></script>
