<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController as Controller;
use App\Http\Requests\Admin\Setting\SettingRequest;
use App\Models\Admin;
use App\Models\User;
use App\Repositories\interfaces\SettingRepository;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

use function GuzzleHttp\Promise\all;

class SettingController extends Controller
{
    protected $repo;
    protected $routeName = 'admin.settings.';
    protected $viewPath = 'admin.settings.';
    protected $roleName = 'Setting';

    public function __construct(SettingRepository $repo)
    {

         $this->middleware('permission:show-settings')->only('index');
         $this->middleware('permission:edit-settings')->only('edit','update');

         $this->repo = $repo;
         parent::__construct($repo, $this->roleName);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $settings = $this->repo->all();

        return view($this->viewPath . 'index', compact('settings'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {


        $setting = $this->repo->find($id);
        if ($setting->input_type == $setting::INPUT_TEXT) {
            $type = 'text';
        } elseif ($setting->input_type == $setting::INPUT_NUMBER) {
            $type = 'number';
        } else {
            $type = 'textarea';
        }
        return view($this->viewPath . 'edit', compact('setting', 'type'));
    }

    /**
     * @param SettingRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SettingRequest $request, $id)
    {
        // $this->authorize('Edit ' . $this->roleName);
       
        $setting = $this->repo->update($request->all(), $id);

        toast(__('Updated successfully'), 'success');

        return redirect()->route($this->routeName . 'index');
    }
}
