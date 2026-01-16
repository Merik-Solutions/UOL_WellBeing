<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminNotification\AdminNotificationRequest;
use App\Models\AdminNotification;
use App\Models\Device;
use App\Repositories\interfaces\AdminNotificationRepository;
use App\Repositories\interfaces\DoctorRepository;
use App\Repositories\interfaces\UserRepository;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class AdminNotificationController extends Controller
{
    protected $repo;
    protected $roleName = 'AdminNotification';

    public function __construct(AdminNotificationRepository $repo)
    {
        $this->middleware('permission:show-notifications')->only('index');
        $this->middleware('permission:create-notifications')->only('create','store');
        // $this->middleware('permission:edit-notifications')->only('edit','update');
        $this->middleware('permission:delete-notifications')->only('destroy');
        $this->repo = $repo;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // $this->authorize('View ' . $this->roleName);        

        return view('admin.admin_notifications.index', [
            'notifications' => $this->repo->get(),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(DoctorRepository $doctors, UserRepository $users)
    {
        // $this->authorize('Create ' . $this->roleName);

        return view('admin.admin_notifications.create', [
            'doctors' => $doctors->get(['id', 'name_en'])->pluck('name_en', 'id'),
            'users' => $users->with('mydata')->get(),
        ]);
    }

    /**
     * @param AdminNotificationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AdminNotificationRequest $request)
    {
        $data = $request->validated();
        if($request->hasFile('file_upload')){
            $image = $request->file('file_upload');
            $fileContents = file_get_contents($image);
            $extension = $image->getClientOriginalExtension();
            if(!File::isDirectory(storage_path('app/public/notifications'))){
                File::makeDirectory(storage_path('app/public/notifications'));
            }
            $file_url = '/notifications/'. rand(1111,99999) .'_'. time() .'.'. $extension;
            File::put(storage_path('app/public') . $file_url, $fileContents);
            $url = Request::root().'/kindahealth/public/storage'.$file_url;
        }
        if($request->video_url){
            $video_url = 'video__'.$request->video_url;
        }   

        $data['file_url'] = $url ?? $video_url ?? null;
        $notification = $this->repo->create($data);
        toast(__('Added successfully'), 'success');

        return redirect()->route('admin.notifications.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $this->authorize('View ' . $this->roleName);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        // $this->authorize('Edit ' . $this->roleName);

        $admin_notification = $this->repo->find($id);

        return view(
            'admin.admin_notifications.edit',
            compact('admin_notification'),
        );
    }

    /**
     * @param AdminNotificationRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AdminNotificationRequest $request, $id)
    {
        // $this->authorize('Edit ' . $this->roleName);

        $this->repo->update($request->all(), $id);

        toast(__('Updated successfully'), 'success');

        return redirect()->route('admin.admin-notifications.index');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // $this->authorize('Delete ' . $this->roleName);

        $this->repo->delete($id);
        toast(__('Deleted successfully'), 'success');

        return back();
    }
}
