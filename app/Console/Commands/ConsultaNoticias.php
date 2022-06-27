<?php

namespace App\Console\Commands;

use AlesZatloukal\GoogleSearchApi\GoogleSearchApi;
use App\Jobs\NoticiasConsulta;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class ConsultaNoticias extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consulta:noticia {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consulta de noticias';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $id = $this->argument('id');

        if ( Str::lower($id) == "all" ) {
            $portales =  \App\Models\Catalogos\PortalNoticias::all();
        } else {
            $portales =  \App\Models\Catalogos\PortalNoticias::where('ID', '=', $id)->get();
        }
        $tiempo = 0;
        foreach ($portales as $portal) {
            $palabras_arr = $portal['PALABRAS_CLAVES'];
            # $palabras_arr = explode( ",", $palabras );
    
            if (!empty($palabras_arr)) {        
                foreach ($palabras_arr as $key => $value) {
                    //$key = 0;
                    //$value = $palabras_arr[0];
                    $job = (new NoticiasConsulta( $portal, $value ))->delay( now()->addMinutes($tiempo)  );                
                    dispatch($job);
                    $tiempo += 1; 
                }
            }
        }
        
        $this->info('Comando ejecutado completamente');
    }
}
