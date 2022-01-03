@extends('layouts.app')

@section('content')
 @include('layouts.partials.pageHeader')
    <!-- Row start -->
    <div class="row gutters">
        <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-12">
            <!-- Row starts -->
            <div class="row gutters">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="goal-card">
                        <i class="icon-film"></i>
                        <h2 class="totalTickets"></h2>
                        <h6>Tickets</h6>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="goal-card">
                        <i class="icon-credit"></i>
                        <h2 class="totalVenta"></h2>
                        <h6>Total Ventas</h6>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="goal-card">
                        <i class="icon-credit"></i>
                        <h2 class="totalComision"></h2>
                        <h6>Total Comisiones</h6>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="goal-card">
                        <i class="icon-credit"></i>
                        <h2 class="totalPremios"></h2>
                        <h6>Total Premios</h6>
                    </div>
                </div>
            </div>
            <!-- Row ends -->
        </div>
        <div class="col-xl-7 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card h-310">
                <div class="card-header">
                    <div class="card-title">Earnings</div>
                </div>
                <div class="card-body pt-0">
                    <!-- Row starts -->
                    <div class="row gutters">
                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-12">
                            <div class="graph-label-container">
                                <div class="graph-label">
                                    <i class="icon-controller-play"></i>
                                    <div class="label-detail">
                                        <h5>$45,000</h5>
                                        <p>Report GSK</p>
                                    </div>
                                </div>
                                <div class="graph-label">
                                    <i class="icon-controller-play"></i>
                                    <div class="label-detail">
                                        <h5>$60,000</h5>
                                        <p>Report MRS</p>
                                    </div>
                                </div>
                                <div class="graph-label">
                                    <i class="icon-controller-play"></i>
                                    <div class="label-detail">
                                        <h5>$75,000</h5>
                                        <p>Report AGS</p>
                                    </div>
                                </div>
                                <div class="graph-label">
                                    <i class="icon-controller-play"></i>
                                    <div class="label-detail">
                                        <h5>$90,000</h5>
                                        <p>Profit</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 col-12">
                            <div id="earnings"></div>
                        </div>
                    </div>
                    <!-- Row ends -->
                </div>
            </div>
        </div>

    </div>
    
    <!-- Row end -->

    <!-- Row start -->
    <div class="row">
        <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Reporte de Venta Mes  <button type="button" class="btn-outline-info btn-rounded btn-sm btnVentasMes"><i class="icon-image"></i></button></div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table  class="table custom-table table-sm" id="ventas_mes">
                            <thead>
                                <tr>
                                    <th>Loteria</th>
                                    <th>Venta</th>
                                    <th>Promocion</th>
                                    <th>Comision</th>
                                    <th>Premios</th>
                                    <th>Promocion</th>
                                    <th>Ganancia</th>                                    
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <td>Totales</td>
                                    <td class="totalesVenta"></td>
                                    <td class="totalesPromocion"></td>                                            
                                    <td class="totalesComision"></td>
                                    <td class="totalesPremios"></td>
                                    <td class="totales_premios_promocion"></td>
                                    <td class="totalesGanancia"></td>  
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                Resultados
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-sm"><i class="icon-calendar"></i></span>
                                        </div>
                                        <input type="text" class="form-control" aria-label="Sizing example input" name="date_range" id="reportrange" aria-describedby="inputGroup-sizing-sm">
                                    </div>
                                </div>
                            </div>    
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table  class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Loteria</th>
                                    <th>Resultados</th>                                                                
                                </tr>
                            </thead>
                            <tbody class="resultado_fecha">
                    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row end -->

     <!-- Row start -->
     <div class="row">
        <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Ticket Premiados
                       
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tickets_premiados" class="table custom-table table-sm">
                            <thead>
                                <tr>
                                    <th>Ticket</th>
                                    <th>Fecha</th>
                                    <th>Loteria</th>
                                    <th>Apostado</th>
                                    <th>Premio</th>
                                    <th>Opciones</th>                                    
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Row end -->


@endsection
@section('scripts')
    <!-- dashboard -->
	<script src="{{ asset('js/app/dashboard.js?v=' . $asset_v) }}"></script>

@endsection