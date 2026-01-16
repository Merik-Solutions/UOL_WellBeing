<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
class PermissionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:show-permissions')->only('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        
        
        $permissions_array = DB::select("SELECT distinct substring_index(permissions.name,'-',-1) as name from permissions");

        $permissions = [];

        foreach($permissions_array as $per){
       
            $permissions[$per->name] = Permission::where('name', 'LIKE', '%'.$per->name)->get();
        }

        // foreach($permissions as $parent=>$childs){
        //     foreach($childs as $child){
        //         dd($parent,$child->name);
        //     }
        // }

        return view('admin.permissions.index', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Show form for creating permissions
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!permissionCheck(\Illuminate\Support\Facades\Route::current()->action['as'])){
            abort(403);
        }
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!permissionCheck(\Illuminate\Support\Facades\Route::current()->action['as'])){
            abort(403);
        }
        $request->validate([
            'name' => 'required|unique:users,name'
        ]);

        Permission::create($request->only('name'));

        return redirect()->route('admin.permissions.index')
            ->withSuccess(__('Permission created successfully.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Permission  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        if(!permissionCheck(\Illuminate\Support\Facades\Route::current()->action['as'])){
            abort(403);
        }
        return view('admin.permissions.edit', [
            'permission' => $permission
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        if(!permissionCheck(\Illuminate\Support\Facades\Route::current()->action['as'])){
            abort(403);
        }
        $request->validate([
            'name' => 'required|unique:permissions,name,'.$permission->id
        ]);

        $permission->update($request->only('name'));

        return redirect()->route('admin.permissions.index')
            ->withSuccess(__('Permission updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        if(!permissionCheck(\Illuminate\Support\Facades\Route::current()->action['as'])){
            abort(403);
        }
        $permission->delete();

        return redirect()->route('admin.permissions.index')
            ->withSuccess(__('Permission deleted successfully.'));
    }
}
