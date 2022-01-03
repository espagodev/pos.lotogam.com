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
            // $parametrosBanca = $this->posService->getParametrosBanca($data);
            // dd($parametrosBanca);
            // $lotNombre = $request->lot_nombre;

            // foreach ($request->loterias_id as  $loteria)
            //     {

            //         $valores = explode("|", $loteria);

            //         $loterias_id = $valores[0];
            //         $superpale = $valores[1];

            //         if(!empty($detalleTemporales)) {
            //             foreach ($detalleTemporales as $detalle) {

            //                 if ($superpale == 1) {
            //                     $modalidades_id = 4;
            //                 } else {
            //                     $modalidades_id = $detalle->modalidades_id;
            //                 }

            //                 $montoGlobal = Montos::MontoGlobal($parametrosBanca->montos_globales_id, $modalidades_id);

            //                 $montoIndividual = Montos::MontoIndividual($parametrosBanca->montos_individuales_id, $modalidades_id);

            //                 $controlNumeroGlobal = Util::ControlNumeroJugado($loterias_id, $bancas_id = null, $users_id = null, $detalle->apt_apuesta);

            //                 $controlNumero = Util::ControlNumeroJugado($loterias_id, $request->bancas_id, $request->users_id, $detalle->apt_apuesta);

            //                 $totalApuesta = Util::totalApuesta($detalle->apt_valor, $controlNumero);

            //                 $comparacion = Util::compararValores($montoIndividual, $controlNumero);

            //                 if ($comparacion == 1) {
            //                     $arrayVendidos[] = $detalle->apt_apuesta;
            //                 }

            //                 if ($totalApuesta > $montoIndividual) {
            //                     $arrayIndividual[] = $detalle->apt_apuesta . ' Supera Limite de Apuesta Permitido  de ' . $montoIndividual;
            //                 }

            //                 if ($controlNumeroGlobal >= $montoGlobal) {
            //                     $arrayGlobal[] = $detalle->apt_apuesta . ' El Numero no esta Disponible por el Momento';
            //                 }

            //                 if ($montoIndividual > $montoGlobal) {
            //                     $compararMontos =  ' El Limite Individual no Puede ser Mayor que el Global, Contacte con el Administrador ';
            //                 }
            //             }
            //         }else{

            //                 /**
            //                  * NOMBRE LOTERIA
            //                  */

            //                 $lot_nombre = $this->marketService->getLoteriaNombre($loterias_id);
            //                 $lotNombre = $lot_nombre->lot_nombre;

            //                 /**
            //                  * VALIDA SI EL NUMERO TIENE 1 DIGITO LE AÑADE EL 0
            //                  */
            //                 $NumeroValidado = Util::numeroValido($request->tid_apuesta);

            //                 /**
            //                  * confirmo la modalidad de la jugada
            //                  */
            //                 $modalidad = Util::modalidad($NumeroValidado);

            //                 $montoGlobal = Montos::MontoGlobal($parametrosBanca->montos_globales_id, $modalidad);

            //                 $montoIndividual = Montos::MontoIndividual($parametrosBanca->montos_individuales_id, $modalidad);

            //                 $controlNumeroGlobal = Util::ControlNumeroJugado($loterias_id, $bancas_id = null, $users_id = null, $request->tid_apuesta);

            //                 $controlNumero = Util::ControlNumeroJugado($loterias_id, $request->bancas_id, $request->users_id, $request->tid_apuesta);

            //                 $totalApuesta = Util::totalApuesta($request->tid_valor, $controlNumero);

            //                 $comparacion = Util::compararValores($montoIndividual, $controlNumero);

            //                 dump($lotNombre,$modalidad, $montoGlobal, $montoIndividual, $controlNumeroGlobal, $controlNumero, $totalApuesta, $comparacion);

            //                 if ($comparacion == 1) {
            //                     $arrayVendidos[] = $request->tid_apuesta;
            //                 }

            //                 if ($totalApuesta > $montoIndividual) {
            //                     $arrayIndividual[] = $request->tid_apuesta . ' Supera Limite de Apuesta Permitido  de ' . $montoIndividual;
            //                 }

            //                 if ($controlNumeroGlobal >= $montoGlobal) {
            //                     $arrayGlobal[] = $request->tid_apuesta . ' El Numero no esta Disponible por el Momento';
            //                 }

            //                 if ($montoIndividual > $montoGlobal) {
            //                     $compararMontos =  ' El Limite Individual no Puede ser Mayor que el Global, Contacte con el Administrador ';
            //                 }
            //         }
            //     }

            //         $vendidos = trim(implode(" , ", $arrayVendidos));
            //         $vendidos = "'" . $vendidos . "'";

            //         $supera = trim(implode(" , ", $arrayIndividual));
            //         $supera = "$supera ";

            //         $global = trim(implode(" , ", $arrayGlobal));
            //         $global = "$global ";

            //         if (count($arrayVendidos) != "0") {
            //             return response()->json([
            //                 'numero' => $vendidos,
            //                 'loteria' => $lotNombre,
            //                 'status' => 1,
            //             ]);
            //         }

            //         if (count($arrayIndividual) != "0") {
            //             return response()->json([
            //                 'numero' => $supera,
            //                 'loteria' => $request->lot_nombre,
            //                 'status' => 2,
            //             ]);
            //         }

            //         if (count($arrayGlobal) != "0") {
            //             return response()->json([
            //                 'numero' => $global,
            //                 'loteria' => $lotNombre,
            //                 'status' => 3,
            //             ]);
            //         }

            //         if ($compararMontos != "") {
            //             return response()->json([
            //                 'numero' => $compararMontos,
            //                 'status' => 4,
            //             ]);
            //         }
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
        $validarHoracierreLoteria = Horario::validarHoracierreLoteria($request->loterias_id);

        
        if ($validarHoracierreLoteria) {
            return  $output = ['error' => 1, 'mensaje' => 'La Loteria no Esta Disponible Para Realizar Jugadas'];
        }
        
        $detalle_ticket = $this->posService->postNuevoTicket($data);
        // dd($detalle_ticket);
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
