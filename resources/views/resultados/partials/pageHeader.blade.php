<div class="page-header">
    <ol class="breadcrumb">
        {{-- <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Layouts</li> --}}
        <li class="breadcrumb-item active">Resultados</li>
    </ol>

    <ul class="app-actions chat-actions">
        <li>
            <a  href="#" data-href="{{ route('getImprimirResultados') }}" class="btn-modal imprimir-resultado">
                <i class="icon-printer"></i>
            </a>
        </li>
        <li>
            <a  href="#" data-href="{{ route('getNuevoResultado') }}" class="btn-modal nuevo-resultado">
                <i class="icon-plus-square"></i>
            </a>
        </li>
    </ul>
</div>