<?php

namespace App\Utils;

use App\Services\PosService;
use Carbon\Carbon;

class Util
{
    public static function compararValores($monto, $apuesta)
    {

        if ($apuesta > $monto) {
            $resultado = 1;
        } else {
             $resultado = 0;
        }

        return $resultado;
    }

        /**
     * @param string $fecha_creacion
     */
    static function calcularMinutos($fecha_creacion, $tiempo_anular)
    {
        $created = new Carbon($fecha_creacion);
        $now =  (new Carbon(date('Y-m-d H:i:s')))->tz('America/Santo_Domingo')->format('Y-m-d H:i:s');


        if ($created->diffInMinutes($now) > $tiempo_anular) {
            return 1;
        } else {
            return 0;
        }
    }

        /**
     * estados ticket
     */
    public static function estadosTicket()
    {
        return [
            '1' => 'Normal',
            '2' => 'Premiado',
            '3' => 'Pagado',
            '4' => 'Anulado',

        ];
    }

    public static function movimientosCaja()
    {
        return [
            'entrada' => 'Entrada',
            'salida' => 'Salida',
            'traslado' => 'Traslado',
            'cupo' => 'Apertura de Cupo'
        ];
    }

    /**
     * Retorna Tipo de Iempresora
     */
    public static function tipoImpresora()
    {
        return [
            'printer' => 'Usar impresora de recibos configurada',
            'browser' => 'Impresión basada en navegador'
        ];
    }


}