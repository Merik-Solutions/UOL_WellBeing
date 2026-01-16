<?php

namespace App\Http\Controllers\Api\v1\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UserRequest;
use App\Http\Resources\users\UserResource;
use App\Models\Patient;
use App\Models\User;
use App\Models\VerficationCode;
use App\Repositories\interfaces\AuthModelProviderRepository;
use App\Repositories\interfaces\UserRepository;
use App\Rules\CheckPassword;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public $repo;

    public function __construct(UserRepository $repo)
    {
        $this->middleware('auth:api', [
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
        auth()->setDefaultDriver('api');

        $this->repo = $repo;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(UserRequest $request)
    {
        $User = $this->repo->create($request->validated());

        $response = new UserResource($User);
        return responseJson($response, __('Added Successfully'));
    }

    public function update(Request $request)
    {
        $validated = array_filter(
            $request->validate([
                'name' => ['nullable', 'string'],
                'name_ar' => ['nullable', 'string'],
                'email' => [
                    'nullable',
                    'email:rfc,dns,spoof',
                    'unique:users,email,' . auth()->id(),
                ],
                'birthdate' => ['nullable', 'date', 'date_format:Y-m-d'],
                'gender' => ['nullable', 'integer', 'in:0,1'],
                'image' => ['nullable', 'image'],
            ]),
        );

        $user = $this->repo->update($request->all(), auth()->id());
        $user = (new UserResource($user))->jsonSerialize();
        return responseJson($user, __('Added Successfully'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function profile(Request $request)
    {
        return responseJson(new UserResource(auth()->user()));
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return responseJson(null, __('Successfully logged out'));
    }

    /**
     * send verification code to doctor
     * @param Request $request
     * @return JsonResponse
     */
    public function sendSMS(Request $request)
    {
        $request->validate([
            'phone' => [
                'required',
                'string',
                'phone:AE,EG,SA,BH',
                'regex:/^([0-9+])+$/',
                'regex:/^[+]/',
            ],
            'country_id' => ['nullable', 'integer', 'exists:countries,id'],
        ]);

        $user = $this->repo->firstOrCreate($request->only('phone'));
        $user->sendCode($request->only('phone'));
        return responseJson(
            ['code' => $user->verification_code],
            __('Code Send Successfully'),
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function verify(Request $request)
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

        $user = $this->repo->verify($request->code);

        $this->repo->AddFCM($user, $request->token,$request->platform,$request->voip);
        if (is_null($user)) {
            return responseJson(null, __('Unauthorized'), 401);
        }

        return responseJson(
            (new UserResource($user))->jsonSerialize() + [
                'token' => auth()->login($user),
            ],
            __('Verified Successfully'),
        );
    }

    public function updateFCM(Request $request){
        $this->validate($request, [
            'patient_id' => ['required'],
            'token' => ['required', 'string'],
        ]);

        $patient = Patient::find($request->patient_id);
        $user = $this->repo->find($patient->user_id);

        $this->repo->AddFCM($user, $request->token,$request->platform,$request->voip);
        if (is_null($user)) {
            return responseJson(null, __('Unauthorized'), 401);
        }

        return responseJson(__('FCM updated.'));
    }

    /**
     * send verification code to doctor
     * @param Request $request
     * @return JsonResponse
     */
    public function updatePhone(Request $request)
    {
        $data = $request->validate([
            'new_phone' => [
                'required',
                'string',
                'unique:users,phone',
                'phone:AE,EG,SA,BH',
                'regex:/^([0-9+])+$/',
                'regex:/^[+]/',
            ],
        ]);

        /** @var  \App\Models\User $user */
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
     * @return JsonResponse
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
        VerficationCode::where('code', $request->code)->delete();
        return responseJson(
            (new UserResource($user->refresh()))->jsonSerialize() + [
                'token' => auth()->login($user),
            ],
            __('Verified Successfully'),
        );
    }

    public function updateLocale(Request $request)
    {
        $request->user()->update(['locale' => $request->input('locale')]);
        return responseJson(
            (new UserResource($request->user()->refresh()))->jsonSerialize(),
            __('Locale Updated Successfully'),
        );
    }
}
