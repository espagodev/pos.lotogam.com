<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ResultadoController extends Controller
{
    public function index()
    {       
        $data['empresas_id'] = session()->get('user.emp_id');

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
            // ->editColumn('res_fecha', '{{@format_date($res_fecha)}}')
            ->addColumn('action', function ($row) {
                $action = '';
                $action .= '<button data-href="" class="btn btn-sm btn-danger delete_resultado_button"><i class="fa fa-trash"></i></button>
                ';
                return  $action;
            })


            ->rawColumns(['loteria', 'res_fecha', 'action'])
            ->make(true);

        }
    }
}
