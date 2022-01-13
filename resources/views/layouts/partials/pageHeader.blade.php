<div class="page-header">
    <ol class="breadcrumb">
        {{-- <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Layouts</li> --}}
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <ul class="app-actions">
        <li>
            <div class="btn-group btn-group-sm btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-info active">
                    <input type="radio" name="date-filter" data-start="{{ date('Y-m-d') }}"
                        data-end="{{ date('Y-m-d') }}" checked> Hoy
                </label>
                <label class="btn btn-info">
                    <input type="radio" name="date-filter" data-start="{{ $date_filters['this_week']['start'] }}"
                        data-end="{{ $date_filters['this_week']['end'] }}"> Esta Semana
                </label>
                <label class="btn btn-info">
                    <input type="radio" name="date-filter" data-start="{{ $date_filters['this_month']['start'] }}"
                        data-end="{{ $date_filters['this_month']['end'] }}"> Este Mes
                </label>
            </div>


        </li>
    </ul>
</div>
