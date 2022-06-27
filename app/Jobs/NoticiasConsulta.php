<?php

namespace App\Jobs;

use AlesZatloukal\GoogleSearchApi\GoogleSearchApi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\TB\Noticias;
use App\Models\Catalogos\PortalNoticias;
use DateTime;

class NoticiasConsulta implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($portal, $termino)
    {
        //
        $this->portal = $portal;
        $this->termino = $termino;
    }

    protected $portal;
    protected $termino;
    /**
     * Execute the job.
     *
     * @return void
     */

    private function extractUrl($link)
    {
        $url = parse_url($link);
        return $url['host'];
    }
    private function urlValid($url)
    {
        $headers = get_headers($url);
        return str_contains($headers[0], "200 OK");
    }
    private function GetMeta($result, $key , $default)
    {
        $data = $default;
        $pageMap = $result->pagemap ?? null;
        if ($pageMap != null) {
            $metaTags = $pageMap->metatags ?? [];
            if (!empty($metaTags)) {
                $metatag = $metaTags[0];
                if (property_exists($metatag, $key)) {
                    $data = $metatag->{$key};
                }
            }
        }

        return $data;
    }

    public function handle()
    {
        $patterns = ["/^([\.]*)[0-9]{1,3}\s(\w+)\sago(\s|)([\.]*)/", "/^([a-zA-ZáéíóúÁÉÍÓÚ0-9\s]*)[\.]{1,3}/"]; # remover los textos 14 days|hours|weeks ago ....;
        if ($this->termino != null) {
            $idBuscador = $this->portal['ID_BUSCADOR'];
            $region = $this->portal['REGION'];
            $maximoPaginas = config('noticias.maximoPaginas');
            $restriccionFecha = config('noticias.restriccionFecha');
            
            $searchApi = new GoogleSearchApi();
            $searchApi->setEngineId($idBuscador);
            $searchApi->setApiKey("AIzaSyD6Zp3ixl-zPFTdvOxRpUyYZSNjnXp00UY");
            $parametros = array('start' => 1, 'num' => $maximoPaginas, 'dateRestrict' => $restriccionFecha, 
                                'siteSearch' => 'sitioweb',
                                'siteSearchFilter' => 'i');
            if (!empty( $this->termino['adicionalTerminos'] )) {
                $parametros['orTerms'] = implode(" ", $this->termino['adicionalTerminos']);
            }
            
            $palabras = implode(" ", $this->termino['termino']);
            $results = $searchApi->getResults($palabras, $parametros);

            foreach ($results as $result) {

                $titulo = $result->title;
                $url = $result->link;
                $contenido = $result->snippet;
                foreach ($patterns as $pattern) {
                    $contenido = preg_replace($pattern, "", $contenido );
                }
   
                $cacheId = $result->cacheId ?? "0";
               

                if ($this->urlValid($url)) {
                    $host = $this->extractUrl($url);
                    if ($cacheId == "0") {
                        $consulta = Noticias::whereRaw("0 = 1");
                    } else {
                        $consulta = Noticias::where('CACHEID', '=', $cacheId);
                    }
                    if (!$consulta->orWhere(function ($q) use ($titulo, $host) {
                        $q->where("TITULO", "=", $titulo)
                        ->where("URL", "LIKE", "%$host%");
                    })->exists()) {
                        $ahora =  (new DateTime("now"))->format("Y-m-d");
                        $imagen = $this->GetMeta($result, 'og:image', null );
                        $fecha = date("Y-m-d", strtotime($this->GetMeta($result, 'article:published_time', $ahora ))); 
                        Noticias::create(array(
                            'TITULO' => $titulo,
                            'URL' => $url,
                            'CONTENIDO' => $contenido,
                            "IMAGEN" => $imagen,
                            "CACHEID" => $cacheId,
                            "FECHA_PUBLICACION" => $fecha,
                            "USUARIO_ADICION" => 'admin'
                        ));
                    }
                }
       
                //if (property_exists($result->pagemap->metatags[0],  ) ) echo var_dump($result->pagemap->metatags[0]->{'og:image'});
            }

            // \logger("Region: $region, palabra ". $this->palabra);
        }
    }
}
