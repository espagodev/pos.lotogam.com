<div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
    <strong>Estados:</strong>
    <div class="form-group">
        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="estado"><i class="icon-bookmark1"></i></label>
            </div>
            <select class="custom-select" id="estado" name="estado">
                <option value="">Seleccione</option>
                @foreach($estados as $key => $estadoTicket)
                    <option value="{{ $key }}">{{ $estadoTicket }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>