<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController as Controller;
use App\Http\Requests\Admin\Package\PackageRequest;
use App\Models\Package;
use App\Models\UserDoctorPackage;
use App\Repositories\interfaces\CategoryRepository;
use App\Repositories\interfaces\PackageRepository;
use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PackageController extends Controller
{
    protected $repo;
    protected $routeName = 'admin.packages.';
    protected $viewPath = 'admin.packages.';
    protected $roleName = 'Package';

    public function __construct(PackageRepository $repo)
    {
        
        $this->middleware('permission:show-packages')->only('index');
        $this->middleware('permission:create-packages')->only('store','create');
        $this->middleware('permission:edit-packages')->only('edit','update');
        $this->repo = $repo;
        parent::__construct($repo, $this->roleName);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view($this->viewPath . 'index', [
            'packages' => $this->repo->get(),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view($this->viewPath . 'create');
    }

    /**
     * @param PackageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PackageRequest $request)
    {       
        $this->repo->create($request->validated());
        toast(__('Added successfully'), 'success');

        return redirect()->route($this->routeName . 'index');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Package $package)
    {
        return view($this->viewPath . 'edit', [
            'package' => $package,
        ]);
    }

    /**
     * @param AdminRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PackageRequest $request, Package $package)
    {
        $package = $this->repo->update($request->validated(), $package->id);

        toast(__('Updated successfully'), 'success');

        return redirect()->route($this->routeName . 'index');
    }

    public function get_package_detail(Request $request){
        $data['package'] = UserDoctorPackage::find($request->package_id);
    
        return view('admin.packages.package_detail',$data);

    }

    public function isPackageActive($id)
    {
        $package = Package::find($id);      
        $package->isActive = !$package->isActive;
        $package->save();
        toast(__('Message package updated successfully'), 'success');
        return back();

    }
}
