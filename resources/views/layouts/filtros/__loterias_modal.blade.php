<div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
    <strong>Loterias:</strong>
    <div class="form-group">
        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="loterias_modal_id"><i class="icon-bookmark1"></i></label>
            </div>
            <select class="custom-select" name="loterias_modal_id" id="loterias_modal_id">
                <option value="">Seleccione</option>
                @foreach($loterias as  $loteria)
                        <option value="{{ $loteria->loterias_id }}"  >{{ $loteria->lot_nombre}}</option>
                    @endforeach
            </select>
        </div>
    </div>
</div>
