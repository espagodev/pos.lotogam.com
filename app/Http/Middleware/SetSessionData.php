<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\Auth;
use App\Services\PosService;


class SetSessionData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if (!$request->session()->has('user')) {

        $posService = resolve(PosService::class);

        $user = $posService->getUserInformation();
       

        $session_data = [
            'id' => $user->identificador,
            'surname' => $user->nombre,
            'email' => $user->email,
            'emp_id' => $user->idEmpresa,
            'TipoUsuario' => $user->tipoUsuario,
            'banca' => $user->idBanca,            
            'bancaBloqueo' => $user->bancaBloqueo,
            'userHorario' =>  isset($user->userHorario) ? $user->userHorario : '1',
        ];
       
        if ($user->tipoUsuario != 1) {
           
            $empresa = $posService->getEmpresa($user->idEmpresa);
            $monedaEmpresa = $posService->getMonedaEmpresa($user->idEmpresa);
           
            $banca = $posService->getBanca($user->idBanca);
            $monedaBanca = $posService->getMonedaBanca($user->idBanca);
            
            $empresa_data = [
                'date_format' => $empresa->emp_formato_fecha,
                'time_zone ' => $empresa->emp_zona_horaria,
                'logo ' => $empresa->emp_imagen,
                'currency_symbol_placement ' => $empresa->emp_ubicacion_simbolo_moneda,
            ];

            $monedaBanca_data = [
                'id' => $monedaBanca->id,
                'code' => $monedaBanca->codigo,
                'symbol' => $monedaBanca->simbolo,
                'thousand_separator' => $monedaBanca->separador_miles,
                'decimal_separator' => $monedaBanca->separador_decimal
            ];

            $monedaEmpresa_data = [
                'id' => $monedaEmpresa->id,
                'code' => $monedaEmpresa->codigo,
                'symbol' => $monedaEmpresa->simbolo,
                'thousand_separator' => $monedaEmpresa->separador_miles,
                'decimal_separator' => $monedaEmpresa->separador_decimal
            ];

            $banca_data = [
                'limite_venta' => isset($banca->ban_limite_venta) ? $banca->ban_limite_venta : '0',
                'ban_url' => isset($banca->ban_url) ? $banca->ban_url : '',
                'zonaHoraria' => $banca->ban_zonaHoraria,
                'impresora' => $banca->ban_tipo_impresora,
            ];

            $user_permisos = [
                'useCuadreCaja' => $user->useCuadreCaja,
                'useSupervisor' => $user->useSupervisor,
                'useVentaFuturo' => $user->useVentaFuturo,
                'usePromocion' => $user->usePromocion,
                'resultados' => $user->resultado,
                'useVentaAgrupada' => $user->useVentaAgrupada,
                'useTicketImagen' => $user->useTicketImagen,
                'useTraslado' => $user->useTraslado,
            ];
        
            $request->session()->put('empresa', $empresa_data);
            $request->session()->put('monedaBanca', $monedaBanca_data);
            $request->session()->put('monedaEmpresa', $monedaEmpresa_data);
            $request->session()->put('banca', $banca_data);
            $request->session()->put('permisos', $user_permisos);
           
        }
        
        $request->session()->put('user', $session_data);
       
        }
        return $next($request);
    }
}