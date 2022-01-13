<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class DashboardController extends Controller
{

    public function index()
    {
        $date_filters['this_month']['start'] = date('Y-m-01');
        $date_filters['this_month']['end'] = date('Y-m-t');
        $date_filters['this_week']['start'] = date('Y-m-d', strtotime('monday this week'));
        $date_filters['this_week']['end'] = date('Y-m-d', strtotime('sunday this week'));
        
        return view('dashboard.index', compact('date_filters'));
    }

    /**
     * Retrieves purchase and sell details for a given time period.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTotales(Request $request)
    {
        if (request()->ajax()) {

           
            $data['bancas_id'] = !empty( $request->bancas_id) ?  $request->bancas_id : session()->get('user.banca');
            $data['users_id'] = !empty( $request->users_id) ?  $request->users_id : session()->get('user.id');            
            $data['empresas_id'] = session()->get('user.emp_id');


            $data['start_date'] = request()->start;
            $data['end_date'] = request()->end;

           
            $detalle_ventas = $this->posService->getTotales($data);

            $output['totalTickets'] = $detalle_ventas->total_tickets;
            $output['totalVenta'] =    $detalle_ventas->total_venta;
            $output['totalComision'] =  $detalle_ventas->total_comision;
            $output['totalPremios'] = $detalle_ventas->total_premios;


            return $output;
        }
    }

    public function getVentasMes(Request $request)
    {
        if ($request->ajax()) {

                $data =  $request->only(['start_date', 'end_date', 'loterias_id', 'estado', 'promocion']);
                $data['bancas_id'] = !empty( $request->bancas_id) ?  $request->bancas_id : session()->get('user.banca');
                $data['users_id'] = !empty( $request->users_id) ?  $request->users_id : session()->get('user.id');            
                $data['empresas_id'] = session()->get('user.emp_id');

            
            $reporteVentas  = $this->posService->getReporteVentas($data);

            return  dataTables::of($reporteVentas)

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

    public function getReporteTicketsPremiados(Request $request)
    {
        if ($request->ajax()) {

            $data =  $request->only(['start_date', 'end_date', 'loterias_id', 'estado', 'promocion']);
            $data['bancas_id'] = !empty( $request->bancas_id) ?  $request->bancas_id : session()->get('user.banca');
            $data['users_id'] = !empty( $request->users_id) ?  $request->users_id : session()->get('user.id');            
            $data['empresas_id'] = session()->get('user.emp_id');
            
            $reportePremiados =  $this->posService->getReporteTicketsPremiados($data);
               
            return  dataTables::of($reportePremiados)
            ->editColumn('loteria', '$loteria')

            ->editColumn('tic_fecha_sorteo', '{{@format_date($tic_fecha_sorteo)}}')
            ->editColumn('tic_apostado', function ($row) {
                if ($row->tic_promocion == 1) {
                    $tic_apostado = $row->tic_apostado ? $row->tic_apostado : 0;
                    return '<span class="display_currency" data-orig-value="' . $tic_apostado . '" data-currency_symbol = true>' . $tic_apostado . '</span><span class="badge badge-info m-1">** Promocion **</span>';
                } else {
                    $tic_apostado = $row->tic_apostado ? $row->tic_apostado : 0;
                    return '<span class="display_currency" data-orig-value="' . $tic_apostado . '" data-currency_symbol = true>' . $tic_apostado . '</span>';
                }
            })
            ->editColumn('tic_ganado', function ($row) {
                $tic_ganado = $row->tic_ganado ? $row->tic_ganado : 0;
                return '<span class="display_currency tic_ganado" data-orig-value="' . $tic_ganado . '" data-currency_symbol = true>' . $tic_ganado . '</span>';
            })
           
            ->addColumn('action', function ($row) {

                $estado = '';

                if($row->tic_estado == 2) {
                            $estado .= '<button type="button" data-href="' . route('getVerTicket', [$row->id]) . '"  class="btn btn-outline-info btn-rounded btn-sm btn-modal"
                            data-container=".view_register"><i class="icon-eye1"></i> </button>

                            <button type="button" data-href="' . route('getTicketPremiado', [$row->id]) . '"  class="btn btn-outline-success btn-rounded btn-sm  btn-modal"
                            data-container=".view_ticket_modal"> <i class="icon-local_atm"></i> </button>';
               
                }
 
                return $estado;
            })

            ->rawColumns(['action', 'tic_ticket', 'tic_apostado', 'tic_ganado', 'tic_fecha_sorteo'])
            ->make(true);

        }
    }

    public function getResultadosFecha(Request $request)
    {
        if ($request->ajax()) {

            $data['empresas_id'] = !empty(session()->get('user.emp_id')) ? session()->get('user.emp_id') : "2";
            $data['start_date'] =  $request->get('start_date');
            $data['end_date'] =   $request->get('end_date');
            $data['loterias_id'] =   $request->get('loterias_id');

            $resultadoFechas = $this->posService->getResultadosFecha($data);

            $output = '';
            foreach ($resultadoFechas as  $detalle) {

                $output .= '<tr>' .
                    '<td>' . $detalle->lot_nombre . '</td>' .
                    "<td>
                            <span class='badge badge-pill badge-primary m-1'> $detalle->res_premio1</span>
                            <span class='badge badge-pill badge-secondary m-1'> $detalle->res_premio2</span>
                            <span class='badge badge-pill badge-success m-1'> $detalle->res_premio3</span></td>" .

                    '</tr>';
            }

            return $output;
        }

    }

}
