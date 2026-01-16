<?php

namespace App\Http\Controllers\Api\v1\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Resources\Setting\SettingResource;
use App\Repositories\interfaces\SettingRepository;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private $repo;

    public function __construct(SettingRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index($name, Request $request)
    {
        $language = $request->header('Accept-Language');
        $setting = $this->repo
            ->findByField('name', "{$name}_{$language}")
            ->first();

        $setting = new SettingResource($setting);

        return responseJson(compact('setting'), __('Loaded Successfully'));
    }
}
