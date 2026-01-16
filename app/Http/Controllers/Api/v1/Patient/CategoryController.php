<?php

namespace App\Http\Controllers\Api\v1\Patient;

use App\Http\Resources\Category\CategoryResource;
use App\Repositories\interfaces\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController
{
    public function index(CategoryRepository $repo)
    {
        $categories = $repo->all();

        return responseJson(
            [
                'categories' => CategoryResource::collection($categories),
            ],
            __('Loaded Successfully'),
        );
    }
}
