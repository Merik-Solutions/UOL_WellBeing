<?php

namespace App\Pipelines;

use Closure;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ResourceHandler implements Pipe
{
    public function handle($content, Closure $next)
    {
        if ($content instanceof ResourceCollection) {
            /** @var Arrayable $content */
            $content = $content->resource;
        }
        return $next($content);
    }
}
