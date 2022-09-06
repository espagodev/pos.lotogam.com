<div class="row gutters resultados">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="form-group">
            <div class="input-group res_fecha">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i
                            class="icon-calendar"></i></span>
                </div>
                <input type="text" class="form-control" id="res_fecha" name="res_fecha" data-date-format="dd/mm/yyyy" placeholder="Fecha Resultado"
                    aria-label="Fecha Resultado" aria-describedby="basic-addon1" value="">
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 loterias_id">
       
        <div class="form-group">
            <div class="input-group loterias-id">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="loterias_id"><i class="icon-bookmark1"></i></label>
                </div>
                 <select class="custom-select" name="loterias_cierre_id" class="loterias_cierre_id" id="loterias_cierre_id">
                    <option value="">Seleccione La Loteria</option>
                    @foreach($loterias as  $loteria)
                            <option value="{{ $loteria->loterias_id }}"  >{{ $loteria->lot_nombre}} - ({{ $loteria->hlo_hora_fin }})</option>
                        @endforeach
                </select> 
            </div>
        </div>
    </div>
</div>
<div class="row gutters numerosPremiados">
    <div class="col-xs-4 col-sm-4 col-md-4 ">
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="icon-hash"><i
                            class="icon-hash"></i></span>
                </div>
                <input onkeyup="fn_saltar(this,1);" type="number" maxlength="2" class="form-control" id="res_premio1" name="res_premio1"  placeholder="1° Lugar"
                    aria-label="1° Lugar" aria-describedby="icon-hash" value="">
            </div>
        </div>
        
    </div>
    <div class="col-xs-4 col-sm-4 col-md-4">
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="icon-hash"><i
                            class="icon-hash"></i></span>
                </div>
                <input onkeyup="fn_saltar(this,2);" type="number" maxlength="2" class="form-control" id="res_premio2" name="res_premio2"  placeholder="2° Lugar"
                    aria-label="2° Lugar" aria-describedby="icon-hash" value="">
            </div>
        </div>
        
    </div>
    <div class="col-xs-4 col-sm-4 col-md-4">
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="icon-hash"><i
                            class="icon-hash"></i></span>
                </div>
                <input type="number" maxlength="2" class="form-control" id="res_premio3" name="res_premio3"  placeholder="3° Lugar"
                    aria-label="3° Lugar" aria-describedby="icon-hash" value="">
            </div>
        </div>
        
    </div>
</div>
<div class="enproceso">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Espere Un Momento</div>
        </div>
        <div class="card-body">
            <div class="text-center">
                <div class="spinner-grow text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-secondary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-success" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-danger" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-warning" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-info" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-light" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-dark" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
 </div>
 
