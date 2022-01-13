<?php

namespace App\Http\Controllers;

use App\Utils\Util;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class TicketController extends Controller
{
    public function getTicketLista()
    {
        $data['empresas_id'] = session()->get('user.emp_id');
        $data['lot_superpale'] = 0;

        $loterias = $this->posService->getLoterias($data);
        $estadosTicket = Util::estadosTicket(); 
        return view('ticket.modal')->with(['loterias' => $loterias, 'estados' => $estadosTicket]);
    }

    public function getListadoTickets(Request $request)
    {
        if ($request->ajax()) {
            
            
            $data =  $request->only(['start_date', 'end_date', 'estado', 'promocion',]);
            $data['bancas_id'] = !empty($request->bancas_id) ?  $request->bancas_id : session()->get('user.banca');
            $data['users_id'] = !empty($request->users_id) ?  $request->users_id : session()->get('user.id');           
            $data['empresas_id'] = session()->get('user.emp_id');
            $data['loterias_id'] =  $request->get('loterias_id');
    
            $listadoTickets =  $this->posService->getListadoTickets($data);
               
            return dataTables::of($listadoTickets)
                ->editColumn('loteria', '$loteria')
                ->editColumn('tic_fecha_sorteo', '{{@format_datetime($tic_fecha_sorteo)}}')
                ->editColumn('tic_apostado', function ($row) {
                    if ($row->tic_promocion == 1) {
                        $tic_apostado = $row->tic_apostado ? $row->tic_apostado : 0;
                        return '<span class="display_currency" data-orig-value="' . $tic_apostado . '" data-currency_symbol = true>' . $tic_apostado . '</span><h5<span class="badge badge-info m-1">** Promocion **</span></h5>';

                    } else {
                        $tic_apostado = $row->tic_apostado ? $row->tic_apostado : 0;
                        return '<span class="display_currency" data-orig-value="' . $tic_apostado . '" data-currency_symbol = true>' . $tic_apostado . '</span>';
                    }
                })
               
                ->addColumn('tic_estado', function ($row) {
                    if ($row->tic_estado == 1) {
                        return '<h5<span class="badge badge-light m-1">Normal</span></h5>';
                    } else if ($row->tic_estado == 2) {
                        return '<h5<span class="badge badge-success m-1">Premiado</span></h5>';
                    } else if ($row->tic_estado == 3) {
                        return '<h5<span class="badge badge-info m-1">Pagado</span></h5>';
                    } else {
                        return '<h5<span class="badge badge-danger m-1">Anulado</span></h5>';
                    }
                })
                ->addColumn('action', function ($row) {
                  

                    $estado = '';
                    if($row->tic_agrupado != ''){
                        $estado .= '<button type="button"  data-href="' . route('getVerTicketAgrupado', [$row->tic_agrupado]) . '"  class="btn btn-outline-success btn-rounded btn-sm btn-modal"
                                    data-container=".view_register"><i class="icon-documents"></i> </button> ';
                    }
                    $estado .= '<button type="button" data-href="' . route('getVerTicket', [$row->id]) . '"  class="btn btn-outline-info btn-rounded btn-sm btn-modal"
                                    data-container=".view_register"><i class="icon-eye1"></i> </button>

                                     <a href="#" data-href="' . route('getImprimirTicket', [$row->id]) . '"  class="btn btn-outline-warning btn-rounded btn-sm print-invoice"
                                    ><i class="icon-printer"></i></a>';
                     if ($row->tic_estado == 2) {
                        $estado .= '<button type="button" data-href="' . route('getTicketPremiado', [$row->id]) . '"  class="btn btn-outline-success btn-rounded btn-sm  btn-modal"
                                    data-container=".view_ticket_modal"> <i class="icon-local_atm"></i> </button>';
                    } else if ($row->tic_estado == 3) {
                        $estado .= '<button type="button" data-href="' . route('getVerTicket', [$row->id]) . '"  class="btn btn-outline-info btn-rounded btn-sm btn-modal"
                                    data-container=".view_register"><i class="icon-eye1"></i> </button>';                    
                    }

                    $estado .= ' <button type="button" data-href="' . route('getVerDuplicarTicket', [$row->id]) . '"  class="btn btn-outline-secondary btn-rounded btn-sm btn-modal"
                                data-container=".view_register"><i class="icon-filter_none"></i></button>';

                   
                    if($row->anularTicket == 0){
                        if ($row->tic_estado != 0) {
                            $estado .= ' <button type="button" data-href="' . route('getTicketAnulado', [$row->id]) . '" class="btn btn-sm btn-outline-danger btn-rounded btn-sm btn-modal"
                            data-container=".view_register"><i class="icon-x-circle"></i></button>';
                        }
                    }
                  
                   
                    return $estado;
                })

                ->rawColumns(['action', 'tic_ticket', 'tic_apostado',  'tic_fecha_sorteo',  'tic_estado'])
                ->make(true);

        }
    }

    public function getVerTicket(Request $request, $ticketId)
    {
        $data['bancas_id'] = !empty($request->bancas_id) ?  $request->bancas_id : session()->get('user.banca');
        $data['users_id'] = !empty($request->users_id) ?  $request->users_id : session()->get('user.id');           
        $data['empresas_id'] = session()->get('user.emp_id');
        $data['printer_type'] =  !empty(session()->get('banca.impresora')) ? session()->get('banca.impresora') : 'browser';
        $data['getImagen'] =   !empty($request->getImagen) ? $request->getImagen : 1;
        $data['ticket'] =  $ticketId;

        $ticket = $this->posService->getTicket($data);
     
        return view('ticket.ticket')->with(compact('ticket','ticketId'));
    }

    public function getVerTicketAgrupado(Request $request, $agrupado)
    {
        $data['bancas_id'] = !empty($request->bancas_id) ?  $request->bancas_id : session()->get('user.banca');
        $data['users_id'] = !empty($request->users_id) ?  $request->users_id : session()->get('user.id');           
        $data['empresas_id'] = session()->get('user.emp_id');
        $data['printer_type'] = !empty(session()->get('banca.impresora')) ? session()->get('banca.impresora') : 'browser';
        $data['getImagen'] =   !empty($request->getImagen) ? $request->getImagen : 1;
        $data['agrupado'] =  $agrupado;
        
        $detalle_ticket = $this->posService->getTicketAgrupado($data);
       
        return view('ticket.modal_ticket_agrupado')->with(compact('detalle_ticket','agrupado'));
    }

    /**
     * Duplicar Ticket
     */
    public function getVerDuplicarTicket(Request $request, $ticketId)
    {
        $data['bancas_id'] = !empty($request->bancas_id) ?  $request->bancas_id : session()->get('user.banca');
        $data['users_id'] = !empty($request->users_id) ?  $request->users_id : session()->get('user.id');           
        $data['empresas_id'] = session()->get('user.emp_id');
        $data['printer_type'] =  !empty(session()->get('banca.impresora')) ? session()->get('banca.impresora') : 'browser';
        $data['getImagen'] =   !empty($request->getImagen) ? $request->getImagen : 1;
        $data['ticket'] =  $ticketId;

        $ticket = $this->posService->getTicket($data);
        
        return view('ticket.modal_ticket_duplicado')->with(compact('ticket','ticketId'));
    }

     /**
     *  Ticket Premiado
     */
    public function getTicketPremiado(Request $request, $ticketId)
    {
        $data['bancas_id'] = !empty($request->bancas_id) ?  $request->bancas_id : session()->get('user.banca');
        $data['users_id'] = !empty($request->users_id) ?  $request->users_id : session()->get('user.id');           
        $data['empresas_id'] = session()->get('user.emp_id');
        $data['printer_type'] =  !empty(session()->get('banca.impresora')) ? session()->get('banca.impresora') : 'browser';
        $data['getImagen'] =   !empty($request->getImagen) ? $request->getImagen : 1;
        $data['ticket'] =  $ticketId;

        $ticketPremiado = $this->posService->getTicketPremiado($data);

        $ticket = $ticketPremiado->ticket;
        $resultado = $ticketPremiado->resultado;
        $jugadas = $ticketPremiado->premio;
        
        return view('ticket.modal_ticket_premiado')->with(compact('ticket','resultado','jugadas','ticketId'));
    }

    /**
     *  Pagar Ticket Premiado
     */
    public function getPagarPremio(Request $request)
    {
        if ($request->ajax()) {

            $data['bancas_id'] = !empty($request->bancas_id) ?  $request->bancas_id : session()->get('user.banca');
            $data['users_id'] = !empty($request->users_id) ?  $request->users_id : session()->get('user.id');           
            $data['empresas_id'] = session()->get('user.emp_id');            

            $data['tickets_id'] = $request->get('tickets_id');
            $data['pin'] = $request->get('pin');
            $data['premio'] = $request->get('premio');
          
            $data = $this->posService->getPagarPremio($data);

            return $data;

        }
    }

    /**
     * imprimir ticket directo
     */

     public function getImprimirTicket(Request $request, $ticket)
     {
        if ($request->ajax()) {
            try {
                $data['bancas_id'] = !empty($request->bancas_id) ?  $request->bancas_id : session()->get('user.banca');
                $data['users_id'] = !empty($request->users_id) ?  $request->users_id : session()->get('user.id');           
                $data['empresas_id'] = session()->get('user.emp_id');
                $data['printer_type'] =  !empty(session()->get('banca.impresora')) ? session()->get('banca.impresora') : 'browser';
                $data['getImagen'] =   !empty($request->getImagen) ? $request->getImagen : 1;
                $data['ticket'] =  $ticket;
                
                $detalle_ticket[] = $this->posService->getTicket($data);
                
                $mensaje = 'Ticket Generado con éxito';
                
                if ($data['printer_type'] == 'printer' && $data['getImagen'] == 0) {         
                    $output = ['success' => 1, 'mensaje' => $mensaje, 'receipt' => $detalle_ticket];
                } else {   

                    // if($data['tic_agrupado'] == 1){
                    //     $layout = 'pos.receipts.formatoAgrupado58';  
                    // }else{
                        $layout = 'pos.receipts.formato58';  
                    // }           
                
                    $receipt['html_content'] = view($layout, compact('detalle_ticket'))->render();  
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

     public function getImprimirAgrupado(Request $request, $agrupado)
     {
        if ($request->ajax()) {
            try {
                $data['bancas_id'] = !empty($request->bancas_id) ?  $request->bancas_id : session()->get('user.banca');
                $data['users_id'] = !empty($request->users_id) ?  $request->users_id : session()->get('user.id');           
                $data['empresas_id'] = session()->get('user.emp_id');
                $data['printer_type'] = !empty(session()->get('banca.impresora')) ? session()->get('banca.impresora') : 'browser';
                $data['getImagen'] =   !empty($request->getImagen) ? $request->getImagen : 1;
                $data['agrupado'] =  $agrupado;
                
                $detalle_ticket = $this->posService->getTicketAgrupado($data);
                
                $mensaje = 'Ticket Generado con éxito';
                
                if ($data['printer_type'] == 'printer' && $data['getImagen'] == 0) {         
                    $output = ['success' => 1, 'mensaje' => $mensaje, 'receipt' => $detalle_ticket];
                } else {   

                    // if($data['tic_agrupado'] == 1){
                        $layout = 'pos.receipts.formatoAgrupado58';  
                    // }else{
                        // $layout = 'pos.receipts.formato58';  
                    // }           
                
                    $receipt['html_content'] = view($layout, compact('detalle_ticket'))->render();  
                    $output = ['success' => 1, 'mensaje' => $mensaje, 'receipt' => $receipt];
                }
            } catch (\Exception $e) {
                Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

                $output = [
                    'success' => 0,
                    'mensaje' => "Algo salió mal, Error al imprimir Ticket Agrupado"
                ];
            }
            return $output;
        }
     }

      /**
     *  Ticket Anulado
     */
    public function getTicketAnulado(Request $request, $ticketId)
    {
        $data['bancas_id'] = !empty($request->bancas_id) ?  $request->bancas_id : session()->get('user.banca');
        $data['users_id'] = !empty($request->users_id) ?  $request->users_id : session()->get('user.id');           
        $data['empresas_id'] = session()->get('user.emp_id');
        $data['printer_type'] =  !empty(session()->get('banca.impresora')) ? session()->get('banca.impresora') : 'browser';
        $data['getImagen'] =   !empty($request->getImagen) ? $request->getImagen : 1;
        $data['ticket'] =  $ticketId;

        $ticket = $this->posService->getTicket($data);
        
        return view('ticket.modal_ticket_anulado')->with(compact('ticket','ticketId'));
    }
     
    /**
     *  Anular Ticket
     */
    public function getAnular(Request $request)
    {
        if ($request->ajax()) {

            $data['bancas_id'] = !empty($request->bancas_id) ?  $request->bancas_id : session()->get('user.banca');
            $data['users_id'] = !empty($request->users_id) ?  $request->users_id : session()->get('user.id');           
            $data['empresas_id'] = session()->get('user.emp_id');            

            $data['tickets_id'] = $request->get('tickets_id');
            $data['pin'] = $request->get('pin');
            $data['tia_detalle'] = $request->get('detalle');
            
            $data = $this->posService->getAnular($data);

            return $data;

        }
    }
}
