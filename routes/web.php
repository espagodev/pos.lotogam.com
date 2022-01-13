<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ControlApuestasController;
use App\Http\Controllers\CuadreCajaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImpresionPosController;
use App\Http\Controllers\LoteriasController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\ResultadoController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TrasladoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


//LOGIN
Route::get('/', function () {
    return view('/auth/login');
});
Auth::routes(['register' => false, 'reset' => false ]);

Route::get('authorization', [LoginController::class])->name('authorization');

Route::middleware(['SetSessionData','auth'])->group(function () {

   
   
   

    /**
     * dashboard
     */
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/getTotales', [DashboardController::class, 'getTotales'])->name('getTotales'); 
    Route::get('dashboard/getVentasMes', [DashboardController::class, 'getVentasMes'])->name('getVentasMes'); 
    Route::get('dashboard/getReporteTicketsPremiados', [DashboardController::class, 'getReporteTicketsPremiados'])->name('getReporteTicketsPremiados'); 
    Route::get('dashboard/getResultadosFecha', [DashboardController::class, 'getResultadosFecha'])->name('getResultadosFecha'); 

    /**
     * POS
     */
    Route::get('pos', [PosController::class, 'index'])->name('pos');

    Route::get('pos/postApuestaTemporal',[PosController::class, 'postApuestaTemporal'])->name('postApuestaTemporal');
    Route::get('pos/getHorarioLoterias', [LoteriasController::class, 'getHorarioLoterias'])->name('getHorarioLoterias'); 
    Route::get('pos/getHorarioSuperPale', [LoteriasController::class, 'getHorarioSuperPale'])->name('getHorarioSuperPale'); 
    Route::get('pos/getApuestaTemporal', [PosController::class, 'getApuestaTemporal'])->name('getApuestaTemporal'); 
    Route::get('pos/getSaldoDisponible', [PosController::class, 'getSaldoDisponible'])->name('getSaldoDisponible'); 
    Route::get('pos/validarLoteriaSeleccionada',[PosController::class, 'getvalidarLoteriaSeleccionada'])->name('getvalidarLoteriaSeleccionada');
    Route::get('pos/getvalidarLoteriaIndividual',[PosController::class, 'getvalidarLoteriaIndividual'])->name('getvalidarLoteriaIndividual');
    Route::get('pos/deleteApuestaTemporal',[PosController::class, 'deleteApuestaTemporal'])->name('deleteApuestaTemporal');
    Route::get('pos/eliminarApuestaTemporal',[PosController::class, 'eliminarApuestaTemporal'])->name('eliminarApuestaTemporal');
    Route::get('pos/generarTicket', [PosController::class, 'postGenerarTicket'])->name('postGenerarTicket');
    Route::get('pos/getDuplicarTicket/{ticket}', [PosController::class, 'getDuplicarTicket'])->name('getDuplicarTicket');

    
    /**
     * TRASLADO
     */
    Route::get('getTrasladoLista', [TrasladoController::class, 'getTrasladoLista'])->name('getTrasladoLista');
    Route::get('traslado', [TrasladoController::class, 'index'])->name('traslado');
    Route::get('traslado/getListadoTraslado', [TrasladoController::class, 'getListadoTraslado'])->name('getListadoTraslado');
    Route::get('traslado/getTrasladoNumero/{traslado}', [TrasladoController::class, 'getTrasladoNumero'])->name('getTrasladoNumero');

     /**
     * CONTROL APUESTAS
     */
    Route::get('controlApuestas/getControlApuestaLista', [ControlApuestasController::class, 'getControlApuestaLista'])->name('getControlApuestaLista');
    Route::get('controlApuestas/getControlApuestas', [ControlApuestasController::class, 'getControlApuestas'])->name('getControlApuestas');


     /**
     * RESULTADOS
     */
    Route::get('resultados', [ResultadoController::class, 'index'])->name('resultados');
    Route::get('resultados/getListadoResultados', [ResultadoController::class, 'getListadoResultados'])->name('getListadoResultados');
    Route::get('getNuevoResultado', [ResultadoController::class, 'getNuevoResultado'])->name('getNuevoResultado');
    Route::get('resultados/getValidaHoraCierre', [ResultadoController::class, 'getValidaHoraCierre'])->name('getValidaHoraCierre');
    Route::get('resultados/getGuardarResultados', [ResultadoController::class, 'getGuardarResultados'])->name('getGuardarResultados');
    Route::get('resultados/getResultadosDelete/{resultado}', [ResultadoController::class, 'getResultadosDelete'])->name('getResultadosDelete');
    
    /**
     * REPORTES
     */
    Route::get('reportes/getReporteVentas', [ReportesController::class, 'getReporteVentas'])->name('getReporteVentas');
    Route::get('reportes/getListaReporteVentas', [ReportesController::class, 'getListaReporteVentas'])->name('getListaReporteVentas');


    /**
     * CUADRE DE CAJA
     */
    Route::get('cuadre_caja', [CuadreCajaController::class, 'index'])->name('cuadreCaja');
    Route::get('cuadre_caja/getListadoCuadreCaja', [CuadreCajaController::class, 'getListadoCuadreCaja'])->name('getListadoCuadreCaja');
    Route::get('cuadre_caja/getListadoMovimientosDiarios', [CuadreCajaController::class, 'getListadoMovimientosDiarios'])->name('getListadoMovimientosDiarios');
    Route::get('cuadre_caja/getCuadreCajaDetalle', [CuadreCajaController::class, 'getCuadreCajaDetalle'])->name('getCuadreCajaDetalle');


    /**
     *  TICKET
     */
    Route::get('getTicketLista', [TicketController::class, 'getTicketLista'])->name('getTicketLista');

    Route::get('ticket/getListadoTickets', [TicketController::class, 'getListadoTickets'])->name('getListadoTickets');
    Route::get('ticket/getVerTicket/{ticket}', [TicketController::class, 'getVerTicket'])->name('getVerTicket');
    Route::get('ticket/getTicket', [TicketController::class, 'getTicket'])->name('getTicket');
    Route::get('ticket/getVerTicketAgrupado/{agrupado}', [TicketController::class, 'getVerTicketAgrupado'])->name('getVerTicketAgrupado');
    Route::get('ticket/getVerDuplicarTicket/{ticket}', [TicketController::class, 'getVerDuplicarTicket'])->name('getVerDuplicarTicket');
    Route::get('ticket/getTicketPremiado/{ticket}', [TicketController::class, 'getTicketPremiado'])->name('getTicketPremiado');
    Route::get('ticket/getTicketAnulado/{ticket}', [TicketController::class, 'getTicketAnulado'])->name('getTicketAnulado');
    Route::get('ticket/getPagarPremio', [TicketController::class, 'getPagarPremio'])->name('getPagarPremio');
    Route::get('ticket/getAnular', [TicketController::class, 'getAnular'])->name('getAnular');
    Route::get('ticket/getImprimirTicket/{ticket}', [TicketController::class, 'getImprimirTicket'])->name('getImprimirTicket');
    Route::get('ticket/getImprimirAgrupado/{agrupado}', [TicketController::class, 'getImprimirAgrupado'])->name('getImprimirAgrupado');


    /**
     * IMPRESION
     */
    Route::get('getImpresora', [ImpresionPosController::class, 'getImpresora'])->name('getImpresora');
    Route::get('/impresoras/getModificarImpresora', [ImpresionPosController::class, 'getModificarImpresora'])->name('getModificarImpresora');
});
// Route::get('/pos', function () {
//     return view('pos');
// })->middleware(['auth'])->name('pos');