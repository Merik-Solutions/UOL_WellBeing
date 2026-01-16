<?php

namespace App\Repositories\SQL;

use App\Models\Patient;
use App\Repositories\SQL\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\AuthModelProviderRepository;
use App\Models\AuthModelProvider;

// use App\Validators\AuthModelProviderValidator;

/**
 * Class AuthModelProviderRepositoryEloquent.
 *
 * @package namespace App\Repositories\SQL;
 */
class AuthModelProviderRepositoryEloquent extends BaseRepository implements
    AuthModelProviderRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AuthModelProvider::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param \Laravel\Socialite\Contracts\User $user
     * @param array $name_arr
     * @param $provider
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function storePatientAuthProvider(
        \Laravel\Socialite\Contracts\User $user,
        $provider,
    ): Patient {
        DB::beginTransaction();
        $patient = $this->setPatient($user);
        $this->StoreAvatar($user, $patient);

        $this->storeProvider($patient, $user, $provider);

        DB::commit();
        return $patient->fresh();
    }

    /**
     * @param \Laravel\Socialite\Contracts\User $user
     * @param $patient
     */
    public function StoreAvatar(
        \Laravel\Socialite\Contracts\User $user,
        $patient,
    ): void {
        $fileContents = file_get_contents($user->getAvatar());
        $pic = '/patients/' . time() . $user->getId() . '.jpg';
        File::put(storage_path('app/public') . $pic, $fileContents);

        $img = $patient->image()->updateOrCreate(
            ['type' => 1],
            [
                'file' => '/storage' . $pic,
                'ext' => 'jpg',
            ],
        );
    }

    /**
     * @param $patient
     * @param \Laravel\Socialite\Contracts\User $user
     * @param $provider
     */
    public function storeProvider(
        $patient,
        \Laravel\Socialite\Contracts\User $user,
        $provider,
    ): AuthModelProvider {
        return $patient->providers()->UpdateOrCreate(
            ['provider_id' => $user->getId()],
            [
                'provider' => $provider,
                'token' => $user->token,
                'expires_in' => $user->expiresIn ?? null,
                'refresh_token' => $user->refreshToken ?? null,
            ],
        );
    }

    /**
     * @param \Laravel\Socialite\Contracts\User $user
     * @param array $name_arr
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function setPatient(\Laravel\Socialite\Contracts\User $user): Patient
    {
        $name_arr = explode(' ', $user->getName());
        return Patient::query()->updateOrCreate(
            ['email' => $user->getEmail()],
            [
                'username' => $user->getName(),
                'first_name' => $name_arr[0] ?? null,
                'last_name' => $name_arr[1] ?? null,
                'email' => $user->getEmail(),
                'password' => Str::random(9),
            ],
        );
    }
}
