@extends('layouts.app')

@section('content')
    <section class="content no-print">
        @include('layouts.partials.posHeader')

        <!-- Row starts -->
        <div class="row gutters h-420">
            <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12">
                <div class="card ">
                    <form method="POST" id="add_pos_sell_form" action="{{ route('postGenerarTicket') }}">
                        <div class="card-body">
                            <!-- CAMPOS DEL FORMULARIO -->

                            <div class="row gutters">
                                @if (session()->get('permisos.useVentaFuturo') == 1)
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i
                                                        class="icon-calendar"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="tic_fecha_sorteo" name="tic_fecha_sorteo" data-date-format="dd/mm/yyyy" placeholder="Fecha Sorteo"
                                                aria-label="Fecha Sorteo" aria-describedby="basic-addon1" value="{{ $fechaActual }}">
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if (session()->get('permisos.usePromocion') == 1)
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="tic_promocion" value="1" name="tic_promocion">
                                            <label class="custom-control-label" for="tic_promocion">TICKET PROMOCION</label>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="row gutters">
                                <input type="hidden" id="bancas_id" name="bancas_id"
                                    value="{{ request()->session()->get('user.banca') }}">
                                <input type="hidden" id="users_id" name="users_id"
                                    value="{{ request()->session()->get('user.id') }}">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">{{ $symbol }}</span>
                                            </div>
                                            <input type="number" class="form-control" id="tid_valor" name="tid_valor"
                                                placeholder="Monto Apuesta" aria-label="Monto Apuesta"
                                                aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i
                                                        class="icon-slack"></i></span>
                                            </div>
                                            <input type="number" class="form-control" name="tid_apuesta" id="tid_apuesta"
                                                placeholder="Numero" aria-label="Numero" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row gutters  customScroll5">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="table-responsive">
                                        <input type="hidden" id="product_row_count" value="0">
                                        <input type="hidden" id="quiniela_row_count" value="0">
                                        
                                        <table class="table table-sm" id="pos_table">
                                            <thead>
                                                <tr>
                                                    <th>Modalidad</th>
                                                    <th>Monto</th>
                                                    <th>Apuesta</th>
                                                    <th>x</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row no-print">
                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <b>Apuestas:</b>
                                    <span class="total_quantity" class="text-info  text-bold">0</span>
                                </div>

                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <b>Total:</b>
                                    <span class="price_total" class="text-info  text-bold">0</span>
                                </div>

                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <b>Loterias Seleccionadas:</b>
                                    <span id="total_loterias" class="text-info  text-bold">0</span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div data-scrollbar="true" data-height="150px">
                            <div class="row loterias no-print">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card">
                    <div class="card-body">
                        <div data-scrollbar="true" data-height="150px">
                            <div class="row superPale no-print">
                            </div>
                        </div>
                    </div>
                </div>
                @if (session()->get('permisos.useVentaAgrupada') == 1)
                <div class="card">
                    <div class="card-body">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="tic_agrupado" value="1" name="tic_agrupado">
                            <label class="custom-control-label" for="tic_agrupado">Ticket Agrupado</label>
                        </div>  
                    </div>
                </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <div class="row gutters no-print">
                            {{-- <div class="col-6 col-sm-6 col-md-6 col-lg-2 col-xl-2">
                                <button type="button"
                                    class="btn btn-info btn-sm no-print btn-block waves-effect waves-light m-1"
                                    disabled>Borrador</button>
                            </div>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-2 col-xl-2">
                                <button type="button"
                                    class="btn btn-warning btn-sm no-print btn-block waves-effect waves-light m-1 "
                                    disabled><i class="fa fa-pause"></i> Suspender</button>
                            </div> --}}
                            @if (session()->get('permisos.useTicketImagen') == 1)
                                <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                                    <button type="button"
                                        class="btn btn-info btn-sm no-print btn-block pos-express-btn pos-generar pos-validar "><i
                                            class="icon-image"></i> Generar Imagen</button>
                                </div>
                            @endif
                            <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                                <button type="button"
                                    class="btn btn-success btn-sm no-print btn-block pos-express-btn pos-express-finalize pos-validar "><i
                                        class="icon-printer"></i> Generar Ticket</button>
                            </div>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                                <b>Total A Pagar:</b>
                                <input type="hidden" name="final_total" id="final_total_input" value=0>
                                <span id="total_payable" class="text-success lead text-bold">0</span>
                            </div>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                                <button type="button" class="btn btn-danger btn-sm no-print pos-cancel" id="pos-cancel"><i
                                        class="fa fa-close"></i> Cancelar</button>
                            </div>
                        </div>
                        <div class="row gutters no-print procesando" style="display: none;">
                            <div class="text-center">
                                <div class="spinner-grow text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <div class="spinner-grow text-secondary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <div class="spinner-grow text-success" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <div class="spinner-grow text-danger" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <div class="spinner-grow text-warning" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <div class="spinner-grow text-info" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <div class="spinner-grow text-light" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <div class="spinner-grow text-dark" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Row ends -->
        <!-- Row starts -->
       
        <!-- Row ends -->
        {{-- modal --}}
       
    </section>
    
   
   @include('pos.receipts.partial.generar_modal')
@endsection
 <!-- Esto se imprimirá-->
 <section class="invoice print_section" id="receipt_section">
</section>
@section('scripts')
    <!-- dashboard -->
    <script src="{{ asset('js/app/pos.js?v=' . $asset_v) }}"></script>
    
    <script type="text/javascript">
       
        $('#tic_fecha_sorteo').pickadate({
            format: 'dd/mm/yyyy',
            formatSubmit: 'dd/mm/yyyy',
            today: 'Hoy',
            clear: '',
            close: 'Cancelar',
            min: 0,
            max: 8
        });
    </script>
@endsection
