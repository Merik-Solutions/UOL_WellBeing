<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\countries\CountryRequest;
use App\Repositories\interfaces\CountryRepository;
use Spatie\Permission\Models\Role;
class CountryController extends Controller
{
    protected $repo;
    protected $roleName = 'Country';

    public function __construct(CountryRepository $repo)
    {
        $this->middleware('permission:show-countries')->only('index');
        $this->middleware('permission:create-countries')->only('create','store');
        $this->middleware('permission:edit-countries')->only('edit','update');
        $this->middleware('permission:delete-countries')->only('destroy');

        $this->repo = $repo;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.countries.index', [
            'countries' => $this->repo->get(),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
      

        return view('admin.countries.create');
    }

    /**
     * @param CountryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CountryRequest $request)
    {

        $this->repo->create($request->all());
        toast(__('Added successfully'), 'success');

        return redirect()->route('admin.countries.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
       

        $country = $this->repo->find($id);

        return view('admin.countries.edit', compact('country'));
    }

    /**
     * @param CountryRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CountryRequest $request, $id)
    {
     

        $this->repo->update($request->all(), $id);

        toast(__('Updated successfully'), 'success');

        return redirect()->route('admin.countries.index');
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
