<div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
    <strong>Usuarios:</strong>
    <div class="form-group">
        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="users_id"><i class="icon-user1"></i></label>
            </div>
            <select class="custom-select" id="users_id" name="users_id">
                <option value="">Seleccione</option>
                {{-- @foreach($estadosPromocionTicket as $key => $estadoPromocionTicket)
                    <option value="{{ $key }}">{{ $estadoPromocionTicket }}</option>
                @endforeach --}}
            </select>
        </div>
    </div>
</div>
