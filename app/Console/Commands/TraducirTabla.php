<?php

namespace App\Console\Commands;

use App\Http\Controllers\TraductorController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class TraducirTabla extends Command
{

    protected  $url;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'traducir:tabla {tabla} {columnas} {idiomaOrigen} {idiomaDestino}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Traductor de tabla';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->url = config('app.url') . "/api/traducir";
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $tabla = $this->argument('tabla');
        $columnas = $this->argument('columnas');
        $idiomaOrigen = $this->argument('idiomaOrigen');
        $idiomaDestino = $this->argument('idiomaDestino');
        $arr = [];
        $query = DB::table($tabla);
        $query->selectRaw(  $columnas )->get()->map(function ($item) use ($idiomaDestino, $idiomaOrigen, $tabla) {

            $i = array_values( (array) $item );
           // $json = $o->ConsumirMetodo(  $i,  $idiomaOrigen, $idiomaDestino );
            $response = Http::acceptJson()->retry(3, 100)->post($this->url, [
                "palabras" => $i,
                "idioma" =>   "$idiomaDestino"
            ]);
            $this->comment($response);
            //$arr[ $tabla ] = json_decode( $json );
        });


      //  Storage::disk('lang')->put("$idiomaDestino/$tabla.json",  json_encode( $arr ) );




        return 0;
    }
}
