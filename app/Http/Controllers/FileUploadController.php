<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class FileUploadController extends Controller
{
    public function cargaArchivos() {
        try {
            $ruta = config('sistema.uploads.path');
            $archivosCargados = [];
            if (request()->hasFile("archivos")) {
                foreach (request()->file("archivos") as $file) {
                    $info  = pathinfo( $file->getClientOriginalName());
                    $nombreArchivo =  $info['filename']  .".".  $info['extension'];
                    $archivo = "$ruta/$nombreArchivo";
                    $archivosCargados[] = "./$archivo";
                    Storage::disk( config('sistema.uploads.storage') )->put($archivo, $file->get() );
                }
            }
            //$file = $request->file($value . "_file");
            //$jsonArchivos = json_encode( $archivosCargados );
            return $this->respuesta(true, "ok", ["archivos" => $archivosCargados]);
        } catch  (\Exception $ex) {
            $this->log( $ex );
            return $this->respuesta(false, "Falla en la carga de archivos");
        }
    }
    
    public function updateCacheFiles() {
        Cache::forget("wordpress_uploads");
        $formatos = implode(["png", "jpg", "jpeg", "gif", "bmp"]);
        $allFiles = Storage::disk("wordpress_uploads")->files();
            $filterFiles = array_filter($allFiles, function ($item) use ($formatos) {
                $tmp = explode('.', $item);
                $extension = end( $tmp );
                return strpos($formatos, $extension ) !== false;
             
            });
           
            $files = array_map(function ($item) {
                return [ "full_path" => \App\Helpers\Wordpress::uploads( $item ), "relative_path" => "./" . config("wordpress.url.uplodas") . "/" . $item, "file" => $item ];
            }, $filterFiles);
            
            
        Cache::put("wordpress_uploads", $files);
        return $this->respuesta(true,"actualizado");
    }
    public function listFiles() {
        
        if (!Cache::has("wordpress_uploads")) {
            $this->updateCache();
        } 
        
        $files = Cache::get("wordpress_uploads");
        
        return $files;
    }
}
