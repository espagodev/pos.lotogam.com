
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Control de Impresion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('impresion.partials.impresora')
            </div>
            <div class="modal-footer">
                <a href="#" data-href="{{route('getModificarImpresora')}}" class="modificarImpresora btn btn-success" ><i class="icon-printer" aria-hidden="true"></i> Modificar Tipo de Impresion</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                
            </div>
        </div>
    </div>


