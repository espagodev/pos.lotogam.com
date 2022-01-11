<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myExtraLargeModalLabel">Nuevo Resultado</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            @include('resultados.partials.form')
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary guardarResultados" id="guardarResultados" type="submit">Guaradar Resultado</button>
            <button type="button" class="btn btn-secondary cancelar" id="cancelar" data-dismiss="modal">Cerrar</button>

        </div>
    </div>
</div>
