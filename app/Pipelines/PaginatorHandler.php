<?php

namespace App\Pipelines;

use App\Pipelines\Pipe;
use Closure;
use Illuminate\Contracts\Pagination\Paginator;

class PaginatorHandler implements Pipe
{
    public function handle($content, Closure $next)
    {
        if ($content instanceof Paginator) {
            /** @var Arrayable $content */
            $pagination = $content->toArray();
            $data = $pagination['data'];
            unset($pagination['data']);
            $content = ['data' => $data, 'pagination' => $pagination];
        }
        return $next($content);
    }
}
