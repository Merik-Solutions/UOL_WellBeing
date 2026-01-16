<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Setting\SettingResource;
use App\Repositories\interfaces\SettingRepository;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __invoke($name, SettingRepository $repo)
    {
        $setting = $repo->findByField('name', "{$name}")->first();
        if ($setting == null) {
            $language = app()->getLocale();
            $setting = $repo
                ->findByField('name', "{$name}_{$language}")
                ->first();
        }
        return responseJson(
            new SettingResource($setting),
            __('Loaded Successfully'),
        );
    }
}
