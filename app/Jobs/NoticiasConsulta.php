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

class NoticiasConsulta implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($portal, $palabra)
    {
        //
        $this->portal = $portal;
        $this->palabra = $palabra;
    }

    protected $portal;
    protected $palabra;
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
    private function GetImage($result)
    {
        $pageMap = $result->pagemap ?? null;
        if ($pageMap != null) {
            $metaTags = $pageMap->metatags ?? [];
            if (!empty($metaTags)) {
                $metatag = $metaTags[0];
                if (property_exists($metatag, 'og:image')) {
                    return $metatag->{'og:image'};
                }
            }
        }

        return null;
    }

    public function handle()
    {
        $pattern = "/^([\.]*)[0-9]{1,3}\s(\w+)\sago(\s|)([\.]*)/"; # remover los textos 14 days|hours|weeks ago ....;
        if ($this->palabra != "") {
            $idBuscador = $this->portal['ID_BUSCADOR'];
            $region = $this->portal['REGION'];
            $maximoPaginas = config('noticias.maximoPaginas');
            $restriccionFecha = config('noticias.restriccionFecha');
            $searchApi = new GoogleSearchApi();
            $searchApi->setEngineId($idBuscador);
            $searchApi->setApiKey("AIzaSyD6Zp3ixl-zPFTdvOxRpUyYZSNjnXp00UY");
            $parametros = ['start' => 1, 'num' => $maximoPaginas, 'dateRestrict' => $restriccionFecha];

            $results = $searchApi->getResults($this->palabra, $parametros);

            foreach ($results as $result) {

                $titulo = $result->title;
                $url = $result->link;

                $contenido = preg_replace($pattern, "", $result->snippet);
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
                        $imagen = $this->GetImage($result);
                        Noticias::create(array(
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

            \logger("Region: $region, palabra ". $this->palabra);
        }
    }
}
