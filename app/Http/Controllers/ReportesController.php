<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReportesController extends Controller
{
    public function getReporteVentas()
    {
        $data['empresas_id'] = session()->get('user.emp_id');

        $loterias = $this->posService->getLoterias($data);
        $modalidades = $this->posService->getModalidades(); 
        return view('reportes.reporte_ventas_modal')->with(['loterias' => $loterias, 'modalidades' => $modalidades]);
    }

    public function getListaReporteVentas(Request $request)
    {
        if ($request->ajax()) {

            
            $data =  $request->only(['start_date', 'end_date', 'loterias_id']);
            $data['bancas_id'] = !empty( $request->bancas_id) ?  $request->bancas_id : session()->get('user.banca');
            $data['users_id'] = !empty( $request->users_id) ?  $request->users_id : session()->get('user.id');
        
            $data['empresas_id'] = session()->get('user.emp_id');

            
            $listaReporteVentas  = $this->posService->getReporteVentas($data);

            return  dataTables::of($listaReporteVentas)

            ->editColumn('total_venta', function ($row) {
                $total_venta = $row->total_venta ? $row->total_venta : 0;
                return '<span class="display_currency total_venta"  data-orig-value="' . $total_venta . '" data-currency_symbol = true>' . $total_venta . '</span>';
            })
            ->editColumn('total_venta_promo', function ($row) {
                $total_venta_promo = $row->total_venta_promo ? $row->total_venta_promo : 0;
                return '<span class="display_currency total_venta_promo"  data-orig-value="' . $total_venta_promo . '" data-currency_symbol = true>' . $total_venta_promo . '</span>';
            })
            ->editColumn('total_comision', function ($row) {
                $total_comision = $row->total_comision ? $row->total_comision : 0;
                return '<span class="display_currency total_comision" data-orig-value="' . $total_comision . '" data-currency_symbol = true>' . $total_comision . '</span>';
            })
            ->editColumn('total_premios', function ($row) {
                $total_premios = $row->total_premios ? $row->total_premios : 0;
                return '<span class="display_currency total_premios" data-orig-value="' . $total_premios . '" data-currency_symbol = true>' . $total_premios . '</span>';
            })
            ->editColumn('total_premios_promo', function ($row) {
                $total_premios_promo = $row->total_premios_promo ? $row->total_premios_promo : 0;
                return '<span class="display_currency total_premios_promo" data-orig-value="' . $total_premios_promo . '" data-currency_symbol = true>' . $total_premios_promo . '</span>';
            })
            ->editColumn('tic_ganancia', function ($row) {              
                
                    $tic_ganancia = $row->total_venta - $row->total_comision - $row->total_premios_promo - $row->total_premios;
                    return '<span class="display_currency ganancia" data-orig-value="' . $tic_ganancia . '" data-currency_symbol = true>' . $tic_ganancia . '</span>';
            })

            ->rawColumns([ 'total_venta', 'total_venta_promo', 'total_premios','total_premios_promo', 'total_comision', 'tic_ganancia'])
            ->make(true);

        }
    }
}