<?php

namespace App\Pipelines;

use App\Helpers\Responder;
use Closure;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArrayHandler implements Pipe
{
    public function handle($content, Closure $next)
    {
        if (is_array($content)) {
            $content = collect($content)->transform(function ($item) {
                return (new Responder($item))->getData();
            });
        }
        return $next($content);
    }
}
