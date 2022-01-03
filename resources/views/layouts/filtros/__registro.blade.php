<div class="form-group">
        <strong>Estado:</strong>
        <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa fa-level-up"></i></span>
        </div>
            <select class="form-control " name="estado" id="estado">
            <option value="">Seleccione</option>
                @foreach($registroInformes as $key => $registroInforme)
                <option value="{{ $key }}">{{ $registroInforme }}</option>
            @endforeach
        </select>
    </div>
</div>
