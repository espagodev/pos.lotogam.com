<?php

namespace App\Http\Controllers;

use App\Utils\Util;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CuadreCajaController extends Controller
{
    public function index()
    {     
        $data['empresas_id'] = session()->get('user.emp_id');
        $data['lot_superpale'] = 0;
        
        $loterias = $this->posService->getLoterias($data);  
        $movimientosCaja = Util::movimientosCaja();
        return view('cuadre_caja.index')->with(['loterias' => $loterias, 'movimientosCaja' => $movimientosCaja]);
    }


    public function getListadoCuadreCaja(Request $request)
    {
        if ($request->ajax()) {


                $data =  $request->only(['start_date', 'end_date']);
                $data['bancas_id'] = !empty( $request->bancas_id) ?  $request->bancas_id : session()->get('user.banca');
                $data['users_id'] = !empty( $request->users_id) ?  $request->users_id : session()->get('user.id');            
                $data['empresas_id'] = session()->get('user.emp_id');

            
            $listadoCuadreCaja  = $this->posService->getListadoCuadreCaja($data);

            return  DataTables::of($listadoCuadreCaja)
     
                ->editColumn('users_id', function ($row) {
                    return  $row->name;
                })
                ->editColumn('cgc_balance_inicial', function ($row) {
                return '<span class="display_currency" data-currency_symbol="true">' .
                    $row->cgc_balance_inicial . '</span>';
                })
                ->editColumn('cgc_total_entradas', function ($row) {
                    return '<span class="display_currency" data-currency_symbol="true">' .
                        $row->cgc_total_entradas . '</span>';
                 })
                ->editColumn('cgc_total_salidas', function ($row) {
                    return '<span class="display_currency" data-currency_symbol="true">' .
                        $row->cgc_total_salidas . '</span>';
                })
                ->editColumn('cgc_total_comisiones', function ($row) {
                    return '<span class="display_currency" data-currency_symbol="true">' .
                        $row->cgc_total_comisiones . '</span>';
                })
                ->editColumn('cgc_total_venta_neta', function ($row) {
                    return '<span class="display_currency" data-currency_symbol="true">' .
                        $row->cgc_total_venta_neta . '</span>';
                })
                ->editColumn('cgc_total_premios', function ($row) {
                    return '<span class="display_currency" data-currency_symbol="true">' .
                        $row->cgc_total_premios . '</span>';
                })
                ->editColumn('disponible', function ($row) { 
                    return '<span class="display_currency" data-currency_symbol="true">' .
                        $row->ban_limite_venta . '</span>';
                })
                ->editColumn('cgc_balance_final', function ($row) {
                    return '<span class="display_currency" data-currency_symbol="true">' .
                        $row->cgc_balance_final . '</span>';
                })
               
                ->editColumn('cgc_total_venta', function ($row) {
                  return '<span class="display_currency" data-currency_symbol="true">' .
                                             $row->cgc_total_venta . '</span>';
                                       
              
                })
                ->editColumn('cgc_fecha_movimiento', '{{@format_date($cgc_fecha_movimiento)}}')

                ->rawColumns([ 'cgc_balance_inicial','cgc_total_entradas','cgc_total_salidas','cgc_total_venta','cgc_total_venta_neta','cgc_total_comisiones','cgc_total_premios','cgc_balance_final','cgc_fecha_movimiento','disponible'])
            ->make(true);

        }
    }
    
    public function getListadoMovimientosDiarios(Request $request)
    {
        if ($request->ajax()) {


                $data =  $request->only(['start_date', 'end_date', 'movimiento_id']);
                $data['bancas_id'] = !empty( $request->bancas_id) ?  $request->bancas_id : session()->get('user.banca');
                $data['users_id'] = !empty( $request->users_id) ?  $request->users_id : session()->get('user.id');            
                $data['empresas_id'] = session()->get('user.emp_id');

            
            $listadoMovimientosDiarios  = $this->posService->getListadoMovimientosDiarios($data);

            return  DataTables::of($listadoMovimientosDiarios)
            
            ->editColumn('cag_fecha_movimiento', '{{@format_date($cag_fecha_movimiento)}}')

            ->editColumn('bancas_id', function ($row) {
                return  $row->ban_cod . ' - ' . $row->ban_nombre;
            })
            ->editColumn('users_id', function ($row) {
                return  $row->name;
            })
            ->editColumn('cag_monto', function ($row) {

            return '<span class="display_currency" data-currency_symbol="true">' .
                $row->cag_monto . '</span>';
            })

            ->rawColumns(['cag_fecha_movimiento', 'cag_monto'])
        ->make(true);

        }
    }

    public function getCuadreCajaDetalle(Request $request)
    {
        if ($request->ajax()) {


                $data =  $request->only(['start_date', 'end_date']);
                $data['bancas_id'] = !empty( $request->bancas_id) ?  $request->bancas_id : session()->get('user.banca');
                $data['users_id'] = !empty( $request->users_id) ?  $request->users_id : session()->get('user.id');            
                $data['empresas_id'] = session()->get('user.emp_id');

                $cuadreCajaDetalle  = $this->posService->getCuadreCajaDetalle($data);
              
                                
                    return [
                    'balance_inicial' => $cuadreCajaDetalle->balance_inicial,
                    'total_entradas' => $cuadreCajaDetalle->total_entradas,
                    'total_salidas' => $cuadreCajaDetalle->total_salidas,
                    // 'total_cupo' => $cuadreCajaDetalle->total_cupo,
                    'total_venta' => $cuadreCajaDetalle->total_venta_neta,
                    'balance_final' => $cuadreCajaDetalle->balance_final
                ];
        }
    }
}
