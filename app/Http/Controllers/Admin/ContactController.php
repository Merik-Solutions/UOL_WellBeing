<?php

namespace App\Http\Controllers\Admin;

use Log;
use Mail;
use Exception;
use Carbon\Carbon;
use App\Mail\ReplySent;
use Illuminate\Http\Request;
use Swift_TransportException;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MainController;
use App\Http\Requests\Admin\Admins\AdminRequest;
use App\Repositories\interfaces\ContactRepository;
use App\Http\Requests\Admin\Contact\ContactRequest;
use App\Repositories\interfaces\DistrictRepository;
use App\Repositories\interfaces\SocialSecurityRepository;

class ContactController extends MainController
{
    protected $repo;
    protected $routeName = 'admin.contacts.';
    protected $viewPath = 'admin.contacts.';
    protected $roleName = 'admin.contacts.index';

    public function __construct(ContactRepository $repo)
    {

        //$role = Role::find(3);
      // $role->givePermissionTo('edit-contacts');
       // $role->revokePermissionTo('edit-contacts');

        $this->middleware('permission:show-contacts')->only('index');
        $this->middleware('permission:edit-contacts')->only('edit','update');

        $this->repo = $repo;
        parent::__construct($repo, $this->roleName);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // dd(\Illuminate\Support\Facades\Route::current()->action['as']);
        // dd(permissionCheck('admin.contacts.index'));
       
        // $usePermissions = auth()->user()->getAllPermissions()->pluck('name')->toArray();
        // dd(1111111);
        // if (!auth()->user()->can('admin.contacts.index')){
        //     abort(403);
        // }
        // $admin = Auth::user();
        // $adminRole = $admin->roles->pluck('name')->toArray();
        // dd($adminRole);
        // if (!in_array($this->roleName, auth()->user()->getAllPermissions()->pluck('name')->toArray())) {
        //     abort(403);
        // }
        // if (!Gate::allows("admin.contacts.index")) {
        //     abort(403);
        // }
        // $this->authorize($adminRole[0]);

        $this->repo
            ->where('seen_at', null)
            ->update(['seen_at' => Carbon::now(), 'seen_by' => auth()->id()]);
        $contacts = $this->repo
            ->orderBy('seen_at', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();
        // dd($contacts);
        return view($this->viewPath . 'index', compact('contacts'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {


        $contact = $this->repo->find($id);

        return view($this->viewPath . 'edit', compact('contact'));
    }

    /**
     * @param ContactRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ContactRequest $request, $id)
    {

        $contact = $this->repo->update($request->all(), $id);
        try {
            Mail::to($contact->email)->send(new ReplySent($contact));
            
        } catch (Swift_TransportException $e) {
            Log::error(
                'Error in sending mail \n ' . $e->getMessage(),
                $e->getTrace()
            );
        }
        toast(__('Replied successfully'), 'success');

        return redirect()->route($this->routeName . 'index');
    }
}
