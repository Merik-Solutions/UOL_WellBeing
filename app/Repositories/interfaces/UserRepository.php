<?php

namespace App\Repositories\interfaces;

use App\Models\User;
use App\Repositories\interfaces\BaseInterface;
use Illuminate\Http\Request;

/**
 * Interface UserRepository.
 *
 * @package namespace App\Repositories\interfaces;
 */
interface UserRepository extends BaseInterface
{
    /**
     * Save a new entity in repository
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * Update a entity in repository by id
     *
     * @param array $attributes
     * @param       $id
     *
     * @return mixed
     */
    public function update(array $attributes, $id);
    /**
     * @param float $code
     * @return User
     */
    public function verify(float $code): ?User;

    /**
     * @param Request $request
     * @param int $id
     * @return User
     */

    public function AddFCM(User $user, string $fcm_data , String $platform=null , String $voip=null): void;

    /**
     * generate unique reset code
     * @return int
     */
    public function generateResetCode(): int;

    public function socialAuthentication();
}
