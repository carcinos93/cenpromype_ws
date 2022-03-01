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

   public function CargarNoticias() {
       
     $portales =  Models\Catalogos\PortalNoticias::all();
     $pattern = "/^[0-9]{1,3}\s(\w+)\sago\s...\s/"; # remover los textos 14 days|hours|weeks ago ....;
      
      foreach ($portales as $portal) {

          $palabras = explode(',', $portal['PALABRAS_CLAVES']);
          if (!empty($palabras))
          {
              $idBuscador = $portal['ID_BUSCADOR'];
              
              $searchApi = new GoogleSearchApi();
              $searchApi->setEngineId($idBuscador);
              $searchApi->setApiKey("AIzaSyD6Zp3ixl-zPFTdvOxRpUyYZSNjnXp00UY");
              $parametros = [ 'start' => 1, 'num' => 10 , 'dateRestrict' => 'd7'];              
              foreach ($palabras as $palabra) {

                  $results = $searchApi->getResults( $palabra , $parametros );
                  
                   foreach ($results as $result) {
                        $titulo = $result->title;
                        $url = $result->link;
                        
                        $contenido = preg_replace($pattern,"", $result->snippet);
                        $cacheId = $result->cacheId;
               
                       
                        if (! Noticias::where('CACHEID', '=', $cacheId)->exists() ){
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
                        //if (property_exists($result->pagemap->metatags[0],  ) ) echo var_dump($result->pagemap->metatags[0]->{'og:image'});
                    }
                  
              }
              
          }
     
                 
      }
      
     
       #  AIzaSyD6Zp3ixl-zPFTdvOxRpUyYZSNjnXp00UY 
   }
   private function GetImage($result) {
       $pageMap = $result->pagemap;
       if ($pageMap != null) {
           $metaTags = $pageMap->metatags;
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