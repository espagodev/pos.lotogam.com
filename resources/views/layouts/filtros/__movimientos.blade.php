<div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
    <strong>Movimientos:</strong>
    <div class="form-group">
        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="movimiento_id"><i class="icon-colours"></i></label>
            </div>
            <select class="custom-select" id="movimiento_id" name="movimiento_id">
                <option value="">Seleccione</option>
                @foreach($movimientosCaja as $key => $movimientoCaja)
                <option value="{{ $key }}">{{ $movimientoCaja }}</option>
            @endforeach
            </select>
        </div>
    </div>
</div>