<?php

namespace App\Utils;

use App\Services\PosService;
use Carbon\Carbon;

class Horario
{
    public static function horaRD()
    {
        return with(new Carbon(date('H:i')))->tz('America/Santo_Domingo')->format('H:i');
    }

     //DIA DE DE LA FECHA SELECCIONADA
     public static function dia()
     {
         return  with(new Carbon(strtotime('N')))->tz('America/Santo_Domingo')->format('N');
     }

     public static function getHorarioLoterias($data)
    {
        $posService = resolve(PosService::class);       
        $data =  $posService->getHorarioLoterias($data);

        return $data;
    }

    public static function getHorarioSuperPale($data)
    {
        $posService = resolve(PosService::class);  
       
        $data =  $posService->getHorarioSuperPale($data);

        return $data;
    }


    static function compararHoras($horaLoteria, $horaRd)
    {
        if (($horaRd >= $horaLoteria) == 'true') {
            return 1;
         } else {
            return 0;
        }
    }

    public static function validarHoracierreLoteria($loterias)
    {
        $horaRd = self::horaRD();

        foreach ($loterias as  $loteria) {
            $valores = explode("|", $loteria);
            $horaCierre = $valores[2];
            if ($horaRd >=  $horaCierre) {
                return true;
            }
        }

       return false;
    }

    /**
     * calcula minutos para pos
     */
    static function calcularMinutosCierre($hora_cierre)
    {
        $created = new Carbon($hora_cierre);
        $now = (new Carbon(date('H:i')))->tz('America/Santo_Domingo')->format('H:i');

        $minutosFaltantes = $created->diffInMinutes($now);
 
        return $minutosFaltantes;

    }
}