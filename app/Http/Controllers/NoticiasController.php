<?php
namespace App\Http\Controllers;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Models;
use AlesZatloukal\GoogleSearchApi\GoogleSearchApi;
use App\Models\TB\Noticias;

class NoticiasController extends Controller {
   public function NoticiasAll() {
       return $this->getRecords( Noticias::class, ['TITULO', 'URL', 'CONTENIDO' ,'IMAGEN', 'FECHA_PUBLICACION'], [], '', request() );
   }

   public function CargarNoticias($id) {
     
     $portales =  Models\Catalogos\PortalNoticias::where('ID', '=', $id)->get();
     $pattern = "/^[0-9]{1,3}\s(\w+)\sago\s...\s/"; # remover los textos 14 days|hours|weeks ago ....;
     
      foreach ($portales as $portal) {

          $palabras = explode(',', $portal['PALABRAS_CLAVES']);
          if (!empty($palabras))
          {
              $idBuscador = $portal['ID_BUSCADOR'];
              $maximoPaginas = config('noticias.maximoPaginas');
              $restriccionFecha = config('noticias.restriccionFecha');
              $searchApi = new GoogleSearchApi();
              $searchApi->setEngineId($idBuscador);
              $searchApi->setApiKey("AIzaSyD6Zp3ixl-zPFTdvOxRpUyYZSNjnXp00UY");
              $parametros = [ 'start' => 1, 'num' => $maximoPaginas , 'dateRestrict' => $restriccionFecha];              
              foreach ($palabras as $palabra) {

                  $results = $searchApi->getResults( $palabra , $parametros );
                  
                   foreach ($results as $result) {
                       
                        $titulo = $result->title;
                        $url = $result->link;
                        
                        $contenido = preg_replace($pattern,"", $result->snippet);
                        if (property_exists( $result, 'cacheId'  )) {
                            $cacheId = $result->cacheId;
                        } else {
                            $cacheId = '0';
                        }
                      
                         
                        if ($this->urlValid( $url )) {
                        $host = $this->extractUrl($url);
                        if ($cacheId == "0") {
                            $consulta = Noticias::whereRaw("0 = 1");
                        } else {
                            $consulta = Noticias::where('CACHEID', '=', $cacheId);
                        }
                        if (!$consulta->orWhere(function ($q) use ($titulo, $host) { 
                            $q->where("TITULO", "=", $titulo)
                                    ->where("URL", "LIKE", "%$host%");
                        })->exists() ){
                            $imagen = $this->GetImage($result);
                            Noticias::create( array(
                                'TITULO' => $titulo,
                                'URL' => $url,
                                'CONTENIDO' => $contenido,
                                "IMAGEN" => $imagen,
                                "CACHEID" => $cacheId,
                                "FECHA_PUBLICACION" => now(),
                                "USUARIO_ADICION" => 'admin'
                            ));
                          }
                        }
                        //if (property_exists($result->pagemap->metatags[0],  ) ) echo var_dump($result->pagemap->metatags[0]->{'og:image'});
                    }
                  
              }
              
          }
     
                 
      }
      
     
       #  AIzaSyD6Zp3ixl-zPFTdvOxRpUyYZSNjnXp00UY 
   }
   private function extractUrl($link) {
       $url = parse_url( $link );
       return $url['host'];
   }
   private function urlValid($url) {
       $headers = get_headers($url);
       return str_contains($headers[0], "200 OK" );
   }
   private function GetImage($result) {
       $pageMap = $result->pagemap ?? null;
       if ($pageMap != null) {
           $metaTags = $pageMap->metatags ?? [];
           if (!empty($metaTags))
           {
               $metatag = $metaTags[0];
               if (property_exists($metatag, 'og:image')) {
                   return $metatag->{'og:image'};
               }
           }
           
       }
       
       return null;
   }
   
}