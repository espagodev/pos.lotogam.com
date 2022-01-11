<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TrasladoController extends Controller
{
    public function index()
    {     
        $data['empresas_id'] = session()->get('user.emp_id');
        
        $loterias = $this->posService->getLoterias($data);  
        $modalidades = $this->posService->getModalidades(); 
        $traslado =  $this->posService->getTrasladoActivo($data);
        
        return view('traslado_numeros.index')->with(['loterias' => $loterias, 'modalidades' => $modalidades, 'traslado' => $traslado]);
    }


    public function getListadoTraslado(Request $request)
    {
        if ($request->ajax()) {
            
            
            $data =  $request->only(['start_date', 'end_date', 'modalidades_id']);
            $data['bancas_id'] = !empty($request->bancas_id) ?  $request->bancas_id : session()->get('user.banca');
            $data['users_id'] = !empty($request->users_id) ?  $request->users_id : session()->get('user.id');           
            $data['empresas_id'] = session()->get('user.emp_id');
            $data['loterias_id'] = $request->get('loterias_id');
            
            
            $listadoTraslado =  $this->posService->getListadoTraslado($data);
            return DataTables::of($listadoTraslado)
            ->editColumn('tln_fecha', '{{@format_date($tln_fecha)}}')

            ->addColumn('contador', function ($row) {
                return  '<input type="input" class="tln_contador_traslado input-small" id="tln_contador_traslado_'. $row->id .'" data-id="' . $row->id .'" value="' . $row->tln_contador_traslado .'">' ;
            })

            ->rawColumns(['contador','tln_fecha']) 
            ->make(true);

        }
    }

    public function getTrasladoNumero(Request $request, $traslado)
    {
        $data['traslado_id'] = $traslado;
        $data['empresas_id'] = session()->get('user.emp_id');
        $data['tln_contador_traslado'] =  $request->input('tln_contador_traslado');
         $traslado =  $this->posService->getTrasladoNumero($data);

         return $traslado;
    }
    

    
}
