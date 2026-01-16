<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController as Controller;
use App\Http\Requests\Admin\Promocode\PromocodeRequest;
use App\Models\Promocode;
use App\Repositories\interfaces\PromocodeRepository;
use Exception;

class PromocodeController extends Controller
{
    protected $repo;
    protected $routeName = 'admin.promocodes.';
    protected $viewPath = 'admin.promocodes.';
    protected $roleName = 'Promocode';

    public function __construct(PromocodeRepository $repo)
    {
        $this->middleware('permission:show-promoCodes')->only('index');
        $this->middleware('permission:create-promoCodes')->only('create','store');
        $this->middleware('permission:edit-promoCodes')->only('edit','update');

        $this->repo = $repo;
        parent::__construct($repo, $this->roleName);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // $this->authorize('View ' . $this->roleName);
        

        return view($this->viewPath . 'index', [
            'promocodes' => $this->repo->get(),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        // $this->authorize('Create ' . $this->roleName);
        

        return view($this->viewPath . 'create');
    }

    /**
     * @param PromocodeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PromocodeRequest $request)
    {
        // $this->authorize('Create ' . $this->roleName);
        
        $this->repo->create($request->validated());
        toast(__('Added successfully'), 'success');

        return redirect()->route($this->routeName . 'index');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Promocode $promocode)
    {
        // $this->authorize('Edit ' . $this->roleName);
        

        return view($this->viewPath . 'edit', [
            'promocode' => $promocode,
        ]);
    }

    /**
     * @param AdminRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PromocodeRequest $request, Promocode $promocode)
    {
        // $this->authorize('Edit ' . $this->roleName);
        

        $promocode = $this->repo->update($request->validated(), $promocode->id);

        toast(__('Updated successfully'), 'success');

        return redirect()->route($this->routeName . 'index');
    }
}
