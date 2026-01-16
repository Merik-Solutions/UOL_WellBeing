<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:show-roles')->only('index','show');
        $this->middleware('permission:create-roles')->only('store','create');
        $this->middleware('permission:edit-roles')->only('edit','update');
        $this->middleware('permission:delete-roles')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        $roles = Role::orderBy('id','DESC')->paginate(5);
        return view('admin.roles.index',compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd('asxas');
        $permissions_array = DB::select("SELECT distinct substring_index(permissions.name,'-',-1) as name from permissions");

        $permissions = [];

        foreach($permissions_array as $per){
       
            $permissions[$per->name] = Permission::where('name', 'LIKE', '%'.$per->name)->get();
        }
     
        // $permissions = Permission::get();
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = Role::create(['name' => $request->get('name')]);
        $role->syncPermissions($request->get('permission'));

        return redirect()->route('admin.roles.index')->with('success','Role created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $permissions_array = [];

        $permissions = [];

        $role = $role;
        $permissions_array_unfiltered = $role->permissions->pluck('name')->toArray();
        foreach($permissions_array_unfiltered as $per){
            if(!in_array(explode('-',$per)[1],$permissions_array)){
                array_push($permissions_array,explode('-',$per)[1]);
            }
        }

     
        foreach($permissions_array as $per){
       
            
            $permissions[$per] = Permission::where('name', 'LIKE', '%'.$per)->get();
        }

     
    

        return view('admin.roles.show', compact('role', 'permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
      
        $role = $role;
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        // $permissions = Permission::get();

        $permissions_array = DB::select("SELECT distinct substring_index(permissions.name,'-',-1) as name from permissions");

        $permissions = [];

        foreach($permissions_array as $per){
       
            $permissions[$per->name] = Permission::where('name', 'LIKE', '%'.$per->name)->get();
        }


        return view('admin.roles.edit', compact('role', 'rolePermissions', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Role $role, Request $request)
    {
       
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role->update($request->only('name'));

        $role->syncPermissions($request->get('permission'));

        return redirect()->route('admin.roles.index')
                        ->with('success','Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
       
        $role->delete();

        return redirect()->route('admin.roles.index')
                        ->with('success','Role deleted successfully');
    }
}
