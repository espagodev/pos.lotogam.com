@extends('layouts.app')

@section('content')
    @include('cuadre_caja.partials.pageHeader')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="accordion" id="withIconsAccordion">							

                <div class="accordion-container">
                    <div class="accordion-header" id="withIconThree">
                        <a  href="" class="collapsed" data-toggle="collapse" data-target="#collapseWithIconThree" aria-expanded="false" aria-controls="collapseWithIconThree">
                            <i class="icon icon-filter"></i>Filtro
                        </a>
                    </div>
                    <div id="collapseWithIconThree" class="collapse" aria-labelledby="withIconThree" data-parent="#withIconsAccordion">
                        <div class="accordion-body">
                            @include('cuadre_caja.partials.filtro')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row start -->
    <div class="row gutters">
        <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-12">
            <div class="info-stats4  text-info">
                <div class="info-icon">
                    <i class="icon-local_atm"></i>
                </div>
                <div class="sale-num">
                    <h3 class="balance_inicial"></h3>
                    <p class=" text-info">Balance Inicial</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-12">
            <div class="info-stats4">
                <div class="info-icon">
                    <i class="icon-arrow-up"></i>
                </div>
                <div class="sale-num">
                    <h3 class="total_entradas"></h3>
                    <p>Entradas</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-12">
            <div class="info-stats4">
                <div class="info-icon">
                    <i class="icon-arrow-down"></i>
                </div>
                <div class="sale-num">
                    <h3 class="total_salidas"></h3>
                    <p>Salidas</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-12">
            <div class="info-stats4 text-success">
                <div class="info-icon">
                    <i class="icon-local_atm"></i>
                </div>
                <div class="sale-num">
                    <h3 class="total_venta"></h3>
                    <p class='text-success'>Venta Neta</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-12">
            <div class="info-stats4">
                <div class="info-icon">
                    <i class="icon-local_atm"></i>
                </div>
                <div class="sale-num">
                    <h3 class="balance_final"></h3>
                    <p>Balance Final</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Row end -->
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="accordion" id="withIconsAccordion">
                <div class="accordion-container">
                    <div class="accordion-header" id="withIconOne">
                        <a  href="" class="" data-toggle="collapse" data-target="#collapseWithIconOne" aria-expanded="true" aria-controls="collapseWithIconOne">
                            <i class="icon icon-shield1"></i>Balance Diario 
                        </a>
                        <button type="button" class="btn-outline-info btn-rounded btn-sm btnSave"><i class="icon-image"></i></button>
                    </div>
                    <div id="collapseWithIconOne" class="collapse show" aria-labelledby="withIconOne" data-parent="#withIconsAccordion">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table id="balance_diario_table"  class="table custom-table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Usuario</th>
                                            <th>Balance Inicial</th>
                                            <th>Entradas</th>
                                            <th>Salidas</th>
                                            <th>Total Venta</th>
                                            <th>Venta Neta</th>
                                            <th>Comisiones</th>
                                            <th>Premios</th>                        
                                            <th>Balance Final</th>
                                            <th>Disponible</th>
                                            <th>Fecha</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-container">
                    <div class="accordion-header" id="withIconTwo">
                        <a  href="" class="collapsed" data-toggle="collapse" data-target="#collapseWithIconTwo" aria-expanded="false" aria-controls="collapseWithIconTwo">
                            <i class="icon icon-tag1"></i>Movimientos
                        </a>
                        <button type="button" class="btn-outline-info btn-rounded btn-sm btnMovimientos"><i class="icon-image"></i></button>
                    </div>
                    <div id="collapseWithIconTwo" class="collapse" aria-labelledby="withIconTwo" data-parent="#withIconsAccordion">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table custom-table table-sm" id="movimientos_diarios_table">
                                    <thead>
                                        <tr>
                                            <th>Accion</th>
                                            <th>Fecha</th>
                                            <th>Banca</th>
                                            <th>Usuario</th>
                                            <th>Cantidad</th>
                                            <th>Motivo</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{ asset('js/app/cuadreCaja.js?v=' . $asset_v) }}"></script>
@endsection