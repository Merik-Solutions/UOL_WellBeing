<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController as Controller;
use App\Http\Requests\Admin\Roles\RoleRequest;
use App\Repositories\interfaces\DistrictRepository;
use App\Repositories\interfaces\PermissionRepository;
use App\Repositories\interfaces\RoleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    protected $repo;
    protected $permissionRepo;
    protected $routeName = 'admin.roles.';
    protected $viewPath = 'admin.roles.';
    protected $roleName = 'Role';

    /**
     * RoleController constructor.
     * @param RoleRepository $repo
     * @param PermissionRepository $permissionRepo
     */
    public function __construct(
        RoleRepository $repo,
        PermissionRepository $permissionRepo,
    ) {
        parent::__construct($repo, $this->roleName);

        $this->repo = $repo;
        $this->permissionRepo = $permissionRepo;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        // $this->authorize('View ' . $this->roleName);
        if(!permissionCheck(\Illuminate\Support\Facades\Route::current()->action['as'])){
            abort(403);
        }

        $roles = $this->repo->all();

        return view($this->viewPath . 'index', compact('roles'));
    }

    /**
     * @param DistrictRepository $districtRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        // $this->authorize('Create ' . $this->roleName);
        if(!permissionCheck(\Illuminate\Support\Facades\Route::current()->action['as'])){
            abort(403);
        }

        $permissions_groups = $this->permissionRepo
            ->findWhereNotIn('group_name', ['Districts', 'Areas', 'Blocks'])
            ->groupBy('group_name');
        return view($this->viewPath . 'create', compact('permissions_groups'));
    }

    /**
     * @param RoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RoleRequest $request)
    {
        // $this->authorize('Create ' . $this->roleName);
        if(!permissionCheck(\Illuminate\Support\Facades\Route::current()->action['as'])){
            abort(403);
        }

        DB::beginTransaction();
        $role = $this->repo->create(
            $request->except('permissions', '_token', '_method'),
        );
        $permissions = $role->syncPermissions($request->permissions);
        DB::commit();

        toast(__('Added successfully'), 'success');

        return redirect()->route($this->routeName . 'index');
    }

    /**
     * @param $id
     * @param DistrictRepository $districtRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, DistrictRepository $districtRepository)
    {
        // $this->authorize('Edit ' . $this->roleName);
        if(!permissionCheck(\Illuminate\Support\Facades\Route::current()->action['as'])){
            abort(403);
        }

        $role = $this->repo->find($id);
        $role_permissions = $role->permissions->pluck('id')->toArray();
        $permissions_groups = $this->permissionRepo
            ->findWhereNotIn('group_name', ['Districts', 'Areas', 'Blocks'])
            ->groupBy('group_name');

        return view(
            $this->viewPath . 'edit',
            compact('role', 'permissions_groups', 'role_permissions'),
        );
    }

    /**
     * @param RoleRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RoleRequest $request, $id)
    {
        // $this->authorize('Edit ' . $this->roleName);
        if(!permissionCheck(\Illuminate\Support\Facades\Route::current()->action['as'])){
            abort(403);
        }

        DB::beginTransaction();
        $role = $this->repo->update(
            $request->except('permissions', '_token', '_method'),
            $id,
        );
        $permissions = $role->syncPermissions($request->permissions);
        DB::commit();

        toast(__('Updated successfully'), 'success');

        return redirect()->route($this->routeName . 'index');
    }
}
