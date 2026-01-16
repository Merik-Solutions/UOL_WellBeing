<?php

namespace App\Http\Controllers\Api\v1\Doctor;

use App\Helpers\Responder;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Doctor\DoctorRequest;
use App\Http\Resources\Doctor\DoctorResource;
use App\Models\Doctor;
use App\Models\VerficationCode;
use App\Repositories\interfaces\DoctorRepository;
use App\Rules\PhoneNumber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public $repo;

    public function __construct(DoctorRepository $repo)
    {
        $this->middleware('auth:doctor_api', [
            'except' => [
                'login',
                'register',
                'verify',
                'resendVerification',
                'sendResetPassCode',
                'resetPassword',
                'socialLogin',
                'sendSMS',
            ],
        ]);
        auth()->setDefaultDriver('doctor_api');

        $this->repo = $repo;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(DoctorRequest $request)
    {
        $doctor = $this->repo->updateOrCreate(
            $request->only('phone'),
            $request->all(),
        );

        $response = new DoctorResource($doctor);
        return responseJson($response, __('Added Successfully'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name_ar' => ['nullable', 'string'],
            'name_en' => ['nullable', 'string'],
            'email' => [
                'nullable','email:rfc,dns,spoof',
                'unique:doctors,email,' . auth()->id(),
            ],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'national_id' => ['nullable', 'integer'],
            'birthdate' => ['nullable', 'date', 'date_format:Y-m-d'],
            'gender' => ['nullable', 'integer', 'in:0,1'],
            'image' => ['nullable', 'image'],
            'heal_cases' => ['nullable', 'array'],
            'heal_cases.*' => ['string'],
            'period' => ['nullable', 'integer'],            
            'price' => ['nullable', 'numeric'],
            'title_ar' => ['nullable', 'string', 'max:191'],
            'title_en' => ['nullable', 'string', 'max:191'],
            'description_ar' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'bank_account' => ['required', 'array'],
            'bank_account.title' => ['required', 'string'],
            'bank_account.bank_name' => ['required', 'string'],
            'bank_account.iban' => ['required', 'string'],
            'bank_account.data' => ['nullable', 'array'],
        ]);

        /** @var Doctor $doctor */
        $doctor = $this->repo->update($request->all(), auth()->id());
        if (
            $request->has('bank_account') &&
            is_array($request->input('bank_account'))
        ) {
            $doctor->bank_account()->create($request->input('bank_account'));
            $doctor->load('bank_account');
        }
        $response = (new DoctorResource($doctor))->jsonSerialize();
        return responseJson($response, __('Added Successfully'));
    }

    public function updateBusiness(Request $request): Responder
    {
        $validated = $request->validate([
            'company_name' => ['nullable', 'string'],
            'company_license' => ['nullable', 'string'],
            'license_number' => ['nullable', 'string'],
        ]);

        /** @var Doctor $doctor */
        $doctor = $this->repo->update($validated, auth()->id());

        $response = (new DoctorResource($doctor))->jsonSerialize();
        return responseJson($response, __('Added Successfully'));
    }

    /**
     * @param Request $request
     * @return Responder
     * @throws \Illuminate\Validation\ValidationException
     */
    public function profile(Request $request): Responder
    {
        return responseJson(new DoctorResource(auth()->user(),true));
    }

    /**
     * Log the Doctor out (Invalidate the token).
     *
     * @return Responder
     */
    public function logout(): Responder
    {
        auth()->logout();

        return responseJson(null, __('Successfully logged out'));
    }

    /**
     * send verification code to doctor
     * @param Request $request
     * @return Responder
     */
    public function sendSMS(Request $request): Responder
    {
        $request->validate([
            'phone' => [
                'required',
                'string',
                'phone:AE,EG,SA,BH',
                // 'regex:/^([0-9+])+$/',
                // 'regex:/^[+]/',
                new PhoneNumber
            ],
            'country_id' => ['nullable', 'integer', 'exists:countries,id'],
        ]);

        $doctor = $this->repo->firstOrCreate($request->only('phone'));
        $doctor->sendCode($request->only('phone'));
        return responseJson(
            ['code' => $doctor->verification_code],
            __('Code Send Successfully'),
        );
    }

    /**
     * @param Request $request
     * @return Responder
     * @throws \Illuminate\Validation\ValidationException
     */
    public function verify(Request $request): Responder
    {
        $this->validate($request, [
            'code' => [
                'required',
                'integer',
                Rule::exists('verfication_codes', 'code')->where(
                    'verifiable_type',
                    $this->repo->model(),
                ),
            ],
            'token' => ['required', 'string'],
        ]);

        $doctor = $this->repo->isActive()->verify($request->code);
        VerficationCode::where('code', $request->code)->delete();

        if (is_null($doctor)) {
            return responseJson(null, __('Your account has been temporally deactivated.'), 401);
        }
        $this->repo->AddFCM($doctor, $request->token, $request->platform,$request->voip);
        $doctor->load('bank_account');
        return responseJson(
            (new DoctorResource($doctor))->jsonSerialize() + [
                'token' => auth()->login($doctor),
            ],
            __('Verified Successfully'),
        );
    }
    public function updateFCM(Request $request): Responder
    {
        $this->validate($request, [           
            'doctor_id' => ['required'],
            'token' => ['required', 'string'],
        ]);

        $doctor = $this->repo->isActive()->find($request->doctor_id);

        if (is_null($doctor)) {
            return responseJson(null, __('Your account has been temporally deactivated.'), 401);
        }
        $this->repo->AddFCM($doctor, $request->token, $request->platform,$request->voip);
        return responseJson(__('FCM updated.'),
        );
    }

    /**
     * send verification code to doctor
     * @param Request $request
     * @return Responder
     */
    public function updatePhone(Request $request): Responder
    {
        $data = $request->validate([
            'new_phone' => [
                'required',
                'string',
                'unique:doctors,phone',
                'phone:AE,EG,SA,BH',
                'regex:/^([0-9+])+$/',
                'regex:/^[+]/',
            ],
        ]);

        /** @var  Doctor $user */
        $user = $this->repo->update($data, auth()->id());
        $user->fill(['phone' => $request->new_phone]);
        $user->sendCode();

        return responseJson(
            ['code' => $user->verification_code],
            __('Code Send Successfully'),
        );
    }

    /**
     * @param Request $request
     * @return Responder
     * @throws \Illuminate\Validation\ValidationException
     */
    public function verifyNewPhone(Request $request)
    {
        $this->validate($request, [
            'code' => [
                'required',
                'integer',
                Rule::exists('verfication_codes', 'code')->where(
                    'verifiable_type',
                    $this->repo->model(),
                ),
            ],
        ]);

        $user = $this->repo->verify($request->code);
        if (is_null($user)) {
            return responseJson(null, __('Wrong Code'), 401);
        }

        $user->update(['phone' => $user->new_phone]);
        $user = $user->refresh();
        $user->load('bank_account');
        return responseJson(
            (new DoctorResource($user->refresh()))->jsonSerialize() + [
                'token' => auth()->login($user),
            ],
            __('Verified Successfully'),
        );
    }

    public function updateLocale(Request $request): Responder
    {
        $request->user()->update(['locale' => $request->input('locale')]);
        $user = $request->user()->refresh();
        $user->locale('bank_account');
        return responseJson(
            (new DoctorResource($request->user()->refresh()))->jsonSerialize(),
            __('Locale Updated Successfully'),
        );
    }
}
