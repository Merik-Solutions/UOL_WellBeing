<?php

namespace App\Repositories\interfaces;

use App\Models\AuthModelProvider;
use App\Models\Patient;
use App\Repositories\interfaces\BaseInterface;

/**
 * Interface AuthModelProviderRepository.
 *
 * @package namespace App\Repositories\interfaces;
 */
interface AuthModelProviderRepository extends BaseInterface
{
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
    ): Patient;

    /**
     * @param \Laravel\Socialite\Contracts\User $user
     * @param $patient
     */
    public function StoreAvatar(
        \Laravel\Socialite\Contracts\User $user,
        $patient,
    ): void;
    /**
     * @param $patient
     * @param \Laravel\Socialite\Contracts\User $user
     * @param $provider
     */
    public function storeProvider(
        $patient,
        \Laravel\Socialite\Contracts\User $user,
        $provider,
    ): AuthModelProvider;

    /**
     * @param \Laravel\Socialite\Contracts\User $user
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function setPatient(
        \Laravel\Socialite\Contracts\User $user,
    ): Patient;
}
