<?php

namespace App\Repositories\SQL;

use App\Models\Doctor;
use App\Repositories\SQL\BaseRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\UserRepository;
use App\Models\User;
use Illuminate\Support\Facades\Log;

// use App\Validators\UserValidator;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Repositories\SQL;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param Request $request
     * @return User
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create($attributes): User
    {
        DB::beginTransaction();

        if (isset($attributes['image'])) {
            $attributes['image'] = saveFile($attributes['image'], 'users');
        }
        $User = parent::create($attributes);

        DB::commit();

        return $User->fresh();
    }

    public function update(array $attributes, $id)
    {
        if (isset($attributes['image'])) {
            $attributes['image'] = saveFile($attributes['image'], 'users');
        }
        return parent::update($attributes, $id);
    }
    /**
     * @param float $code
     * @return User
     */
    public function verify($code): ?User
    {
        return $this->whereHas(
            'verficationCodes',
            fn($q) => $q->isValid()->where('code', $code),
        )->first();
    }

    /**
     * AddFCM
     *
     * @param  mixed $user
     * @param  mixed $fcm_data
     * @return void
     */
    public function AddFCM(User $user, string $fcm_data, String $platform = null , String $voip = null): void
    {
        $user->fcm_token()->updateOrCreate([
            'notifiable_id' => $user->id,
        ],[
            'token' => $fcm_data,
            'platform' => $platform,
            'voip' => $voip,
            'user_agent' => request()->headers->get('User-Agent'),
        ]);
    }

    public function generateResetCode(): int
    {
        $code = randNumber();

        if ($this->count(['reset_password_code' => $code]) != 0) {
            $this->generateResetCode();
        }
        return $code;
    }

    public function socialAuthentication()
    {
    }
}
