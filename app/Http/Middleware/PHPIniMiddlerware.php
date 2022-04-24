<?php

namespace App\Http\Middleware;

use Closure;

class PHPIniMiddlerware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        ini_set('upload_max_filesize', '50M');
        ini_set('post_max_size', '40M');

        return $next($request);
    }
}
