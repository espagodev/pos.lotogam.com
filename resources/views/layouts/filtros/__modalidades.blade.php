<div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
    <strong>Modalidad:</strong>
    <div class="form-group">
        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="modalidades_id"><i class="icon-colours"></i></label>
            </div>
            <select class="custom-select" id="modalidades_id" name="modalidades_id">
                <option value="">Seleccione</option>
                @foreach($modalidades as $modalidad)
                 <option  value="{{ $modalidad->id }}" >{{ $modalidad->mod_nombre }}</option>                
                @endforeach
            </select>
        </div>
    </div>
</div>
