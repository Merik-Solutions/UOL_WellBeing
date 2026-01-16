<?php

namespace App\Http\Controllers\Admin;

use App\Criteria\OfPatientCriteria;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admins\AdminRequest;
use App\Http\Requests\Admin\Patient\PatientRequest;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Reservation;
use App\Models\User;
use App\Models\UserDoctorPackage;
use App\Repositories\interfaces\DoctorRepository;
use App\Repositories\interfaces\PatientRepository;
use DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PatientController extends Controller
{
    protected $roleName = 'patient';

    public function __construct(public PatientRepository $repo)
    {
        $this->middleware('permission:show-patients')->only('index');
        $this->middleware('permission:create-patients')->only('create','store');
        $this->middleware('permission:delete-patients')->only('destroy');

        $this->repo = $repo;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($user)
    {
             return view('admin.patients.index', [
            'patients' => $this->repo->where('user_id', $user)->get(),
        ]);
    }

    /**
     * @param DoctorRepository $doctorRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(int $user)
    {
       

        return view('admin.patients.create', [
            'patients' => $this->repo->get(),
        ]);
    }

    /**
     * @param PatientRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(User $user, PatientRequest $request)
    {
        

        $user->patients()->create($request->all());

        toast(__('Added successfully'), 'success');

        return redirect()->route('admin.users.patients.index', $user->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        
    }

    /**
     * @param $id
     * @param DoctorRepository $doctorRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Patient $patient)
    {
        

        return view('admin.patients.edit', compact('patient'));
    }

    /**
     * @param AdminRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update( PatientRequest $request, Patient $patient) {
        

        $this->repo->update($request->all(), $patient->id);

        toast(__('Updated successfully'), 'success');

        return redirect()->route(
            'admin.users.patients.index',
            $patient->user_id,
        );
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Patient $patient)
    {
        

        $this->repo->delete($patient->id);
        toast(__('Deleted successfully'), 'success');

        return back();
    }


    public function patient_profile($id){
        $data['patient'] = Patient::where('user_id',$id)->with('user')->first();
        $data['packages'] = UserDoctorPackage::where('user_id',$id)->orderBy('created_at','ASC')->get();
        $data['reservations'] = Reservation::where('user_id',$id)->with('doctor')->get();

        return view('admin.patients.profile',$data);

    }
}
