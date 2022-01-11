<?php

namespace App\Http\Controllers;

use App\Utils\Horario;
use App\Utils\Util;
use Illuminate\Http\Request;

class LoteriasController extends Controller
{
    public function getHorarioLoterias(Request $request)
    {
        if ($request->ajax()) {
            
            $users_id = session()->get('user.id');

            $horaRD = Horario::horaRD();
          
            $data['empresas_id'] = session()->get('user.emp_id');
            $data['bancas_id'] = session()->get('user.banca');
            $data['users_id'] = session()->get('user.id');
            $data['horario'] = session()->get('user.userHorario');
            $data['dia'] = Horario::dia();
            
            $horarioLoteria = Horario::getHorarioLoterias($data);
            
            // $detalles = $this->marketService->getProgressBar($users_id);
            
           
            $output = '';
            // $limiteVenta = Util::compararValores($detalles->limite, $detalles->total);

            // if ($limiteVenta == 0){
                foreach ($horarioLoteria as  $detalle) {
                    
                    $horariocierre = Horario::compararHoras($detalle->hlo_hora_fin, $horaRD);
                    $horarioApertura= Horario::compararHoras($detalle->hlo_hora_inicio, $horaRD);

                    if (($horariocierre == 0) && ($horarioApertura == 1)){

                                $output .='<div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-4"> 
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="' . $detalle->lot_nombre . '"  name="lot_id[]" value="' . $detalle->loterias_id . '|' . 0 . '|' . $detalle->hlo_hora_fin .' ">
                                        <label class="custom-control-label validar_jugada_loteria" for="' . $detalle->lot_nombre . '" data-loterias_id="' . $detalle->loterias_id . '"  data-superpale="0"><span class="badge badge-success m-1 validar-monto"><h6 class="text-white">' . $detalle->lot_nombre .'</h6></span></label>
                                    </div>
                                </div>';
                    } else {
                        $output .='<div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-4"> 
                                    <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="' . $detalle->lot_nombre . '" disabled>
                                            <label class="custom-control-label" for="' . $detalle->lot_nombre . '"><span class="badge badge-danger m-1 validar-monto"><h6 class="text-white">' . $detalle->lot_nombre .'</h6></span></label>
                                        </div>
                                    </div>';
                    }
                }
                return $output;
            // }else{
            //     foreach ($horarioLoteria as $key => $detalle) {

            //         $output .=  '<div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-4">
            //                         <div class="icheck-material-danger">
            //                             <input type="checkbox" id="' . $detalle->lot_nombre . '" disabled/>
            //                             <label  for="' . $detalle->lot_nombre . '"><span class="badge badge-danger m-1"><h6 class="text-white">' . $detalle->lot_nombre . '</h6></span></label>
            //                         </div>
            //                     </div>';                    
            //     }
                // return $output;
            // }
        }
    }
    
    public function getHorarioSuperPale(Request $request)
    {
        if ($request->ajax()) {

            $users_id = session()->get('user.id');

            $horaRD = Horario::horaRD();

            $data['empresas_id'] = session()->get('user.emp_id');
            $data['bancas_id'] = session()->get('user.banca');
            $data['users_id'] = session()->get('user.id');
            $data['horario'] = session()->get('user.userHorario');
            $data['dia'] = Horario::dia();

            $horarioLoteria = Horario::getHorarioSuperPale($data);
          
            // $detalles = $this->marketService->getProgressBar($users_id);

            $output = '';
            // $limiteVenta = Util::compararValores($detalles->limite, $detalles->total);

            // if ($limiteVenta == 0){
                foreach ($horarioLoteria as  $detalle) {
                    // dd($detalle->hlo_hora_fin, $horaRD);
                    $horariocierre = Horario::compararHoras($detalle->hlo_hora_fin, $horaRD);

                    if ($horariocierre == 0) {

                                $output .='<div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-4"> 
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="' . $detalle->lot_nombre . '"  name="lot_id[]" value="' . $detalle->loterias_id . '|' . $detalle->lot_superpale . '|' . $detalle->hlo_hora_fin .' ">
                                        <label class="custom-control-label validar_jugada_loteria" for="' . $detalle->lot_nombre . '" data-loterias_id="' . $detalle->loterias_id . '"  data-superpale="' . $detalle->lot_superpale . '"><span class="badge badge-info m-1 "><h6 class="text-white">' . $detalle->lot_nombre .'</h6></span></label>
                                    </div>
                                </div>';
                    } else {
                        $output .='<div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-4"> 
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="' . $detalle->lot_nombre . '" disabled>
                                            <label class="custom-control-label" for="' . $detalle->lot_nombre . '"><span class="badge badge-danger m-1 "><h6 class="text-white">' . $detalle->lot_nombre .'</h6></span></label>
                                        </div>
                                    </div>';

                    }
                }
                return $output;
            // }else{
            //     foreach ($horarioLoteria as $key => $detalle) {

            //             $output .=  '<div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-4">
            //                         <div class="icheck-material-danger">
            //                             <input type="checkbox" id="' . $detalle->lot_nombre . '" disabled/>
            //                             <label  for="' . $detalle->lot_nombre . '"><span class="badge badge-danger m-1"><h6 class="text-white">' . $detalle->lot_nombre . '</h6></span></label>
            //                         </div>
            //                     </div>';
                    
            //     }
            //     return $output;
            // }
        }
    }
    
}
