<?php

namespace App\Repositories\SQL;

use App\Repositories\SQL\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\PatientRepository;
use App\Models\Patient;
// use App\Validators\PatientValidator;

/**
 * Class PatientRepositoryEloquent.
 *
 * @package namespace App\Repositories\SQL;
 */
class PatientRepositoryEloquent extends BaseRepository implements
    PatientRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Patient::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
