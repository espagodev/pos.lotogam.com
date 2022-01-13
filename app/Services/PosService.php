<?php

namespace App\Services;

use App\Traits\AuthorizesPosRequests;
use App\Traits\ConsumesExternalServices;
use App\Traits\InteractsWithPosResponses;

class PosService
{
    use ConsumesExternalServices, AuthorizesPosRequests, InteractsWithPosResponses;

    /**
     * The url from which send the requests
     * @var string
     */
    protected $baseUri;

    public function __construct()
    {
        $this->baseUri = config('services.pos.base_uri');
    }

    /**
     * * Retrieve a user information from the API
     * @return stdClass
     */
    public function getUserInformation()
    {
        return $this->makeRequest('GET', "me");
    }

    //Reportes
    public function getReporteVentas($data)
    {
        return $this->makeRequest('GET', "getReporteVentas", $data);
    }

    //Home reportes

    public function getTotales($data)
    {
        return $this->makeRequest('GET', "getTotales", $data);
    }

    public function getResultadosFecha($data)
    {
        return $this->makeRequest('GET', "getResultadosFecha", $data);
    }

    public function getReporteTicketsPremiados($data)
    {
        return $this->makeRequest('GET', "getReporteTicketsPremiados", $data);
    }

    /**
     * BANCAS
     */
    public function getBanca($banca_id)
    {        
        return $this->makeRequest('GET', "getBanca/{$banca_id}");
    }

    public function getMonedaBanca($banca_id)
    {
        return $this->makeRequest('GET', "getMonedaBanca/{$banca_id}");
    }

    public function getParametrosBanca($banca_id)
    {
        return $this->makeRequest('GET', "getParametrosBanca/{$banca_id}");
    }
    
    /**
     * EMPRESAS
     */

    public function getEmpresa($empresa_id)
    {      
        return $this->makeRequest('GET', "getEmpresa/{$empresa_id}");
    }

    public function getMonedaEmpresa($empresa_id)
    {
        return $this->makeRequest('GET', "getMonedaEmpresa/{$empresa_id}");
    }

    /**
     * LOTERIAS
     */

    public function getHorarioLoterias($data)
    {
        return $this->makeRequest('GET', "getHorarioLoterias", $data);
    }

    public function getHorarioSuperPale($data)
    {
        return $this->makeRequest('GET', "getHorarioSuperPale", $data);
    }

    public function getLoterias($data)
    {
        return $this->makeRequest('GET', "getLoterias", $data);
    }

    //Modalidades
    public function getModalidades()
    {
        return $this->makeRequest('GET', "getModalidades");
    }


    //PROGRESSBAR
    public function getprogressbar($users_id)
    {
        return $this->makeRequest('GET', "getprogressbar/{$users_id}");
    }

    //JUGADAS
    public function getApuestaTemporal($data)
    {
        return $this->makeRequest('GET', "getApuestaTemporal",$data);
    }

    //JUGADAS
    public function postApuestaTemporal($data)
    {
        return $this->makeRequest('post', "postApuestaTemporal",$data);
    }

    //VALIDAR APUESTAS SI ESTA SELECCIONADA LA LOTERIA
    public function getvalidarLoteriaSeleccionada($data)
    {
        return $this->makeRequest('get', "getvalidarLoteriaSeleccionada",$data);
    }

    //VALIDAR JUGADAS AL MOMENTO DE SELECIONAR LOTERIAS
    public function getvalidarLoteriaIndividual($data)
    {
        return $this->makeRequest('get', "getvalidarLoteriaIndividual",$data);
    }


     //SALDO DISPONIBLE BARRA DE ESTADO
     public function getSaldoDisponible($data)
     {
         return $this->makeRequest('get', "getSaldoDisponible",$data);
     }
 

    //ELIMINAR APUESTA TEMPORAL
    public function eliminarApuestaTemporal($data)
    {
        return $this->makeRequest('DELETE', "eliminarApuestaTemporal",$data);
    }

    //BORRAR JUGADA 
    public function deleteApuestaTemporal($data)
    {
        return $this->makeRequest('DELETE', "deleteApuestaTemporal", $data);
    }

    //GENERAR TICKET
    public function postNuevoTicket($data)
    {        
        return $this->makeRequest('post', "postNuevoTicket", $data);
    }

    /**
     * Duplicar Ticket
     */
    public function getDuplicarTicket($data)
    {
        return $this->makeRequest('GET', "getDuplicarTicket", $data);
    }

    /**
     * LISTADO DE TICKETS
     */
     public function getListadoTickets($data)
    {
        return $this->makeRequest('GET', "getListadoTickets", $data);
    }

    public function getTicket($data)
    {
        return $this->makeRequest('GET', "getTicket", $data);
    }

    public function getTicketAgrupado($data)
    {
        return $this->makeRequest('GET', "getTicketAgrupado", $data);
    }

    public function getTicketPremiado($data)
    {
        return $this->makeRequest('GET', "getTicketPremiado", $data);
    }

    public function getPagarPremio($data)
    {
        return $this->makeRequest('GET', "getPagarPremio", $data);
    }

    public function getAnular($data)
    {
        return $this->makeRequest('GET', "getAnular", $data);
    }

    /**
     * LISTADO DE TRASLADO
     */
    public function getListadoTraslado($data)
    {
        return $this->makeRequest('GET', "getListadoTraslado", $data);
    }

    public function getTrasladoActivo($data)
    {
        return $this->makeRequest('GET', "getTrasladoActivo", $data);
    }

    public function getTrasladoNumero($data)
    {
        return $this->makeRequest('GET', "getTrasladoNumero", $data);
    }
    

    /**
     * LISTADO DE CONTROL APUESTAS
     */
    public function getListadoControlApuesta($data)
    {
        return $this->makeRequest('GET', "getListadoControlApuesta", $data);
    }

     /**
     * LISTADO RESULTADOS
     */
    public function getListadoResultados($data)
    {
        return $this->makeRequest('GET', "getListadoResultados", $data);
    }
    
    /**
     * VALIDA HORA CIERRE LOTERIA
     */
    public function getValidaHoraCierre($data)
    {
        return $this->makeRequest('GET', "getValidaHoraCierre", $data);
    }

    /**
     * GUARDAR RESULTADOS
     */
    public function getGuardarResultados($data)
    {
        return $this->makeRequest('GET', "getGuardarResultados", $data);
    }

    /**
     * eliminar resultados
     */
    public function getResultadosDelete($data)
    {
        return $this->makeRequest('GET', "getResultadosDelete", $data);
    }

     /**
     * REPORTES
     */
    public function getListaReporteVentas($data)
    {
        return $this->makeRequest('GET', "getListaReporteVentas", $data);
    }

    /**
     * CUADRE DE CAJA
     */
    public function getListadoCuadreCaja($data)
    {
        return $this->makeRequest('GET', "getListadoCuadreCaja", $data);
    }

    public function getListadoMovimientosDiarios($data)
    {
        return $this->makeRequest('GET', "getListadoMovimientosDiarios", $data);
    }

    public function getCuadreCajaDetalle($data)
    {
        return $this->makeRequest('GET', "getCuadreCajaDetalle", $data);
    }

    /**
     * LISTADO DE IMPRESORAS
     */

    public function getImpresorasEmpresa($data)
    {
        return $this->makeRequest('GET', "getImpresorasEmpresa", $data);
    }

    public function getModificarImpresora($data)
    {
        return $this->makeRequest('GET', "getModificarImpresora", $data);
    }
}
