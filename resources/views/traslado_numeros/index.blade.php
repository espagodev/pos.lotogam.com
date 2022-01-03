@extends('layouts.app')

@section('content')
    @include('traslado_numeros.partials.pageHeader')
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
                            @include('traslado_numeros.partials.filtro')
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
    @include('traslado_numeros.partials.detalle')
    <div class="row ">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                            <table id="listado_traslado"  class="table custom-table table-sm">
                            <thead>
                                <tr>
                                    <th>Loteria</th>
                                    <th>Modalidad</th>
                                    <th>Numero</th>
                                    <th>Contador</th>
                                    <th>Traslado</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="total_control"></td>
                                    <td class="total_traslado"></td>                                            
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/app/traslado.js?v=' . $asset_v) }}"></script>
@endsection