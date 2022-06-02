<?php

namespace App\Exports;

use App\Models\Catalogos\Pregunta;
use App\Models\TB\Usuarios;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class RegistroExport implements FromView, ShouldAutoSize
{
    protected $formularios = null;

    public function __construct($_formularios)
    {
        $this->formularios = $_formularios;
    }
    public function view(): View {

        
      /* $preguntas = \App\Models\Catalogos\Pregunta::where('ACTIVO', '=', '1')
       ->whereIn("ID_FORMULARIO", $ids)
       ->orderBy("ID_FORMULARIO")
       ->orderBy('ORDEN');*/

       $ids = explode(",",  $this->formularios); //se genera el arreglo de los ids
       $usuarios =  \App\Models\TB\Usuarios::with([ 'respuestas' => function ($q) use ($ids) {
               /**Se filtran las respuestas según los formularios seleccionados, este filtro es independiente a los usuarios  */       
                $q->whereIn('ID_FORMULARIO', $ids)
                ->orderBy('ID');
        } ]);

        if ( count($ids) == 1) {
             /**
              * En el caso que solo se seleccione un formulario solo se buscaran usuarios cuyas respuestas tenga el formulario seleccionado
              *  */   
            $usuarios = $usuarios->whereHas('respuestas', function ($q) use ($ids) {
                $q->where("ID_FORMULARIO", '=', $ids[0]); 
            } );
        } else {
            //Si selecciona dos formularios, se buscan usuarios donde tengas ambos formularios
            //
            $usuarios->where('FORMULARIOS', '=', $this->formularios) ->get();
        }

       //

       $encabezado = null;
        
       // $dataPreguntas = $preguntas->get();
        $dataUsuarios = $usuarios->get();
        if (count($dataUsuarios) > 0) {
            $encabezado = $dataUsuarios[0];
        }
       //
        
        
        return view('excel.registro', ['encabezado' => $encabezado, 'usuarios' => $dataUsuarios]);
    }
}
