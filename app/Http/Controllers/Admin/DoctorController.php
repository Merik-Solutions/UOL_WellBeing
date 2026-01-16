<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController as Controller;
use App\Http\Requests\Admin\Doctor\DoctorRequest;
use App\Models\BankAccount;
use App\Traits\HasBankAccount;
use App\Models\Doctor;
use App\Models\Rating;
use App\Models\Reservation;
use App\Models\Schedule;
use App\Models\UserDoctorPackage;
use App\Repositories\interfaces\CategoryRepository;
use App\Repositories\interfaces\CountryRepository;
use App\Repositories\interfaces\DoctorRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DoctorController extends Controller
{
    protected $repo;
    protected $routeName = 'admin.doctors.';
    protected $viewPath = 'admin.doctors.';
    protected $roleName = 'Doctor';

    public function __construct(DoctorRepository $repo)
    {
        $this->middleware('permission:show-doctors')->only('index');
        $this->middleware('permission:create-doctors')->only('create','store');
        $this->middleware('permission:edit-doctors')->only('edit','update');
        $this->repo = $repo;
        parent::__construct($repo, $this->roleName);
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
        $query['bank_account'] = Doctor::with('banks')->get();
        // $query['bank_account'] = $this->repo->bank_account()->first();
        return view($this->viewPath . 'index', [
            'active_doctors' => $this->repo->isActive()->get(),
            'pending_doctors' => $this->repo->isPending()->get(),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(CategoryRepository $categoryRepository, CountryRepository $countryRepository)
    {
        // $this->authorize('Create ' . $this->roleName);
       

        return view($this->viewPath . 'create', [
            'categories' => $categoryRepository->get()->pluck('name', 'id'),
            'countries' => $countryRepository->get(),
        ]);
    }

    /**
     * @param AdminRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DoctorRequest $request)
    {
        $request->validate([
            'bank_account' => ['required', 'array'],
            'bank_account.title' => ['required', 'string'],
            'bank_account.bank_name' => ['required', 'string'],
            'bank_account.iban' => ['required'],
        ],$this->ValidateMessage());
        // $this->authorize('Create ' . $this->roleName);
        $inputs = $request->validated();
        $inputs['confirmed_at'] = now();
        $request['phone'] = str_replace(' ','',$request->phone);

        $doctor  = $this->repo->create($request->all());
        if (
            $request->has('bank_account') &&
            is_array($request->input('bank_account'))
        ) {
            $doctor->bank_account()->create([
                'title' => $request->bank_account['title'],
                'bank_name' => $request->bank_account['bank_name'],
                'iban' => $request->bank_account['iban'],
                'data' =>[
                    "account_holder_name"=>$doctor->name_en,
                    "bank_name"=> $request->bank_account['bank_name'],
                    "account_iban"=>$request->bank_account['iban'],
                    "account_number"=>null,
                    "bank_swift"=>null,
                    "address"=>null,
                    "bank_phone_number"=>null,
                    "country"=>null,
                    "city"=>null,
                    "postal_code"=>null,            

                ],
            ]);
            $doctor->load('bank_account');
        }
        toast(__('Added successfully'), 'success');

        return redirect()->route($this->routeName . 'index');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Doctor $doctor, CategoryRepository $categoryRepository,CountryRepository $countryRepository)
    {
        // $this->authorize('Edit ' . $this->roleName);
        

        return view($this->viewPath . 'edit', [
            'doctor' => $doctor,
            'categories' => $categoryRepository->get()->pluck('name', 'id'),
            'countries' => $countryRepository->get(),
        ]);
    }

    /**
     * @param AdminRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(DoctorRequest $request, Doctor $doctor)
    {
        $request->validate([
            'bank_account' => ['required', 'array'],
            'bank_account.title' => ['required', 'string'],
            'bank_account.bank_name' => ['required', 'string'],
            'bank_account.iban' => ['required'],
        ],$this->ValidateMessage());
        // $this->authorize('Edit ' . $this->roleName);
        $request['phone'] = str_replace(' ','',$request->phone);
        $doctor  = $this->repo->update($request->all(),$request->id);

        if (
            $request->has('bank_account') &&
            is_array($request->input('bank_account'))
        ) {
            $doctor->bank_account()->updateOrCreate([
                'title' => $request->bank_account['title'],
                'bank_name' => $request->bank_account['bank_name'],
                'iban' => $request->bank_account['iban'],
                'data' =>[
                    "account_holder_name"=>$doctor->name_en,
                    "bank_name"=> $request->bank_account['bank_name'],
                    "account_iban"=>$request->bank_account['iban'],
                    "account_number"=>null,
                    "bank_swift"=>null,
                    "address"=>null,
                    "bank_phone_number"=>null,
                    "country"=>null,
                    "city"=>null,
                    "postal_code"=>null,            

                ],
            ]);
            $doctor->load('bank_account');
        }

        toast(__('Updated successfully'), 'success');

        return redirect()->route($this->routeName . 'index');
    }

    public function blockDoctor($id)
    {
        $doctor = Doctor::find($id); 
        // $this->authorize('Edit ' . $this->roleName);
        

        $doctor->toggleStatus();
        return back();
    }


    public function doctor_profile($id){

        $data['reservations'] = Reservation::where('doctor_id',$id)->with('patient')->orderBy('created_at','ASC')->get();
        $data['doctor'] = Doctor::with('ratings')->find($id);
        $data['packages'] = UserDoctorPackage::where('doctor_id',$id)->orderBy('created_at','ASC')->get();
        $data['schedule'] = Schedule::where('doctor_id',$id)->orderBy('day','ASC')->get();
        $data['ratings'] = Rating::where('doctor_id',$id)->get();
        return view ('admin.doctors.profile',$data);

    }

    public function isMessagePackage($id)
    {
        $doctor = Doctor::find($id);      
        $doctor->isPackageActive = !$doctor->isPackageActive;
        $doctor->save();
        toast(__('Message package updated successfully'), 'success');
        return back();
    }

    public function ValidateMessage()
    {
        return [
            'bank_account.required' => 'The bank account information is required.',
            'bank_account.array' => 'The bank account must be an array.',
            'bank_account.title.required' => 'The account name is required.',
            'bank_account.title.string' => 'The title must be a string.',
            'bank_account.bank_name.required' => 'The bank name is required.',
            'bank_account.bank_name.string' => 'The bank name must be a string.',
            'bank_account.iban.required' => 'The IBAN is required.',
        ];
    }
}
