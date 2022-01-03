<div class="page-header">
    <ol class="breadcrumb">
        {{-- <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Layouts</li> --}}
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <ul class="app-actions">
        <div class="row">
            {{-- <div class="col-md-4 col-xs-12">
                @if(((request()->session()->get('user.TipoUsuario') == 2) && (count((array)$bancas) > 1)) ||
                (request()->session()->get('user.useSupervisor') == 1))
                <select class="form-control" name="bancas_id" id="bancas_id">
                    <option value="">Seleccione</option>
                    @foreach ($bancas as $banca)
                        <option value="{{ $banca->id }}">{{ $banca->ban_nombre }}</option>
                    @endforeach
                </select>
                @endif

            </div> --}}
            {{-- <div class="col-md-8 col-xs-12">
                <div class="btn-group btn-group-toggle pull-right" data-toggle="buttons">
                    <label class="btn btn-info active">
                        <input type="radio" name="date-filter" data-start="{{ date('Y-m-d') }}"
                            data-end="{{ date('Y-m-d') }}" checked>Hoy
                    </label>
                    <label class="btn btn-info">
                        <input type="radio" name="date-filter" data-start="{{ $date_filters['this_week']['start'] }}"
                            data-end="{{ $date_filters['this_week']['end'] }}">Esta Semana
                    </label>
                    <label class="btn btn-info">
                        <input type="radio" name="date-filter" data-start="{{ $date_filters['this_month']['start'] }}"
                            data-end="{{ $date_filters['this_month']['end'] }}">Este Mes
                    </label>
                </div>
            </div>
        </div> --}}
        <li>
             <label class="btn btn-info active">
                <input type="radio" name="date-filter" data-start="{{ date('Y-m-d') }}"
                    data-end="{{ date('Y-m-d') }}" checked>Hoy
            </label>
        </li>
        <li>
            <label class="btn btn-info">
                <input type="radio" name="date-filter" data-start="{{ $date_filters['this_week']['start'] }}"
                    data-end="{{ $date_filters['this_week']['end'] }}">Esta Semana
            </label>
       </li>
       <li>
        <label class="btn btn-info">
            <input type="radio" name="date-filter" data-start="{{ $date_filters['this_month']['start'] }}"
                data-end="{{ $date_filters['this_month']['end'] }}">Este Mes
        </label>
   </li>
    </ul>
</div>