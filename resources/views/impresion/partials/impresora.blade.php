
 <div class="row gutters">   
    <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-6 col-12" >
        <strong>Tipo de impresora de Tickets:</strong>
        <div class="form-group">
            <div class="input-group input-group-sm mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="ban_tipo_impresora"><i class="icon-texture"></i></label>
                </div>
                <select class="custom-select" name="ban_tipo_impresora" id="ban_tipo_impresora">
                    @foreach($tipoImpresoras as $key => $tipoImpresora)
                        <option value="{{ $key }}"   @if($key == session()->get('banca.impresora')) selected @endif>{{ $tipoImpresora }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-6 col-12" id="location_printer_div" style="display:none;">
        <strong>Impresora::</strong>
        <div class="form-group">
            <div class="input-group input-group-sm mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="impresoras_pos_id"><i class="icon-print"></i></label>
                </div>
                <select class="custom-select" name="impresoras_pos_id" id="impresoras_pos_id">
                    @foreach($impresoras as $impresora)
                        <option value="{{ $impresora->id }}" @if($impresora->id == session()->get('banca.impresoraId')) selected @endif >{{ $impresora->imp_nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6" id="location_printer_div" style="display:none;">

        <span><i class="fa fa-print"></i>  Descarga  El Servicio de Impresion Local <a href="{{ asset('printServer/pos_print_server_v1.7.7z') }}">Aquí</a></span>

    </div>
</div>

<script src="{{ asset('js/app/impresion.js?v=' . $asset_v) }}"></script>