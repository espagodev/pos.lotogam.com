<?php

namespace App\Http\Controllers;

use App\Utils\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpresionPosController extends Controller
{
    public function getImpresora()
    {
        $data['empresas_id'] = session()->get('user.emp_id');
        $impresoras = $this->posService->getImpresorasEmpresa($data);       
        $tipoImpresoras = Util::tipoImpresora();
        return view('impresion.modal')->with(['impresoras' => $impresoras, 'tipoImpresoras' => $tipoImpresoras]);

    }

    public function getModificarImpresora(Request $request)
    {
        $data['empresas_id'] = session()->get('user.emp_id');
        $data['bancas_id'] = !empty($request->bancas_id) ? $request->bancas_id : session()->get('user.banca');
        $data['ban_tipo_impresora']  = $request->ban_tipo_impresora;
        $data['impresoras_pos_id']  = $request->impresoras_pos_id;

        $output = $this->posService->getModificarImpresora($data);   
        
        return $output;
       
    }
}
