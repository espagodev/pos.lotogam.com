<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

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
}
