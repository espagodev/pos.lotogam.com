<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

class ResultadoController extends Controller
{
    public function index()
    {       
        $data['empresas_id'] = session()->get('user.emp_id');
        $data['lot_superpale'] = 0;

        $loterias = $this->posService->getLoterias($data);
        return view('resultados.index')->with(['loterias' => $loterias]);
    }

    public function getListadoResultados(Request $request)
    {
        if ($request->ajax()) {
            
            
            $data =  $request->only(['start_date', 'end_date']);
            $data['bancas_id'] = !empty($request->bancas_id) ?  $request->bancas_id : session()->get('user.banca');
            $data['users_id'] = !empty($request->users_id) ?  $request->users_id : session()->get('user.id');           
            $data['empresas_id'] =  session()->get('user.emp_id');
            $data['loterias_id'] = $request->get('loterias_id');

            $listadoResultado =  $this->posService->getListadoResultados($data);
               
            return DataTables::of($listadoResultado)
            ->editColumn('loteria', function ($row) {
                return '<a data-loteria=' . $row->loterias_id . ' data-fecha=' . $row->res_fecha . ' href="#" class="detalle-resultados">' . $row->lot_nombre  . ' (' . $row->lot_abreviado . ')  </a>';
            })
            ->editColumn('lot_nombre', function ($row) {
                return $row->lot_nombre . ' (' . $row->lot_abreviado . ')';
            })
            ->editColumn('res_fecha', '{{@format_date($res_fecha)}}')
            ->addColumn('action', function ($row) {
                $action = '';
                $action .= '<button data-href="' . route('getResultadosDelete', [$row->id]) . '" class="btn btn-sm btn-outline-danger btn-rounded btn-sm delete_resultado_button"><i class="icon-x-circle"></i></button>
                ';
                return  $action;
            })


            ->rawColumns(['loteria', 'res_fecha', 'action'])
            ->make(true);

        }
    }

    public function getNuevoResultado()
    {
        $data['empresas_id'] = session()->get('user.emp_id');
        $data['lot_superpale'] = 0;

        $loterias = $this->posService->getLoterias($data);
        return view('resultados.modal.modal_nuevo_resultado')->with(['loterias' => $loterias]);

    }

    public function getValidaHoraCierre(Request $request)
    {
       
        if ($request->ajax()) {
            $data['empresas_id'] =  session()->get('user.emp_id');
            $data['loteriasId'] = $request->get('loteriasId');
            $data['resFecha'] = $request->get('resFecha');
            
            $output =  $this->posService->getValidaHoraCierre($data);

            return $output;
        }
    }

    public function getGuardarResultados(Request $request)
    {
        if ($request->ajax()) {
            $data['empresas_id'] =  session()->get('user.emp_id');
            $data['loteriasId'] = $request->get('loteriasId');
            $data['resFecha'] = $request->get('resFecha');
            $data['res_premio1'] = $request->premio1;
            $data['res_premio2'] = $request->premio2;
            $data['res_premio3'] = $request->premio3;
            
            $output =  $this->posService->getGuardarResultados($data);

            return $output;
        }
    }

    public function getResultadosDelete($resultadoId)
    {
       
        if (request()->ajax()) {
            $data['empresaId'] =  session()->get('user.emp_id');
            $data['resultadoId'] = $resultadoId;
            
            $output = $this->posService->getResultadosDelete($data);

            return $output;
        }
    }

    public function getImprimirResultados(Request $request)
    {
        
            $data =  $request->only(['start_date', 'end_date', 'loterias_id']);
            $data['bancas_id'] = !empty($request->bancas_id) ?  $request->bancas_id : session()->get('user.banca');
            $data['users_id'] = !empty($request->users_id) ?  $request->users_id : session()->get('user.id');           
            $data['empresas_id'] = session()->get('user.emp_id');
            $data['printer_type'] =  !empty(session()->get('banca.impresora')) ? session()->get('banca.impresora') : 'browser';
            $data['getImagen'] =   !empty($request->getImagen) ? $request->getImagen : 1;
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $loterias_id = $request->loterias_id;
        
            $resultados =  $this->posService->getImprimirResultados($data);
            // dd($resultados);
            // if($resultados->status == false){
                
            //    return   ['success' => $resultados->status, 'mensaje' => $resultados->msg];
            // }else{
                return view('resultados.modal.modal_resultados')->with(['resultados' => $resultados, 'start_date' => $start_date, 'end_date' => $end_date, 'loterias_id' => $loterias_id]);
            // }

    }

    public function imprimirResultados(Request $request, $start_date, $end_date, $loterias_id = null)
    {
      
       if ($request->ajax()) {
           try {
                $data =  $request->only(['start_date', 'end_date', 'loterias_id']);
                $data['bancas_id'] = !empty($request->bancas_id) ?  $request->bancas_id : session()->get('user.banca');
                $data['users_id'] = !empty($request->users_id) ?  $request->users_id : session()->get('user.id');           
                $data['empresas_id'] = session()->get('user.emp_id');
                $data['printer_type'] =  !empty(session()->get('banca.impresora')) ? session()->get('banca.impresora') : 'browser';
                $data['getImagen'] =   !empty($request->getImagen) ? $request->getImagen : 1;
                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;
                $data['loterias_id'] = !empty($loterias_id) ? $loterias_id : null;

             
               $resultados =  $this->posService->getImprimirResultados($data);
               
               $mensaje = 'Resultados Generados con éxito';
               
               if ($data['printer_type'] == 'printer' && $data['getImagen'] == 0) {         
                   $output = ['success' => 1, 'mensaje' => $mensaje, 'receipt' => $resultados];
               } else { 

                    $layout = 'resultados.partials.formato_resultados58';       
                    
                   $receipt['html_content'] = view($layout, compact('resultados'))->render();  
                   $output = ['success' => 1, 'mensaje' => $mensaje, 'receipt' => $receipt];
                   
               }
           } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

               $output = [
                   'success' => 0,
                   'mensaje' => "Algo salió mal, Error al imprimir"
               ];
           }
           return $output;
       }
    }
}
