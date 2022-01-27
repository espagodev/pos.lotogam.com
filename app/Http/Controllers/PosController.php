<?php

namespace App\Http\Controllers;

use App\Utils\Horario;
use App\Utils\Util;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index()
    {
        $fechaActual = now()->format('d/m/Y');
        $symbol = request()->session()->get('monedaBanca.symbol');
        return view('pos.index', compact('symbol','fechaActual'));
    }
    
    public function postApuestaTemporal(Request $request)
    {

        $data['bancas_id'] = !empty($request->bancas_id) ? $request->bancas_id : session()->get('user.banca');
        $data['users_id'] = !empty($request->users_id) ? $request->users_id : session()->get('user.id');
        $data['empresas_id'] = session()->get('user.emp_id');
        $data['tid_apuesta'] =  $request->tid_apuesta ;
        $data['tid_valor'] =  $request->tid_valor;
        $data['loterias_id']  = $request->loterias_id;
       
        
        $jugada =  $this->posService->postApuestaTemporal($data);

        return $jugada;
    }

    public function getApuestaTemporal(Request $request)
    {
        if ($request->ajax()) {
            $row_count = request()->get('product_row');
            $data['bancas_id'] = !empty($request->bancas_id) ? $request->bancas_id : session()->get('user.banca');
            $data['users_id'] = !empty($request->users_id) ? $request->users_id : session()->get('user.id');

            $detalleTemporales = $this->posService->getApuestaTemporal($data);

            $ticketDetalles = '';
            $datos[] = '';
            foreach ($detalleTemporales as  $detalle) {
                $row_count = $row_count + 1;
                $ticketDetalles .= '<tr class="product_row" >' .
                    '<td>' . $detalle->mod_nombre . '</td>' .
                    '<td>
                    <input type="hidden" class="form-control pos_line_total " value="' .  $detalle->apt_valor . '">
                    <span class="display_currency" data-orig-value=' .  $detalle->apt_valor . ' data-currency_symbol="true">' .  $detalle->apt_valor . '</span>
                    </td>' .
                    '<td>' . $detalle->apt_apuesta . '</td>' .
                    '<td>
                        <span class="btn btn-sm btn-outline-danger waves-effect waves-light borrar" data-record-id="' . $detalle->id . '"><i class="icon-cancel"></i></span>
                    </td>' .
                    '</tr>';
            }
            $datos = ['ticketDetalles' => $ticketDetalles, 'row_count' => $row_count];
            return  $datos;
        }
    }

    public function getvalidarLoteriaSeleccionada(Request $request)
    {

        if ($request->ajax()) {


            $data['bancas_id'] = !empty($request->bancas_id) ? $request->bancas_id : session()->get('user.banca');
            $data['users_id'] = !empty($request->users_id) ? $request->users_id : session()->get('user.id');
            $data['empresas_id'] = session()->get('user.emp_id');
            $data['tid_apuesta'] =  $request->tid_apuesta ;
            $data['tid_valor'] =  $request->tid_valor;
            $data['loterias_id']  = $request->loterias_id;
            
            $detalleTemporales = $this->posService->getvalidarLoteriaSeleccionada($data);           

            return $detalleTemporales;
           
            }
    }

    public function getvalidarLoteriaIndividual(Request $request)
    {
     
        if ($request->ajax()) {

            $data['bancas_id'] = !empty($request->bancas_id) ? $request->bancas_id : session()->get('user.banca');
            $data['users_id'] = !empty($request->users_id) ? $request->users_id : session()->get('user.id');
            $data['empresas_id'] = session()->get('user.emp_id');
            $data['loterias_id']  = $request->loterias_id;
            $data['lot_superpale']  = $request->lot_superpale;

            
            $detalleTemporales = $this->posService->getvalidarLoteriaIndividual($data);           

            return $detalleTemporales;
           
            }
    }

    public function deleteApuestaTemporal(Request $request)
    {

        $data['bancas_id'] = !empty($request->bancas_id) ? $request->bancas_id : session()->get('user.banca');
        $data['users_id'] = !empty($request->users_id) ? $request->users_id : session()->get('user.id');

        $delete =  $this->posService->deleteApuestaTemporal($data);

        return $delete;
    }

    public function eliminarApuestaTemporal(Request $request)
    {

        $data['bancas_id'] = !empty($request->bancas_id) ? $request->bancas_id : session()->get('user.banca');
        $data['users_id'] = !empty($request->users_id) ? $request->users_id : session()->get('user.id');
        $data['apuesta_id'] = $request->apuesta_id;

        $delete =  $this->posService->eliminarApuestaTemporal($data);

        return $delete;
    }

    public function postGenerarTicket(Request $request)
    {
        
        $data['bancas_id'] = !empty($request->bancas_id) ? $request->bancas_id : session()->get('user.banca');
        $data['users_id'] = !empty($request->users_id) ? $request->users_id : session()->get('user.id');
        $data['empresas_id'] = session()->get('user.emp_id');
        $data['tic_fecha_sorteo']  =  !empty($request->tic_fecha_sorteo) ? Carbon::createFromFormat('d/m/Y', $request->tic_fecha_sorteo, 'America/Santo_Domingo')->format('Y-m-d H:i:s') : (new Carbon(date('Y-m-d H:i:s')))->tz('America/Santo_Domingo')->format('Y-m-d H:i:s');
        $data['tic_promocion']  = !empty($request->tic_promocion) ? $request->tic_promocion : 0;
        $data['tic_agrupado']  = !empty($request->tic_agrupado) ? $request->tic_agrupado : 0;
        $data['loterias_id']  = $request->loterias_id;
        $data['printer_type'] =  !empty(session()->get('banca.impresora')) ? session()->get('banca.impresora') : 'browser';
        $data['getImagen'] =   !empty($request->getImagen) ? $request->getImagen : 0;
        $data['totalTickets']  = !empty($request->totalTickets) ? $request->totalTickets : 0;
        
        $validarHoracierreLoteria = Horario::validarHoracierreLoteria($request->loterias_id);
        
        $validarSaldoDisponible = $this->posService->getValidarSaldoDisponible($data);

        if ($validarSaldoDisponible->status == 'error') {
            return  $output = ['error' => 1, 'mensaje' => $validarSaldoDisponible->message];
        }
       
        if ($validarHoracierreLoteria) {
            return  $output = ['error' => 1, 'mensaje' => 'La Loteria no Esta Disponible Para Realizar Jugadas'];
        }
        
        $detalle_ticket = $this->posService->postNuevoTicket($data);
        
        if (!empty($detalle_ticket->status)) {
          return    $output = ['error' => 1, 'mensaje' => $detalle_ticket->mensaje];
        }

       
        $mensaje = 'Ticket Generado con éxito';
        
        if ($data['printer_type'] == 'printer' && $data['getImagen'] == 0) {         
            $output = ['success' => 1, 'mensaje' => $mensaje, 'receipt' => $detalle_ticket];
        } else {   

            if($data['tic_agrupado'] == 1){
                $layout = 'pos.receipts.formatoAgrupado58';  
            }else{
                $layout = 'pos.receipts.formato58';  
            }           
         
            $receipt['html_content'] = view($layout, compact('detalle_ticket'))->render();  
            $output = ['success' => 1, 'mensaje' => $mensaje, 'receipt' => $receipt];
        }

        return $output;
    }

    public function getSaldoDisponible()
    {
            $data['bancas_id'] = session()->get('user.banca');
            $data['users_id'] = session()->get('user.id');

            $output = $this->posService->getSaldoDisponible($data);       
    
            return $output;
        
    }

    public function getDuplicarTicket(Request $request, $ticket)
    {
        $data['bancas_id'] = session()->get('user.banca');
        $data['users_id'] = session()->get('user.id');
        $data['ticket'] = $ticket;

        $output = $this->posService->getDuplicarTicket($data);       
       
        return redirect()->to('pos');
    }
}
