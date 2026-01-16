<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController as Controller;
use App\Http\Requests\Admin\User\UserRequest;
use App\Models\User;
use App\Repositories\interfaces\DistrictRepository;
use App\Repositories\interfaces\UserRepository;
use App\Repositories\interfaces\SocialSecurityRepository;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class UserController extends Controller
{
    protected $repo;
    protected $routeName = 'admin.users.';
    protected $viewPath = 'admin.users.';
    protected $roleName = 'User';

    public function __construct(UserRepository $repo)
    {
        $this->middleware('permission:show-users')->only('index');
        $this->middleware('permission:create-users')->only('create','store');
        $this->middleware('permission:edit-users')->only('edit','update');

        $this->repo = $repo;
        parent::__construct($repo, $this->roleName);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        return view($this->viewPath . 'index', [
            'users' => $this->repo->with(['mydata','patients'])->get(),
        ]);
    }

    /**
     * @param SocialSecurityRepository $securityRepo
     * @param DistrictRepository $districtRepo
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
       
        return view($this->viewPath . 'create');
    }

    /**
     * @param AdminRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        

        $this->repo->create($request->validated());
        toast(__('Added successfully'), 'success');

        return redirect()->route($this->routeName . 'index');
    }

    /**
     * @param $id
     * @param SocialSecurityRepository $securityRepo
     * @param DistrictRepository $districtRepo
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
    
        return view($this->viewPath . 'edit', [
            'user' => $this->repo->find($id),
        ]);
    }

    /**
     * @param AdminRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User $user)
    {
        
        $user = $this->repo->update($request->validated(), $user->id);

        toast(__('Updated successfully'), 'success');

        return redirect()->route($this->routeName . 'index');
    }
}
