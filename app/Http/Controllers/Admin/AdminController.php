<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\interfaces\RoleRepository;
use App\Http\Requests\Admin\Admins\AdminRequest;
use App\Repositories\interfaces\AdminRepository;
use App\Http\Controllers\Admin\MainController as Controller;

class AdminController extends Controller
{
    protected $repo;
    protected $routeName = 'admin.admins.';
    protected $viewPath = 'admin.admins.';
    protected $roleName = 'Admin';

    public function __construct(AdminRepository $repo)
    {

        $this->middleware('permission:show-admins')->only('index');
        $this->middleware('permission:create-admins')->only('store','create');
        $this->middleware('permission:edit-admins')->only('edit','update');
        
        $this->repo = $repo;
        parent::__construct($repo, $this->roleName);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
       
        $admin = $this->repo->find(Auth::user()->id);
        $roles = Role::latest()->get();
        // dd($admin->roles);
        // $this->authorize('View Admin');
        $admins = $this->repo->all();

        return view($this->viewPath . 'index', compact('admins'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
    
        $roles = Role::all();
        $adminRole = Role::pluck('name')->toArray();

        // $this->authorize('Create Admin');

        return view($this->viewPath . 'create', compact('roles','adminRole'));
    }

    /**
     * @param AdminRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AdminRequest $request)
    {
        
        $admin = new Admin;
        $admin->name = $request->name;
        $admin->phone = $request->phone;
        $admin->email = $request->email;
        // dd($admin->password);
        $admin->save();
        if ($request->password){
            $admin->password = bcrypt($request->password);
            $request->user()->fill([
                'password' => Hash::make($request->password)
                ])->update();
            }else{
                unset($request->password);
            }
        if ($request->role){
        $admin = Admin::orderBy('id', 'desc')->first();
        $role = new Role;
        $role->role_id = $request->role;
        $role->model_type = "App\Models\Admin";
        $role->model_id = $admin->id;
        }

        $admin->syncRoles($request->get('role'));
        // $admin = $this->repo->create($request->validated());
        toast(__('Added successfully'), 'success');

        return redirect()->route($this->routeName . 'index');
    }

    /**
     * @param $id
     * @param RoleRepository $roleRepo
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
    
        $admin = $this->repo->find($id);
        $adminRole = $admin->roles->pluck('name')->toArray();
        $roles = Role::latest()->get();
        return view($this->viewPath . 'edit', compact('admin','roles','adminRole'));
    }

    /**
     * @param AdminRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AdminRequest $request, $id)
    {
       
        $data = $request->all();
        $admin = Admin::where('id',$id)->first();
        $admin->name = $request->name;
        $admin->phone = $request->phone;
        $admin->email = $request->email;
        // dd($admin->password);
        $admin->update();
        if ($request->password){
            $admin->password = bcrypt($request->password);
            $request->user()->fill([
                'password' => Hash::make($request->password)
                ])->update();
            }else{
                unset($request->password);
            }
        $admin->update();
        // $admin = $this->repo->update($request->validated(), $id);
        $admin->syncRoles($request->get('role'));

        toast(__('Updated successfully'), 'success');

        return redirect()->route($this->routeName . 'index');
    }
}
