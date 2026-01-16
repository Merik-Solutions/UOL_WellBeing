<?php

namespace App\Http\Controllers\Admin;

use App\Criteria\OfDoctorCriteria;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admins\AdminRequest;
use App\Http\Requests\Admin\Schedules\ScheduleRequest;
use App\Models\Doctor;
use App\Repositories\interfaces\DoctorRepository;
use App\Repositories\interfaces\ScheduleRepository;
use DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ScheduleController extends Controller
{
    protected $repo;
    protected $roleName = 'Schedule';

    public function __construct(ScheduleRepository $repo)
    {
    
        $this->middleware('permission:show-schedules')->only('index');
        $this->middleware('permission:create-schedules')->only('store','create');


        $this->repo = $repo->pushCriteria(
            new OfDoctorCriteria(request()->doctor),
        );
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {


        // $role = Role::find(3);
        // $role->givePermissionTo(Permission::all());
        // $this->authorize('View ' . $this->roleName);
        // if(!permissionCheck(\Illuminate\Support\Facades\Route::current()->action['as'])){
        //     abort(403);
        // }

        return view('admin.schedules.index', [
            'schedules' => $this->repo->get(),
        ]);
    }

    /**
     * @param DoctorRepository $doctorRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Doctor $doctor, DoctorRepository $doctorRepository)
    {
      

        return view('admin.schedules.create', [
            'schedules' => $doctorRepository->getSchedule($doctor),
        ]);
    }

    /**
     * @param ScheduleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($doctor, ScheduleRequest $request)
    {
       
        DB::beginTransaction();
        foreach ($request->validated()['schedule'] as $day) {
            $a = $this->repo->updateOrCreate(
                [
                    'doctor_id' => $doctor,
                    'day' => $day['day'],
                ],
                $day,
            );
        }
        DB::commit();
        toast(__('Added successfully'), 'success');

        return redirect()->route('admin.schedules.index', $doctor);
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
     * @param DoctorRepository $doctorRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, DoctorRepository $doctorRepository)
    {
       

        $schedule = $this->repo->find($id);
        $doctors = $doctorRepository->all()->pluck('name', 'id');
        return view('admin.schedules.edit', compact('schedule', 'doctors'));
    }

    /**
     * @param AdminRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ScheduleRequest $request, $id)
    {
        // $this->authorize('Edit ' . $this->roleName);
        if(!permissionCheck(\Illuminate\Support\Facades\Route::current()->action['as'])){
            abort(403);
        }

        $schedule = $this->repo->update($request->all(), $id);

        toast(__('Updated successfully'), 'success');

        return redirect()->route('admin.schedules.index');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // $this->authorize('Delete ' . $this->roleName);
        if(!permissionCheck(\Illuminate\Support\Facades\Route::current()->action['as'])){
            abort(403);
        }

        $this->repo->delete($id);
        toast(__('Deleted successfully'), 'success');

        return back();
    }
}
