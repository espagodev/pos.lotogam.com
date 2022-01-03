@extends('layouts.app')

@section('content')
    @include('resultados.partials.pageHeader')
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
                            @include('resultados.partials.filtro')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">               
                <div class="card-body">
                    <div class="table-responsive">
                            <table id="listado_resultados"  class="table custom-table">
                            <thead>
                                <tr>
                                    <th>Loteria</th>
                                    <th>Fecha</th>
                                    <th>Resultado 1</th>
                                    <th>Resultado 2</th>
                                    <th>Resultado 3</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/app/resultados.js?v=' . $asset_v) }}"></script>
@endsection