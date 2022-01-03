<div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
    <strong>Promocion:</strong>
    <div class="form-group">
        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="promocion"><i class="icon-bookmark1"></i></label>
            </div>
            <select class="custom-select" id="promocion" name="promocion">
                <option value="">Seleccione</option>
                {{-- @foreach($estadosPromocionTicket as $key => $estadoPromocionTicket)
                    <option value="{{ $key }}">{{ $estadoPromocionTicket }}</option>
                @endforeach --}}
            </select>
        </div>
    </div>
</div>