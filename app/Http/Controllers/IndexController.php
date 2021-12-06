<?php

namespace App\Http\Controllers;

use App\Models;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
class IndexController extends Controller {
    /*     * *
     * funcion que retorna las ferias activas que partecen centro ferias
     * @IdFeriasEventos id feria
     */

    public function ferias(Request $request) {
        $IdFeriasEventos = $request->input('IdFeriasEventos');
        $datos = DB::select(DB::raw("SELECT b.IdFeria, b.Nombre, b.Logo, b.Fecha_Inicio, b.Fecha_Fin, b.Estado FROM centro_ferias_eventos a  INNER JOIN ferias b
        ON a.idFeriasEventos = b.IdFeriasEventos
        WHERE b.Estado in ('Activa')
        AND a.IdFeriasEventos = :idferiaEventos "),
                        ['idferiaEventos' => $IdFeriasEventos]);

        return $this->default($datos, []);
        //return  \App\Models\BaseModel::all();
    }





    private function formatoFecha($value) {
        if ($value == null) {
            return "";
        } else {
            $fecha = new \DateTime($value);
            return $fecha->format("Y-m-d h:i A");
        }
    }



}
