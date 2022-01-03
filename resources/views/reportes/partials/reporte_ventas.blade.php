<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="accordion" id="withFiltroVentas">							

            <div class="accordion-container">
                <div class="accordion-header" id="withFIltroVentas">
                    <a  href="" class="collapsed" data-toggle="collapse" data-target="#collapsefiltroVentas" aria-expanded="false" aria-controls="collapsefiltroVentas">
                        <i class="icon icon-filter"></i>Filtro
                    </a>
                    <button type="button" class="btn-outline-info btn-rounded btn-sm btnReporteVentas"><i class="icon-image"></i></button>
                </div>
                <div id="collapsefiltroVentas" class="collapse" aria-labelledby="withFIltroVentas" data-parent="#withFiltroVentas">
                    <div class="accordion-body">
                        @include('reportes.partials.filtro')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="h-420">           
    <div class="table-responsive">
        <table id="reporte_ventas" class="table custom-table table-sm">
            <thead>
                <tr>
                    <th>Loteria</th>
                    <th>Venta</th>
                    <th>Promociòn</th>
                    <th>Comisiòn</th>
                    <th>Premios</th>
                    <th>Promociòn</th>
                    <th>Neto</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td>Totales</td>
                    <td class="totalVenta"></td>
                    <td class="totalPromocion"></td>                                            
                    <td class="totalComision"></td>
                    <td class="totalPremios"></td>
                    <td class="total_premios_promocion"></td>
                    <td class="totalGanancia"></td>  
                </tr>
            </tfoot>
        </table>
    </div>          
</div>
<script src="{{ asset('js/app/reporteVentas.js?v=' . $asset_v) }}"></script>