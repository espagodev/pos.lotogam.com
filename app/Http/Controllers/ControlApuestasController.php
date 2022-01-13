<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ControlApuestasController extends Controller
{
    public function getControlApuestaLista()
    {
        $data['empresas_id'] = session()->get('user.emp_id');
        $data['lot_superpale'] = 0;
        
        $loterias = $this->posService->getLoterias($data);  
        $modalidades = $this->posService->getModalidades(); 
        return view('control_apuestas.modal')->with(['loterias' => $loterias, 'modalidades' => $modalidades]);
    }

    public function getControlApuestas(Request $request)
    {
        if ($request->ajax()) {
            
            
            $data =  $request->only(['start_date', 'end_date', 'modalidades_id', 'loterias_id']);
            $data['bancas_id'] = !empty($request->bancas_id) ?  $request->bancas_id : session()->get('user.banca');
            $data['users_id'] = !empty($request->users_id) ?  $request->users_id : session()->get('user.id');           
            $data['empresas_id'] = session()->get('user.emp_id');
 
            $listadoCntrol =  $this->posService->getListadoControlApuesta($data);
               
            return DataTables::of($listadoCntrol)

            ->editColumn('cnj_fecha', '{{@format_date($cnj_fecha)}}')
            ->rawColumns(['cnj_fecha'])
            ->make(true);
        }
    }
}
