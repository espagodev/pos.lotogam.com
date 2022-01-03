<div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
    <strong>Bancas:</strong>
    <div class="form-group">
        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="bancas_id"><i class="icon-monitor"></i></label>
            </div>
            <select class="custom-select" id="bancas_id" name="bancas_id">
                <option value="">Seleccione</option>
                {{-- @foreach($bancas as $banca)
                    <option value="{{ $banca->id }}"  >{{ $banca->ban_nombre}}</option>
                @endforeach --}}
            </select>
        </div>
    </div>
</div>
