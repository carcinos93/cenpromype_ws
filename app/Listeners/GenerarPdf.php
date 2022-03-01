<?php

namespace App\Listeners;

use App\Events\DocumentoSaved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use PDF;
class GenerarPdf implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  DocumentoSaved  $event
     * @return void
     */
    public function handle(DocumentoSaved $event)
    {
       $id = $event->id; 
       $url = route('vista.documento', [ 'iddocumento' => $id ] );
       //$uuid =  Illuminate\Support\Str::uuid();
       $archivo = "documento_$id.pdf";
       try {   
        /*$documento = \App\Models\TB\Documento::find( $id );
        $content =PDF::loadView('documento.documento', [ 'documento' => $documento ])->stream();
        \Illuminate\Support\Facades\Storage::disk('wordpress_uploads')->put($archivo, $content);*/
           
           
        $wkhtmltopdf = base_path() .'\exec\wkhtmltopdf.exe';
        $documentos_folder =  config('filesystems.disks.wordpress_uploads.root') . "/pdf";
        \Illuminate\Support\Facades\File::ensureDirectoryExists($documentos_folder);
        $process = new \Symfony\Component\Process\Process([$wkhtmltopdf, $url, $archivo  ],  base_path() . "\\" .   str_replace("/", "\\", $documentos_folder)  );
        $process->setTimeout(180);
        $process->enableOutput();
        $process->run();       
        do {
            if ($process->isTerminated())
            {
               //$result = $process->getErrorOutput();
               break;
            }
        } while ($process->isRunning());
           
        } catch (\Exception $exc) {
            logger($exc->getMessage());
           //$this->log($exc);
        }
       
    }
}
