<?php

namespace App\Repositories\SQL;

use App\Models\Doctor;
use App\Models\Schedule;
use App\Repositories\SQL\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\DoctorRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Prettus\Repository\Events\RepositoryEntityDeleted;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class DoctorRepositoryEloquent.
 *
 * @package namespace App\Repositories\SQL;
 */
class DoctorRepositoryEloquent extends BaseRepository implements
    DoctorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Doctor::class;
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
    public function create($attributes): Doctor
    {
        DB::beginTransaction();

        if (isset($attributes['image'])) {
            $attributes['image'] = saveFile($attributes['image'], 'admins');
        }
        if (isset($attributes['signature'])) {
            $attributes['signature'] = saveFile(
                $attributes['signature'],
                'admins',
            );
        }
        $doctor = parent::create($attributes);

        DB::commit();

        return $doctor->fresh();
    }

    public function update(array $attributes, $id)
    {

        if (isset($attributes['image'])) {
            $attributes['image'] = saveFile($attributes['image'], 'admins');
        }
        if (isset($attributes['signature'])) {
            $attributes['signature'] = saveFile(
                $attributes['signature'],
                'admins',
            );
        }
        return parent::update($attributes, $id);
    }

    /*
     * @param  mixed $user
     * @param  mixed $fcm_data
     * @return void
     */
    public function AddFCM(Doctor $user, string $fcm_data, String $platform = null , String $voip = null): void
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

    public function isPending()
    {
        return $this->scopeQuery(fn($q) => $q->isPending());
    }

    public function isActive()
    {
        return $this->scopeQuery(fn($q) => $q->isActive());
    }

    public function getSchedule(Doctor $doctor)
    {
        return $doctor->getSchedule();
    }

    /**
     * Delete a entity in repository by id
     *
     * @param $id
     *
     * @return int
     */
    public function delete($id)
    {
        $this->applyScope();

        $temporarySkipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);

        $model = $this->withCount('reservation')->find($id);

        if ($model->reservation_count != 0) {
            throw ValidationException::withMessages([
                'id' => __("Can't Delete Doctor Have Reservations before"),
            ]);
        }
        $originalModel = clone $model;

        $this->skipPresenter($temporarySkipPresenter);
        $this->resetModel();

        $deleted = $model->delete();

        event(new RepositoryEntityDeleted($this, $originalModel));

        return $deleted;
    }

    public function PeriodPrice($doctor_id): float
    {
        return parent::find($doctor_id, 'price')->price;
    }

    public function verify($code): ?Doctor
    {
        $doctor = $this->whereHas(
            'verficationCodes',
            fn($q) => $q->isValid()->where('code', $code),
        )->first();

        return $doctor;
    }
}
