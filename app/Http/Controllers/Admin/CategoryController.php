<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\categories\CategoryRequest;
use App\Repositories\interfaces\CategoryRepository;

class CategoryController extends Controller
{
    protected $repo;
    protected $roleName = 'Category';

    public function __construct(CategoryRepository $repo)
    {
        $this->middleware('permission:show-categories')->only('index');
        $this->middleware('permission:create-categories')->only('create','store');
        $this->middleware('permission:edit-categories')->only('edit','update');
        $this->middleware('permission:delete-categories')->only('destroy');

        $this->repo = $repo;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        
        return view('admin.categories.index', [
            'categories' => $this->repo->get(),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
   
        return view('admin.categories.create');
    }

    /**
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request)
    {
      

        $this->repo->create($request->all());
        toast(__('Added successfully'), 'success');

        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // // $this->authorize('View ' . $this->roleName);
        // if(!permissionCheck(\Illuminate\Support\Facades\Route::current()->action['as'])){
        //     abort(403);
        // }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        // // $this->authorize('Edit ' . $this->roleName);
        // if(!permissionCheck(\Illuminate\Support\Facades\Route::current()->action['as'])){
        //     abort(403);
        // }

        $category = $this->repo->find($id);

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * @param CategoryRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryRequest $request, $id)
    {
        

        $this->repo->update($request->all(), $id);

        toast(__('Updated successfully'), 'success');

        return redirect()->route('admin.categories.index');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
     

        $this->repo->delete($id);
        toast(__('Deleted successfully'), 'success');

        return back();
    }
}
